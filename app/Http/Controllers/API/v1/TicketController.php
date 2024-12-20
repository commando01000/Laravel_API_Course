<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Filters\v1\TicketFilters;
use App\Models\Ticket;
use App\Http\Requests\API\v1\StoreTicketRequest;
use App\Http\Requests\API\v1\UpdateTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Traits\ApiResponses;

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
        //
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
