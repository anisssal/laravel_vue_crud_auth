<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('psa-app');

            return [
                'success' =>true ,
                'access_token' => $tokenResult->accessToken  ,
                'expired_at' => $tokenResult->token->expires_at,
                'data' => $user,
                'message' => 'User Login Successfully',

            ];
        }
        return $this->sendErrorResponse('Unauthorized', [] , Response::HTTP_UNAUTHORIZED);
    }
}
