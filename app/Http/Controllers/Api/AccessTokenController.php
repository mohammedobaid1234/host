<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AccessTokenController extends Controller
{
    public function checkUser(Request $request)
    {
        $request->validate([
            'phone_number' => 'required'
        ]);
        $phone = trim($request->phone_number);
        $user = User::where('phone_number', $phone)->first();
<<<<<<< HEAD
        if (!$user) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'هذا العنصر غير موجود'
                    ],
                    'data' => null
=======
        if(!$user){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => false,
                    'message' => 'هذا العنصر غير موجود'
>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
                ],
                404
            );
        }
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'هذا العنصر موجود'
                ],
                'data' => $user
            ],
            200
        );
        // return $user;
    }

<<<<<<< HEAD
=======
    

>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
    public function receiveCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'phone_number' => 'required'
        ]);
<<<<<<< HEAD
        $phone = trim($request->phone_number);

        $user = User::where('phone_number', $phone)->first();
        $user->update([
            'code' => $request->code
        ]);
        return;
    }
=======
        
        $phone = trim($request->phone_number);
        
        $user = User::where('phone_number', $phone)->first();
        
        
        $user->update([
            'code' => $request->code
        ]);
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => "تم ارسال الرمز"
            ],
            'data' => $user,
            
        ], 200);
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'code' => ['required']
        ]);

        $phone = trim($request->phone_number);
        
        $user = User::where('phone_number', $phone)
        ->first();
        if(!$user || $user->code !== $request->code){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => false,
                    'message' => 'رمز التحقق غير صحيح'
                ],
                'data' => null
            ],
             404); 
        }
        $user->update([
            'code' => null
        ]);
            return  response()->json([
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => "تم التحقق "
                ],
                'data' =>  $user
            ], 200);

    }

>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'device_name' => ['required'],
<<<<<<< HEAD
            // 'code' => ['required']
        ]);
        $phone = trim($request->phone_number);

        $user = User::where('phone_number', $phone)
            ->first();

        // $this->ensureIsNotRateLimited($request);
        if (!$user || $user->code !== $request->code) {
            // RateLimiter::hit($this->throttleKey());
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => false,
                        'message' => 'رمز التحقق غير صحيح'
                    ],
                    'data' => null
=======
          
        ]);
        $phone = trim($request->phone_number);
        
        $user = User::where('phone_number', $phone)
        ->first();

        // $this->ensureIsNotRateLimited($request);
        if(!$user){
            // RateLimiter::hit($this->throttleKey());
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => false,
                    'message' => 'هذا الرقم غير موجود'
>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
                ],
                404
            );
        }
        $token = $user->createToken($request->device_name);
<<<<<<< HEAD
        $user->update([
            'code' => null
        ]);
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => "تم تسجيل الدخول"
            ],
            'data' => [
                'token' => $token->plainTextToken,
                'user' =>  $user,
            ]
        ], 200);
=======
        
            return  response()->json([
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => "تم تسجيل الدخول"
                ],
                'data' =>[
                    'token' => $token->plainTextToken,
                    'user' =>  $user,
                ]
            ], 200);
>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
    }
    public function destroy()
    {
        $user = Auth::guard('sanctum')->user();

        // Revoke (delete) all user tokens
        //$user->tokens()->delete();

        // Revoke current access token
        $user->currentAccessToken()->delete();
        return response()->json([
            'status' => [
                'code' => 204,
                'status' => true,
                'message' => 'تم تسجيل الخروج'
            ],
            'data' => null
        ], 204);
    }
    // /**
    //  * Ensure the login request is not rate limited.
    //  *
    //  * @return void
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // public function ensureIsNotRateLimited(Request $request)
    // {
    //     if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
    //         return;
    //     }

    //     event(new Lockout($this));

    //     $seconds = RateLimiter::availableIn($this->throttleKey());

    //     throw ValidationException::withMessages([
    //         'phone_number' => trans('auth.throttle', [
    //             'seconds' => $seconds,
    //             'minutes' => ceil($seconds / 60),
    //         ]),
    //     ]);
    // }
    // /**
    //  * Get the rate limiting throttle key for the request.
    //  *
    //  * @return string
    //  */
    // public function throttleKey()
    // {
    //     return Str::lower($this->input('phone_number')).'|'.$this->ip();
    // }

}