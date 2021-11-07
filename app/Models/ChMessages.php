<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChMessages extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'body',
        'chat_number',
        'type',
        'seen'
    ];
    
    public function users_to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function users_from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public static function unread($id)
    {
        // if()
        $auth_number = Auth::id();
        if ($auth_number <= $id) {
        $chat_number = $auth_number . '.' . $id;
        } else {
        $chat_number = $id . '.' . $auth_number;
        }
        $unread = ChMessages::where('chat_number', $chat_number )
        ->where('to_id',$id)
        ->where('seen' , 0)
        ->count();

        return $unread;
    }

}
