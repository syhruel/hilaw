<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserLastActive
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event saat user login.
     */
    public function handleLogin(Login $event): void
    {
        if ($event->user) {
            $event->user->update([
                'last_active_at' => now()
            ]);
        }
    }

    /**
     * Handle the event saat user logout.
     */
    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            $event->user->update([
                'last_active_at' => now()
            ]);
        }
    }
}