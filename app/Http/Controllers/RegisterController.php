<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyEmail;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

        // Enviar correo de confirmacion
        Mail::to($user->email)->send(new VerifyEmail($pin));

        return response()->json([
            'success' => true,
            'message' => 'Successful created user. Please check your email for a 6-digit pin to verify your email.'
        ], Response::HTTP_CREATED);
    }

    public function verifyEmail(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['message' => $validator->errors()]);
        }

        $select = DB::table('password_resets')
            ->where('email', Auth::user()->email)
            ->where('token', $request->token);

        if ($select->get()->isEmpty()) {
            return response()->json(['success' => false, 'message' => "Invalid PIN"], 400);
        }

        $select = DB::table('password_resets')
            ->where('email', Auth::user()->email)
            ->where('token', $request->token)
            ->delete();

        $user = User::find(Auth::user()->id);
        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->save();

        return response()->json(['success' => true, 'message' => "Email is verified"], 200);

    }

    public function resendPin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return  response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $verify =  DB::table('password_resets')->where([
            ['email', $request->all()['email']]
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
                200
            );
        }
    }
}
