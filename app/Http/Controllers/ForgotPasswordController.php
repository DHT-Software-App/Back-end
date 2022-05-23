<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailExistsRequest;
use App\Mail\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(EmailExistsRequest $request)
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
            'email' => $email,
            'token' =>  $pin,
            'created_at' => Carbon::now()
        ]);

        if ($password_reset) {
            $urltoken = Crypt::encrypt([
                'email' => $email,
                'pin' => $pin,
            ]);

            Mail::to($email)->send(new ResetPassword(env('FRONTEND_URL').'/reset/password/'.$urltoken));

            return response()->json(
                [
                    'success' => true, 
                    'message' => "Please check your email for link to reset password",
                    'code' => 'FORGOT_PASSWORD'
                ], 
                Response::HTTP_OK
            );
        }
       
    }

    
}
