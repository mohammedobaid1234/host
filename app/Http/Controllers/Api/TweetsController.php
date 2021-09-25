<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\User;
use App\Notifications\TweetCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TweetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['show', 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd( $request->header('User-Agent'));
        $tweets = Tweet::with('user:id,name,type,council_id','tweetComments.user:id,name,council_id')->paginate(3);
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => ' التغريدات'
            ],
            'data' => $tweets
        ],
         404); 
        // return new JsonResponse($tweets);
    }
    // PostmanRuntime/7.28.4

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('id', $request->post('user_id'))->firstOrFail();
        if($user->type == 'عضو فعال') {
            return  response()->json([
                'status' => [
                    'code' => 403,
                    'status' => false,
                    'message' => 'هذه العملية غير مسموحة'
                ],
                'data' => null
            ],
             403);
            // return new JsonResponse([
            //     'message' => 'هذه العملية غير مسموحة'
            // ], 403);
        }
        $request->validate([
            'body' => 'required',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable'
        ]);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/', 'upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        $tweet = Tweet::create($request->all());
        $users = User::where('id', '<>', $tweet->user_id)->get();
        Notification::send($users, new TweetCreatedNotification($tweet));
        return  response()->json([
            'status' => [
                'code' => 201,
                'status' => true,
                'message' => 'تم اضافة التغريدة'
            ],
            'data' => $tweet->load('user:name,id')
        ],
         201);
        // return new JsonResponse($tweet->load('user:name,id'), 201);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet = Tweet::with(['user:id,name','tweetComments.user:id,name'])->find($id);
        if(!$tweet){
            return  response()->json([
                'status' => [
                    'code' => 404,
                    'status' => false,
                    'message' => 'هذا التغريدة غير موجود'
                ],
                'data' => null
            ],
             404);
        }
        return  response()->json([
            'status' => [
                'code' => 200,
                'status' => true,
                'message' => 'هذه التغريدة موجود'
            ],
            'data' => $tweet
        ],
         200);
        // return new JsonResponse($tweet);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tweet = Tweet::findOrFail($id);
        $request->validate([
            'body' => 'sometimes|required|unique:tweets,body,'.$id,
            // 'user_id' => 'nullable|exists:users,id',
            'image' => 'nullable'
        ]);
        if ($request->hasFile('image')) {
            if($tweet->image_url !== null ){

                unlink(public_path('uploads/' . $tweet->image_url));
            }
            $uploadedFile = $request->file('image');
            $image_url = $uploadedFile->store('/', 'upload');
            $request->merge([
                'image_url' => $image_url
            ]);
        }
        $tweet->update($request->all());
        return new JsonResponse([
            $tweet
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->delete();
        return new JsonResponse([
            'message' => 'تم حذف التويتة'
        ]);
    }
}
