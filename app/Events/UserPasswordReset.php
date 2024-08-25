<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPasswordReset
{
    use Dispatchable, SerializesModels;

    public $user;
    public $newPassword;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param string $newPassword
     */
    public function __construct(User $user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }
}

