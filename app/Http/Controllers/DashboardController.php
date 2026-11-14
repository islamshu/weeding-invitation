<?php

namespace App\Http\Controllers;

use App\Http\Resources\WeddingInvitationResource;
use App\Models\WeddingInvitation;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $user = request()->user();

        $invitations = $user->invitations()
            ->latest()
            ->get()
            ->map(fn (WeddingInvitation $invitation) => (new WeddingInvitationResource($invitation))->resolve());

        return Inertia::render('Dashboard', [
            'invitations' => $invitations,
            'stats' => [
                'total' => $invitations->count(),
                'published' => $invitations->where('status', WeddingInvitation::STATUS_PUBLISHED)->count(),
                'drafts' => $invitations->where('status', WeddingInvitation::STATUS_DRAFT)->count(),
                'unpublished' => $invitations->where('status', WeddingInvitation::STATUS_UNPUBLISHED)->count(),
                'views' => (int) $invitations->sum('views_count'),
            ],
        ]);
    }
}
