<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index($id) {
        $notUser = DB::table('notifications')->where('notifiable_id', $id)->get(['data']);

        
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'الاشعارات'
            ],
            'data' => $notUser
        ],
         200);
        // return $notUser;
    }
}
