<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SalePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        // Admins e vendedores podem ver a lista de vendas
        return $user->role === 'admin' || $user->role === 'seller';
    }

    public function view(User $user, Sale $sale)
    {
        if ($user->role === 'admin' || $user->role === 'seller') {
            return true;
        }

        if ($user->role === 'costumer') {
            return $user->id === $sale->user_id;
        }

        return false;
    }

    public function create(User $user)
    {
        return $user->role === 'seller';
    }

    public function update(User $user, Sale $sale)
    {
        return $user->role === 'admin' || ($user->role === 'seller' && $user->id === $sale->user_id);
    }

    public function delete(User $user, Sale $sale)
    {
        return $user->role === 'admin' || ($user->role === 'seller' && $user->id === $sale->user_id);
    }
}
