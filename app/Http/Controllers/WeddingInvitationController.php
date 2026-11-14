<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveWeddingInvitationRequest;
use App\Http\Resources\WeddingInvitationResource;
use App\Models\WeddingInvitation;
use App\Services\InvitationSlug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class WeddingInvitationController extends Controller
{
    public function __construct(private readonly InvitationSlug $slugs) {}

    public function create(): Response
    {
        return Inertia::render('Invitations/Create');
    }

    public function store(SaveWeddingInvitationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $publishing = $request->isPublishing();

        $invitation = WeddingInvitation::create([
            'user_id' => $request->user()->id,
            'slug' => $this->resolveSlug($request, $data),
            ...$this->contentAttributes($data),
            'status' => $publishing ? WeddingInvitation::STATUS_PUBLISHED : WeddingInvitation::STATUS_DRAFT,
            'published_at' => $publishing ? now() : null,
        ]);

        $invitation->forceFill($this->syncImages($request, $invitation))->save();

        return redirect()
            ->route('invitations.edit', [
                'invitation' => $invitation,
                'step' => $publishing ? 6 : $this->returnStep($data),
            ])
            ->with('success', $publishing ? __('messages.published') : __('messages.draft_saved'));
    }

    public function edit(Request $request, WeddingInvitation $invitation): Response
    {
        $this->authorize('update', $invitation);

        return Inertia::render('Invitations/Edit', [
            'invitation' => (new WeddingInvitationResource($invitation))->resolve(),
            'initialStep' => min(6, max(1, (int) $request->query('step', 1))),
        ]);
    }

    public function update(SaveWeddingInvitationRequest $request, WeddingInvitation $invitation): RedirectResponse
    {
        $this->authorize('update', $invitation);

        $data = $request->validated();

        $invitation->fill([
            'slug' => $this->resolveSlug($request, $data, $invitation),
            ...$this->contentAttributes($data),
        ]);

        if ($request->isPublishing()) {
            $invitation->status = WeddingInvitation::STATUS_PUBLISHED;
            $invitation->published_at = $invitation->published_at ?? now();
        }

        $invitation->forceFill($this->syncImages($request, $invitation))->save();

        if ($request->isPublishing()) {
            return redirect()
                ->route('invitations.edit', ['invitation' => $invitation, 'step' => 6])
                ->with('success', __('messages.published'));
        }

        $message = $invitation->isPublished() ? __('messages.saved') : __('messages.draft_saved');

        return redirect()
            ->route('invitations.edit', [
                'invitation' => $invitation,
                'step' => $this->returnStep($data),
            ])
            ->with('success', $message);
    }

    public function preview(WeddingInvitation $invitation): Response
    {
        $this->authorize('view', $invitation);

        return Inertia::render('Invitations/Preview', [
            'invitation' => (new WeddingInvitationResource($invitation))->resolve(),
        ]);
    }

    public function publish(WeddingInvitation $invitation): RedirectResponse
    {
        $this->authorize('publish', $invitation);

        if (! $this->isReadyToPublish($invitation)) {
            return back()->with('error', __('messages.publish_incomplete'));
        }

        $invitation->publish();

        return back()->with('success', __('messages.published'));
    }

    public function unpublish(WeddingInvitation $invitation): RedirectResponse
    {
        $this->authorize('publish', $invitation);

        $invitation->unpublish();

        return back()->with('success', __('messages.unpublished'));
    }

    public function destroy(WeddingInvitation $invitation): RedirectResponse
    {
        $this->authorize('delete', $invitation);

        $this->deleteImages($invitation);
        $invitation->delete();

        return redirect()->route('dashboard')->with('success', __('messages.deleted'));
    }

    /**
     * Keep the owner on the studio step they were editing when they saved.
     */
    private function returnStep(array $data): int
    {
        return min(6, max(1, (int) ($data['return_step'] ?? 6)));
    }

    private function resolveSlug(SaveWeddingInvitationRequest $request, array $data, ?WeddingInvitation $invitation = null): string
    {
        $custom = trim((string) ($data['slug'] ?? ''));

        if ($custom !== '') {
            return $this->slugs->unique($custom, $invitation?->id);
        }

        if ($invitation) {
            return $invitation->slug;
        }

        return $this->slugs->build(
            $data['groom_name_en'] ?? null,
            $data['bride_name_en'] ?? null,
            $data['groom_name_ar'] ?? null,
            $data['bride_name_ar'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function contentAttributes(array $data): array
    {
        return [
            'enable_english' => (bool) ($data['enable_english'] ?? false),
            'groom_name_ar' => $data['groom_name_ar'],
            'groom_name_en' => $data['groom_name_en'] ?? null,
            'bride_name_ar' => $data['bride_name_ar'],
            'bride_name_en' => $data['bride_name_en'] ?? null,
            'couple_note_ar' => $data['couple_note_ar'] ?? null,
            'couple_note_en' => $data['couple_note_en'] ?? null,
            'groom_wakil' => $data['groom_wakil'] ?? [],
            'bride_wakil' => $data['bride_wakil'] ?? [],
            'invitation_content' => $data['invitation_content'] ?? [],
            'event_details' => $data['event_details'] ?? [],
            'design_settings' => $data['design_settings'] ?? [],
            'template_key' => $data['template_key'] ?? 'classic_royal',
        ];
    }

    /**
     * @return array<string, string|null>
     */
    private function syncImages(Request $request, WeddingInvitation $invitation): array
    {
        $paths = [];

        foreach ([
            'cover_image' => 'cover_image_path',
            'background_image' => 'background_image_path',
            'decorative_image' => 'decorative_image_path',
        ] as $field => $column) {
            $existing = $invitation->{$column};
            $remove = $request->boolean('remove_'.$field);
            $file = $request->file($field);

            if ($file instanceof UploadedFile) {
                $this->deleteFile($existing);
                $paths[$column] = $file->store('invitations/'.$invitation->user_id, 'public');
            } elseif ($remove) {
                $this->deleteFile($existing);
                $paths[$column] = null;
            }
        }

        return $paths;
    }

    private function deleteImages(WeddingInvitation $invitation): void
    {
        $this->deleteFile($invitation->cover_image_path);
        $this->deleteFile($invitation->background_image_path);
        $this->deleteFile($invitation->decorative_image_path);
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function isReadyToPublish(WeddingInvitation $invitation): bool
    {
        $events = $invitation->event_details ?? [];

        return filled($invitation->groom_name_ar)
            && filled($invitation->bride_name_ar)
            && filled($events['wedding_date'] ?? null)
            && filled($events['wedding_time'] ?? null)
            && filled($events['venue_name_ar'] ?? null);
    }
}
