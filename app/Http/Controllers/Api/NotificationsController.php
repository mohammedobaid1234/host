<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
<<<<<<< HEAD
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user->unreadNotifications->count() == 0) {
            return  response()->json(
                [
                    'status' => [
                        'code' => 404,
                        'status' => true,
                        'message' => 'لايوجد اشعارات'
                    ],
                    'data' => 'لا يوجد بيانات'
                ],
                404
            );
        }
        foreach ($user->unreadNotifications as $not) {
            $data[] = [
                'id' => $not->id,
                'data' => $not->data
            ];
        }

        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'الاشعارات'
                ],
                'data' => $data
=======
    public function index($id) {
        return Auth::guard('sanctum')->id();
        $notUser = DB::table('notifications')->where('notifiable_id', $id)->get(['data']);   
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'الاشعارات'
>>>>>>> 91c51720c0330e57de3fe710d06538cffd0408ca
            ],
            200
        );
        // return $notUser;
    }

    public function delete($id)
    {
        $user = Auth::guard('sanctum')->user();
        $notifciation = $user->notifications()->findOrFail($id);

        $notifciation->markAsRead();
        return  response()->json(
            [
                'status' => [
                    'code' => 200,
                    'status' => true,
                    'message' => 'تم حدف الاشعار'
                ],
                'data' => 'لا يوجد بيانات'
            ],
            200
        );
    }
}