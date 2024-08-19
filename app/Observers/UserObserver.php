<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    protected $validRoles = ['customer', 'seller', 'admin'];

    public function creating(User $user)
    {
        $this->validateRole($user);
    }

    public function updating(User $user)
    {
        $this->validateRole($user);
    }
    
    protected function validateRole(User $user)
    {
        if (!in_array($user->role, $this->validRoles)) {
            throw new \Exception('Invalid role');
        }
    }
}
