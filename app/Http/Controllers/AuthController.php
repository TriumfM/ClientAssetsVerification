<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        $credentials = request(['email', 'password']);

        if ($user != null && \Auth::attempt($credentials))
        {
            $user = $request->user();

            $tokenResult = $user->createToken('Client Assets Token');

            return response()->json([

                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]
            );
        }

        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => ['email' => [ 'Email or password is invalid.' ] ]
        ], 403);
    }
}
