<?php

namespace App\Listeners;

use App\Events\UserPasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail
{
    /**
     * Handle the event.
     *
     * @param  UserPasswordReset  $event
     * @return void
     */
    public function handle(UserPasswordReset $event)
    {
        // Enviar o e-mail usando o Mail facade
        Mail::to($event->user->email)->send(new \App\Mail\PasswordResetMail($event->user, $event->newPassword));
    }
}
