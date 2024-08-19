<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function view(User $user, Product $product)
    {
        return $user->role === 'admin' || $user->role === 'seller' || $user->role === 'costumer';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Product $product)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Product $product)
    {
        return $user->role === 'admin';
    }
}