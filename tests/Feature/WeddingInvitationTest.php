<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WeddingInvitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeddingInvitationTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_replace_recursive([
            'intent' => 'save',
            'return_step' => 1,
            'enable_english' => false,
            'groom_name_ar' => 'أحمد عبد الله',
            'bride_name_ar' => 'سارة محمود',
            'couple_note_ar' => 'عائلتان وفرحة واحدة',
            'invitation_content' => [
                'title_ar' => 'دعوة زفاف',
                'message_ar' => 'يسرنا دعوتكم لمشاركتنا فرحة العمر.',
            ],
            'event_details' => [
                'wedding_date' => '2027-06-18',
                'wedding_time' => '18:30',
                'venue_name_ar' => 'قاعة الياسمين',
                'venue_address_ar' => 'رام الله',
                'maps_url' => 'https://maps.google.com/?q=Ramallah',
            ],
            'design_settings' => config('invitations.default_design'),
            'template_key' => 'classic_royal',
        ], $overrides);
    }

    public function test_guests_cannot_access_the_studio_or_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/invitations/create')->assertRedirect('/login');
        $this->post('/invitations', $this->payload())->assertRedirect('/login');
    }

    public function test_a_user_can_create_an_arabic_only_draft(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/invitations', $this->payload([
            'return_step' => 3,
            'enable_english' => true,
        ]));

        $invitation = WeddingInvitation::sole();

        $response->assertRedirect(route('invitations.edit', [
            'invitation' => $invitation,
            'step' => 3,
        ]));

        $this->assertSame($user->id, $invitation->user_id);
        $this->assertSame(WeddingInvitation::STATUS_DRAFT, $invitation->status);
        $this->assertTrue($invitation->enable_english);
        $this->assertNull($invitation->groom_name_en);
        $this->assertNull($invitation->bride_name_en);
        $this->assertNotEmpty($invitation->slug);
        $this->assertMatchesRegularExpression('/^[a-z0-9-]+$/', $invitation->slug);
        $this->assertDatabaseHas('wedding_invitations', [
            'id' => $invitation->id,
            'status' => WeddingInvitation::STATUS_DRAFT,
        ]);
    }

    public function test_publishing_on_save_requires_wedding_details(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/invitations', $this->payload([
            'intent' => 'publish',
            'event_details' => [
                'wedding_date' => null,
                'wedding_time' => null,
                'venue_name_ar' => null,
            ],
        ]));

        $response->assertSessionHasErrors([
            'event_details.wedding_date',
            'event_details.wedding_time',
            'event_details.venue_name_ar',
        ]);
        $this->assertDatabaseCount('wedding_invitations', 0);
    }

    public function test_a_user_can_publish_an_invitation_on_save(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/invitations', $this->payload([
            'intent' => 'publish',
            'return_step' => 5,
        ]));

        $invitation = WeddingInvitation::sole();

        $response->assertRedirect(route('invitations.edit', [
            'invitation' => $invitation,
            'step' => 6,
        ]));

        $this->assertSame(WeddingInvitation::STATUS_PUBLISHED, $invitation->status);
        $this->assertNotNull($invitation->published_at);

        $resource = (new \App\Http\Resources\WeddingInvitationResource($invitation))->resolve();
        $this->assertNotNull($resource['public_url']);
        $this->assertNotNull($resource['calendar_url']);
    }

    public function test_a_user_can_update_and_unpublish_their_own_invitation(): void
    {
        $user = User::factory()->create();
        $invitation = WeddingInvitation::factory()->published()->create([
            'user_id' => $user->id,
            'slug' => 'ahmad-sara',
        ]);

        $this->actingAs($user)
            ->put("/invitations/{$invitation->id}", $this->payload([
                'groom_name_ar' => 'أحمد الجديد',
                'bride_name_ar' => 'سارة الجديدة',
                'slug' => 'ahmad-sara',
            ]))
            ->assertRedirect(route('invitations.edit', [
                'invitation' => $invitation,
                'step' => 1,
            ]));

        $invitation->refresh();

        $this->assertSame('أحمد الجديد', $invitation->groom_name_ar);
        $this->assertSame(WeddingInvitation::STATUS_PUBLISHED, $invitation->status);

        $this->actingAs($user)
            ->post("/invitations/{$invitation->id}/unpublish")
            ->assertRedirect();

        $this->assertSame(WeddingInvitation::STATUS_UNPUBLISHED, $invitation->fresh()->status);
    }

    public function test_another_user_cannot_view_update_publish_or_delete_an_invitation(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $invitation = WeddingInvitation::factory()->published()->create([
            'user_id' => $owner->id,
            'slug' => 'private-wedding',
        ]);

        $this->actingAs($intruder)->get("/invitations/{$invitation->id}/edit")->assertForbidden();
        $this->actingAs($intruder)->get("/invitations/{$invitation->id}/preview")->assertForbidden();
        $this->actingAs($intruder)->put("/invitations/{$invitation->id}", $this->payload())->assertForbidden();
        $this->actingAs($intruder)->post("/invitations/{$invitation->id}/publish")->assertForbidden();
        $this->actingAs($intruder)->post("/invitations/{$invitation->id}/unpublish")->assertForbidden();
        $this->actingAs($intruder)->delete("/invitations/{$invitation->id}")->assertForbidden();

        $this->assertDatabaseHas('wedding_invitations', ['id' => $invitation->id]);
    }

    public function test_public_invitation_is_visible_locally_only_when_published(): void
    {
        $published = WeddingInvitation::factory()->published()->create([
            'slug' => 'public-wedding',
            'views_count' => 4,
        ]);
        $draft = WeddingInvitation::factory()->create(['slug' => 'draft-wedding']);
        $unpublished = WeddingInvitation::factory()->unpublished()->create(['slug' => 'hidden-wedding']);

        $this->get('/w/public-wedding')->assertOk();
        $this->assertSame(5, $published->fresh()->views_count);

        $this->get('/w/draft-wedding')->assertNotFound();
        $this->get('/w/hidden-wedding')->assertNotFound();
        $this->assertSame(0, $draft->fresh()->views_count);
        $this->assertSame(0, $unpublished->fresh()->views_count);
    }

    public function test_published_invitation_exposes_a_calendar_download(): void
    {
        $invitation = WeddingInvitation::factory()->published()->create([
            'slug' => 'calendar-wedding',
        ]);

        $response = $this->get("/w/{$invitation->slug}/calendar.ics");

        $response->assertOk();
        $response->assertHeader('content-type', 'text/calendar; charset=UTF-8');
        $this->assertStringContainsString('BEGIN:VCALENDAR', $response->getContent());
        $this->assertStringContainsString('SUMMARY:حفل زفاف', $response->getContent());

        $draft = WeddingInvitation::factory()->create(['slug' => 'calendar-draft']);
        $this->get("/w/{$draft->slug}/calendar.ics")->assertNotFound();
    }

    public function test_publish_action_refuses_an_incomplete_invitation(): void
    {
        $user = User::factory()->create();
        $invitation = WeddingInvitation::factory()->create([
            'user_id' => $user->id,
            'status' => WeddingInvitation::STATUS_DRAFT,
            'event_details' => [
                'wedding_date' => null,
                'wedding_time' => null,
                'venue_name_ar' => null,
            ],
        ]);

        $this->actingAs($user)
            ->post("/invitations/{$invitation->id}/publish")
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame(WeddingInvitation::STATUS_DRAFT, $invitation->fresh()->status);
    }

    public function test_slug_is_generated_from_arabic_names_when_omitted(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/invitations', $this->payload([
            'groom_name_ar' => 'محمد',
            'bride_name_ar' => 'لينا',
        ]));

        $this->assertDatabaseCount('wedding_invitations', 1);
        $this->assertStringStartsWith('mhmd-lyna', WeddingInvitation::sole()->slug);
    }

    public function test_invitation_persists_the_lead_line_and_extended_envelope_styles(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/invitations', $this->payload([
            'invitation_content' => [
                'invite_line_ar' => 'يتشرفان بدعوة سيادتكم',
            ],
            'design_settings' => [
                'envelope_style' => 'arabesque',
            ],
        ]))->assertRedirect();

        $invitation = WeddingInvitation::sole();

        $this->assertSame('يتشرفان بدعوة سيادتكم', $invitation->invitation_content['invite_line_ar']);
        $this->assertSame('arabesque', $invitation->design_settings['envelope_style']);
    }

    public function test_unknown_envelope_styles_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/invitations', $this->payload([
            'design_settings' => [
                'envelope_style' => 'not-a-real-envelope',
            ],
        ]))->assertSessionHasErrors('design_settings.envelope_style');

        $this->assertDatabaseCount('wedding_invitations', 0);
    }
}
