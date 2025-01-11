<?php

namespace App\Policies\v1;

use App\Models\Ticket;
use App\Models\User;
use Exception;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(User $user, Ticket $ticket)
    {
        // The user can update the ticket only if they are the owner.
        return $user->id === $ticket->user_id;
    }
}
