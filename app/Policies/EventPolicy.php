<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Verifica si el usuario tiene acceso a la agenda.
     * Solo super_admin y coordinador.
     */
    protected function hasAgendaAccess(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'coordinador']);
    }

    public function viewAny(User $user): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function view(User $user, Event $event): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function create(User $user): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function update(User $user, Event $event): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function delete(User $user, Event $event): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function forceDelete(User $user, Event $event): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function restore(User $user, Event $event): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function restoreAny(User $user): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function replicate(User $user, Event $event): bool
    {
        return $this->hasAgendaAccess($user);
    }

    public function reorder(User $user): bool
    {
        return $this->hasAgendaAccess($user);
    }
}
