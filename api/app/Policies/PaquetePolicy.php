<?php

namespace App\Policies;

use App\Models\Camionero;
use App\Models\Paquete;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaquetePolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function view(User $user, Paquete $paquete): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->camionero && $paquete->camionero_id === $user->camionero->id;
    }

    public function update(User $user, Paquete $paquete): bool
    {
        if ($user->hasRole('admin')) {
            return $user->hasRole('admin');
        }

        return $user->camionero && $paquete->camionero_id === $user->camionero->id;
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
