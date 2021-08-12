<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Http\Requests\LoginRequest;

class passportAuthController extends Controller
{
    /**
     * login user to our application
     */
    public function login(LoginRequest $request){
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
            $userRole = auth()->user()->role()->role;
            
            
            //generate the token for the user
            $tokenResult= auth()->user()->createToken($request->email, [$userRole]);

            //now return this token on success login attempt
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token' => $tokenResult->token,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ], 200);
        }
        else{
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    /**
     * login user to our application
     */
    public function logout(){
        if (auth()->check()) {
            auth()->user()->OauthAcessToken()->delete();

            return response()->json(['message' => 'Success Logout'], 200);
        } else {
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }
}
