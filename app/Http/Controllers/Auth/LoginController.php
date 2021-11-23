<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

/*
|--------------------------------------------------------------------------
| Login Controller
|--------------------------------------------------------------------------
|
| This controller handles the authentication of users
|
*/
class LoginController extends Controller
{

    use ApiResponse;

    /**
     * Login user.
     *
     * @param  array  $request
     * @return \App\Traits\ApiResponse
     */
    public function login(Request $request)
    {
        //validate incoming request.
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user  = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->success($response,'Logged!',201);

    }
}
