<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\API\v1\APIController;
use App\Http\Filters\v1\TicketFilters;
use App\Http\Filters\v1\UserFilters;
use App\Http\Requests\API\v1\StoreuserRequest;
use App\Http\Requests\API\v1\UpdateuserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\v1\TicketResource;
use App\Models\user;

class UserController extends APIController
{
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
    public function destroy(user $user)
    {
        //
    }
}
