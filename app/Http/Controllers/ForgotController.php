<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ForgotMail;
use Exception;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use App\Http\Requests\ForgotRequest;
use Mail;
use Validator;
use Hash;


class ForgotController extends Controller
{
    public function ForgotPassword(ForgotRequest $request)
    {
        $email = $request->email;
        if (User::where('email', $email)->doesntExist()) {
            return response()->json([
                'message' => 'Email invalid',
            ], 401);
        }

        //generate random token
        $token = rand(10, 100000);

        try {
            DB::table('password_reset_tokens')->insert([
                'email'=> $email,
                'token'=> $token,
            ]);

            Mail::to($email)->send(new ForgotMail($token));
            return response()->json([
                'message'=> 'Reset Password mail sent on your email!',
            ], 200);
        } catch (Exception $exception) {
            return response([
                "error" => $exception->getMessage()
            ], 400);
        }
    }
}
