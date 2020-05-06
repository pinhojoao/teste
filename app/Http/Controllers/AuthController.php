<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
     /**
     * Create user
     *
     * @param  AuthFormRequest $request
     * @return [string] message
     */
    public function signup(AuthFormRequest $request)
    {
        $attributes = $request->validated();
        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password'])
        ]);        

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  AuthFormRequest $request
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(AuthFormRequest $request)
    {
        $attributes = $request->validated();
        $credentials = [
            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);        
        }

        $user = $request->user();        
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;        

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);        
        }

        $token->save();        
        
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(AuthFormRequest $request)
    {
        $request->user()->token()->revoke();        
        
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] User object
     */
    public function user(AuthFormRequest $request)
    {
        return response()->json($request->user());
    }   
}
