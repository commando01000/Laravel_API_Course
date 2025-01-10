<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Filters\v1\TicketFilters;
use App\Models\Ticket;
use App\Http\Requests\API\v1\StoreTicketRequest;
use App\Http\Requests\API\v1\UpdateTicketRequest;
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
    public function show(Ticket $ticket)
    {
        if ($this->include('author')) {
            return new TicketResource($ticket->load('user'));
        } else {
            return new TicketResource($ticket);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
