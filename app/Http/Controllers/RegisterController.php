<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailExistsRequest;
use App\Http\Requests\PasswordRequest;
use App\Mail\ResetPassword;
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
    public function register(Employee $employee)
    {
        $user = User::create([
            'email' => $employee->email_address,
            'employee_id' => $employee->id
        ]);

        $verify = DB::table('password_resets')->where([
            ['email', $user->email]
        ]);

        if ($verify->exists()) {
            $verify->delete();
        }

        $pin = rand(100000, 999999);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $pin
        ]);

        $encrypt = Crypt::encrypt([
            'email' => $user->email,
            'pin' => $pin,
        ]);

        $urlWithToken = env('FRONTEND_URL') . '/new/password/' . $encrypt;

        // Send confirmation email
        Mail::to($user->email)->send(new VerifyEmail($urlWithToken));

        return response()->json([
            'success' => true,
            'code' => 'CONFIRMATION_EMAIL',
            'message' => 'Successful created user. Please check your email for link to verify your email.'
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
                    "code" => 'TOKEN_REQUIRED'
                ], Response::HTTP_BAD_REQUEST);
            }

            $decrypt = Crypt::decrypt($request->token);

            $select = DB::table('password_resets')
                ->where('email', $decrypt['email'])
                ->where('token', $decrypt['pin']);

            if ($select->get()->isEmpty()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Invalid PIN.',
                        'code' => 'INVALID_PIN' // INVALID_PIN
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            $difference = Carbon::now()->diffInDays($select->first()->created_at);

            // when passed more than 4 days
            if ($difference > 4) {
                $select->delete();
                return response()->json([
                    'success' => false,
                    'message' => "Token Expired",
                    'code' => 'TOKEN_EXPIRED' // TOKEN_EXPIRED
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => "You can now reset your password",
                    'code' => 'RESET_PASSWORD' // RESET_PASSWORD
                ],
                Response::HTTP_OK
            );
        } catch (DecryptException $th) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
                'code' => 'INVALID_TOKEN' // INVALID_TOKEN
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function verifyEmail(PasswordRequest $request)
    {
        $decrypt = Crypt::decrypt($request->validated()['token']);

        $user = User::where([
            'email' => $decrypt['email']
        ])->first();

        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->password = bcrypt($request->validated()['password']);
        $user->save();

        $select = DB::table('password_resets')
            ->where('email', $decrypt['email'])
            ->where('token', $decrypt['pin']);

        $select->delete();

        return response()->json([
            'success' => true,
            'message' => "Verified account",
            'code' => 'VERIFIED_ACCOUNT' // VERIFIED_ACCOUNT
        ], Response::HTTP_OK);
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

        $pin = random_int(100000, 999999);
        $password_reset = DB::table('password_resets')->insert([
            'email' => $request->all()['email'],
            'token' =>  $pin,
            'created_at' => Carbon::now()
        ]);

        if ($password_reset) {

            $encrypt = Crypt::encrypt([
                'email' => $email,
                'pin' => $pin,
            ]);

            $urlWithToken = env('FRONTEND_URL') . '/reset/password/' . $encrypt;

            Mail::to($email)->send(new ResetPassword($urlWithToken));

            return response()->json(
                [
                    'success' => true,
                    'message' => "A verification mail has been resent",
                    'code' => "CONFIRMATION_EMAIL"
                ],
                Response::HTTP_OK
            );
        }
    }
}
