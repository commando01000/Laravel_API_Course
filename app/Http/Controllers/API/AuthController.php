<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponses as TraitsApiResponses;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use TraitsApiResponses;
    public function login(LoginRequest $request)
    {
        $request->validated($request->all());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            return $this->successResponse(
                'Successfully logged in',
                [
                    'token' => $user->createToken('auth_token' . $user->email)->plainTextToken,
                ],
            );
        } else {
            return $this->errorResponse('Invalid credentials', 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
