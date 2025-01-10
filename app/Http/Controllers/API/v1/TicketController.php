<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Filters\v1\TicketFilters;
use App\Models\Ticket;
use App\Http\Requests\API\v1\StoreTicketRequest;
use App\Http\Requests\API\v1\UpdateTicketRequest;
use App\Http\Requests\ReplaceTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Exception;

class TicketController extends APIController
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilters $filters)
    {
        // if ($this->include('author')) {
        //     return TicketResource::collection(Ticket::with('user')->get());
        // }
        // return TicketResource::collection(Ticket::all());

        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try {
            $user = User::findorFail($request->input('data.relationships.author.data.id'));

            // Extract Attributes

            $model = [
                'user_id' => $user->id,
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'status' => $request->input('data.attributes.status'),
            ];
            return $this->successResponse('Ticket created successfully', TicketResource::make(Ticket::create($model)), 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket_id)
    {
        try {

            $ticket = Ticket::findorFail($ticket_id);

            if ($this->include('author')) {
                return new TicketResource($ticket->load('user'));
            } else {
                return new TicketResource($ticket);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        //
    }

    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        try {
            $ticket = Ticket::findorFail($ticket_id);
            $user = User::findorFail($request->input('data.relationships.author.data.id'));
            $ticket->user_id = $user->id;
            $ticket->title = $request->input('data.attributes.title');
            $ticket->description = $request->input('data.attributes.description');
            $ticket->status = $request->input('data.attributes.status');
            $ticket->save();
            return $this->successResponse('Ticket updated successfully', TicketResource::make($ticket), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try {
            $ticket = Ticket::findorFail($ticket_id); // Find the ticket by ID
            $ticket->delete(); // Delete the ticket
            return $this->successResponse('Ticket deleted successfully', [], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
