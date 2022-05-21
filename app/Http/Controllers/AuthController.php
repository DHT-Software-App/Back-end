<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvalidAttributeCollection;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $validatedUser = User::firstWhere('email', $credentials['email']);

        // Email does not exist
        if(!$validatedUser) {
            return response()->json(new InvalidAttributeCollection([
                [
                    "attribute" => "email",
                    "error" => "Email does not exist"
                ]
            ]), Response::HTTP_BAD_REQUEST);
        }

        // Email does not verify yet
        if(!$validatedUser->email_verified_at) {
            return response()->json(new InvalidAttributeCollection([
                [
                    "attribute" => "email",
                    "error" => "You need to verify your email before accessing"
                ]
            ]), Response::HTTP_BAD_REQUEST);
        }


        $token = auth()->claims([ 'employee_id' =>  $validatedUser->employee_id])
        ->setTTL(7*24*60) // express in minutes
        ->attempt($credentials);

        if ($token) {
            return $this->respondWithToken($token);
        }

        return response()->json(new InvalidAttributeCollection([
            [
                "attribute" => "password",
                "error" => "Password not match"
            ]
        ]), Response::HTTP_BAD_REQUEST);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}