<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ForgotMail;
use Exception;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use App\Http\Requests\ResetRequest;
use Mail;
use Validator;
use Hash;

class ResetController extends Controller
{
    public function ResetPassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);
        $emailCheck = DB::table("password_reset_tokens")->where("email", $email)->first();
        $tokenCheck = DB::table("password_reset_tokens")->where("token", $token)->first();
        if (!$emailCheck) {
            return response()->json([
                "email" => "EMail not found",
            ], 401);
        }
        if (!$tokenCheck) {
            return response()->json([
                "token" => "token not found",
            ], 401);
        }

        DB::table('users')->where("email", $email)->update(['password'=> $password]);
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        return response()->json([
            'message' => 'password changed successfully!',
        ]);
    }
}
