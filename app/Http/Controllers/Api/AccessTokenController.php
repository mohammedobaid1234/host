<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessTokenController extends Controller
{
    public function checkUser(Request $request)
    {
        $request->validate([
            'phone_number' => 'required'
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();
        if(!$user){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => false,
                    'message' => 'هذا العنصر غير موجود'
                ],
                'data' => null
            ],
             404); 
        }
        return  response()->json([
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'هذا العنصر موجود'
                ],
                'data' => $user
            ],
             200); 
        // return $user;
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'device_name' => ['required']
        ]);
        
        $user = User::where('phone_number', $request->phone_number)
        ->first();

        if(!$user){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => false,
                    'message' => 'هذا العنصر غير موجود'
                ],
                'data' => null
            ],
             404); 
        }
        $token = $user->createToken($request->device_name);
            
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

}
