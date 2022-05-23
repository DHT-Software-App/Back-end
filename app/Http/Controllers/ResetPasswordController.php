<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return new JsonResponse([
                'success' => false, 
                'message' => $validator->errors(),
                'code' => 'RESET_PASSWORD'
            ], 422);
        }

        $user = User::where('email',$request->email);
        $user->update([
            'password'=>Hash::make($request->password)
        ]);

        // $token = $user->first()->createToken('myapptoken')->plainTextToken;

        return new JsonResponse(
            [
                'success' => true, 
                'message' => "Your password has been reset", 
                'code' => 'RESET_PASSWORD',
                // 'token'=>$token
            ], 
            200
        );
    }
}
