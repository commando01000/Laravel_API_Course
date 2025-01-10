<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\API\v1\APIController;
use App\Http\Filters\v1\TicketFilters;
use App\Http\Filters\v1\UserFilters;
use App\Http\Requests\API\v1\StoreuserRequest;
use App\Http\Requests\API\v1\UpdateuserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use App\Models\user;
use App\Traits\ApiResponses;
use Exception;

class UserController extends APIController
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilters $filters)
    {
        if ($this->include('tickets')) {
            return UserResource::collection(User::with('tickets')->filter($filters)->paginate());
        } else {
            return UserResource::collection(User::filter($filters)->paginate());
        }
    }

    public function tickets($user_id, TicketFilters $filters)
    {
        return TicketResource::collection(User::find($user_id)->tickets()->filter($filters)->paginate());
    }

    public function destroyUserTicket($author_id, $ticket_id)
    {
        try {
            $ticket = Ticket::findorFail($ticket_id); // Find the ticket by ID

            if ($ticket->user_id != $author_id) {
                return $this->errorResponse('You are not authorized to delete this ticket', 403);
            } else {
                $user = User::findorFail($author_id);
                $user->tickets()->detach($ticket_id);
            }
            return $this->successResponse('Ticket deleted successfully', [], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreuserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        if ($this->include('tickets')) {
            return new UserResource($user->load('tickets'));
        } else {
            return new UserResource($user);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateuserRequest $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        try {
            $user = User::findorFail($user_id); // Find the user by ID
            $user->delete(); // Delete the user
            return $this->successResponse('User deleted successfully', [], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
