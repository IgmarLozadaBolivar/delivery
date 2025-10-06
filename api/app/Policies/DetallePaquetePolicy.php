<?php

namespace App\Policies;

use App\Models\DetallePaquete;
use App\Models\Paquete;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetallePaquetePolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, DetallePaquete $detallePaquete): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->camionero
            && $detallePaquete->paquete->camionero_id === $user->camionero->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, DetallePaquete $detallePaquete): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, DetallePaquete $detallePaquete): bool
    {
        return $user->hasRole('admin');
    }
}
