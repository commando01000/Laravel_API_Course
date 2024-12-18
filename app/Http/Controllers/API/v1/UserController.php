<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\StoreuserRequest;
use App\Http\Requests\API\v1\UpdateuserRequest;
use App\Http\Resources\UserResource;
use App\Models\user;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::paginate());
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
        return new UserResource($user);
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
