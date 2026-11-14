<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeddingInvitation;

class WeddingInvitationPolicy
{
    public function view(User $user, WeddingInvitation $invitation): bool
    {
        return $invitation->user_id === $user->id;
    }

    public function update(User $user, WeddingInvitation $invitation): bool
    {
        return $invitation->user_id === $user->id;
    }

    public function delete(User $user, WeddingInvitation $invitation): bool
    {
        return $invitation->user_id === $user->id;
    }

    public function publish(User $user, WeddingInvitation $invitation): bool
    {
        return $invitation->user_id === $user->id;
    }
}
