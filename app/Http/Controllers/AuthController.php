<?php

namespace App\Http\Controllers;

// use App\Enum\AuthEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
        $this->middleware(['auth:api'], ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::firstWhere('email', $request['email']);

        if($user->email_verified_at) {
            $access_token = auth()->claims([ 'employee_id' =>  $user->employee_id])
            ->setTTL(7*24*60) // To expire in one week (in minutes)
            ->attempt($request->validated());

            if ($access_token) {
                return $this->respondWithToken($access_token);
            }

            return response()->json(new InvalidAttributeCollection([
                [
                    "attribute" => "password",
                    "error" => "Password not match"
                ]
            ]), Response::HTTP_BAD_REQUEST);
        }

        return response()->json(new InvalidAttributeCollection([
            [
                "attribute" => "email",
                "error" => "Email isn't verified."
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

        return response()->json([
            "success" => true,
            'message' => 'Successfully logged out',
            "code" => "LOGOUT" // LOGOUT
        ], Response::HTTP_OK);
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
            "success" => true,
            "code" => "LOGGED", // LOGGED
            "message" => "Successfully logged in",
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // (in seconds)
        ]);
    }

}