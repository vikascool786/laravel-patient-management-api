<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Validator;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            // 'password' => 'required|confirmed|min:6'
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken], 201);
        // try {
        //     $user = User::create([
        //         "name" => $request->name,
        //         "email" => $request->email,
        //         "password" => Hash::make($request->password)
        //     ]);
        //     // print_r($user);exit;
        //     $token = $user->createToken("app")->accessToken;
        //     return response()->json([
        //         'message' => 'registration successfully',
        //         'token' => $token,
        //         'user' => $user,
        //     ], 200);

        // } catch (Exception $exception) {
        //     return response([
        //         "error" => $exception->getMessage()
        //     ], 400);
        // }
    }

    public function login(Request $request)
    {
        // $data = $request->all();

        // $validator = Validator::make($data, [
        //     'email' => 'required|email',
        //     'password' => 'required|min:6'
        // ]);

        // if ($validator->fails()) {
        //     // return response(['error' => $validator->errors()], 404);
        //     return response(['message' => 'Login credentials are invaild'], 404);
        // }

        // if (!auth()->attempt($data)) {
        //     return response(['message' => 'Login credentials are invaild'], 404);
        // }

        // $accessToken = auth()->user()->createToken('authToken')->accessToken;

        // return response(['access_token' => $accessToken, 'user' => auth()->user()], 200);

        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;

                return response([
                    'user' => $user,
                    'access_token' => $token,
                    'message' => "successfully login!",
                ], 200);

            }
        } catch (Exception $exception) {
            return response([
                "error" => $exception->getMessage()
            ], 400);
        }

        return response([
            "message" => "invalid email or password!"
        ], 401);
    }
}
