<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailExistsRequest;
use App\Mail\VerifyEmail;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register($employee_id) {
        
        $employee = Employee::find($employee_id);

        $user = User::create([
            'email' => $employee->email_address,
            'employee_id' => $employee->id
        ]);

        if($user) {
            $verify = DB::table('password_resets')->where([
                ['email', $user->email]
            ]);

            if($verify->exists()) {
                $verify->delete();
            }

            $pin = rand(100000, 999999);

            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $pin
            ]);
        } 

        $urltoken = Crypt::encrypt([
            'email' => $user->email,
            'pin' => $pin,
        ]);

        // Enviar correo de confirmacion
        Mail::to($user->email)->send(new VerifyEmail(env('FRONTEND_URL').'/new/password/'.$urltoken));

        return response()->json([
            'success' => true,
            'message' => 'Successful created user. Please check your email for a 6-digit pin to verify your email.'
        ], Response::HTTP_CREATED);
        
    }

    public function verifyPin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token required',
                ], Response::HTTP_BAD_REQUEST);
            }

            $decrypt = Crypt::decrypt($request->token);

            $select = DB::table('password_resets')
            ->where('email', $decrypt->email)
            ->where('token', $decrypt->token);

            if($select->get()->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Invalid PIN.'], Response::HTTP_BAD_REQUEST);
            }

            $difference = Carbon::now()->diffInDays($select->first()->created_at);
            
            $select->delete();

            // when passed more than 4 days
            if ($difference > 4) {
                return response()->json(['success' => false, 'message' => "Token Expired"], Response::HTTP_NOT_FOUND);
            }

            return response()->json(
                [
                    'success' => true, 
                    'message' => "You can now set/reset your password"
                ], 
                Response::HTTP_OK
            );

        } catch (DecryptException $th) {
            return response()->json(['success' => false, 'message' => 'Invalid token.'], Response::HTTP_BAD_REQUEST);
        }
        
    }

    public function verifyEmail(Request $request) {
        $decrypt = Crypt::decrypt($request->token);

        $user = User::find($decrypt->email);

        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->save();

        return response()->json(['success' => true, 'message' => "Verified account"], Response::HTTP_OK);

    }

    public function resendPin(EmailExistsRequest $request)
    {
        $email = $request->validated()['email'];
           
        $verify = DB::table('password_resets')->where([
            ['email', $email]
        ]);

        if ($verify->exists()) {
            $verify->delete();
        }

        $token = random_int(100000, 999999);
        $password_reset = DB::table('password_resets')->insert([
            'email' => $request->all()['email'],
            'token' =>  $token,
            'created_at' => Carbon::now()
        ]);

        if ($password_reset) {
            Mail::to($request->all()['email'])->send(new VerifyEmail($token));

            return response()->json(
                [
                    'success' => true, 
                    'message' => "A verification mail has been resent"
                ], 
                Response::HTTP_OK
            );
        }
    }
}
