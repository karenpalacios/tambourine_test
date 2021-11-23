<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;



class RegisterController extends Controller
{

    use ApiResponse;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */

    /**
     * Creates a new user.
     *
     * @param  array  $request
     * @return \App\Traits\ApiResponse
     */
    protected function register(Request $request)
    {
        //validate incoming request.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);

        $user  = User::where('email', $request->email)->first();

        if ($user) {
            throw ValidationException::withMessages([
                'email' => ['The provided email already exists.'],
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success([
            'token' =>  $token
        ],'The user '.$request->email.' has been registered successfully.');
    }

}
