<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Conversation
 *
 * @property int $id
 * @property int|null $sender_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $sender_type
 * @property int $receiver_id
 * @property string $receiver_type
 * @property int|null $last_message_id
 * @property Carbon|null $last_message_time
 * @property int $unread_message_count
 *
 * @package App\Models
 */
class Conversation extends Model
{
	protected $table = 'conversations';

	protected $casts = [
		'sender_id' => 'int',
		'receiver_id' => 'int',
		'last_message_id' => 'int',
		'last_message_time' => 'datetime',
		'unread_message_count' => 'int'
	];

	protected $fillable = [
		'sender_id',
		'sender_type',
		'receiver_id',
		'receiver_type',
		'last_message_id',
		'last_message_time',
		'unread_message_count'
	];

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function sender()
    {
        return $this->belongsTo(UserInfo::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(UserInfo::class, 'receiver_id');
    }

    public function last_message()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function scopeWhereUser($query,$user_id){
        $query->where(function($q)use($user_id){
            $q->where('sender_id',$user_id)->orWhere('receiver_id',$user_id);
        });
    }

    public function scopeWhereConversation($query,$sender_id,$receiver_id){
        $query->where(function($q)use($sender_id, $receiver_id){
            $q->where('sender_id',$sender_id)->where('receiver_id',$receiver_id);
        })->orWhere(function($q)use($sender_id, $receiver_id){
            $q->where('sender_id',$receiver_id)->where('receiver_id',$sender_id);
        });
    }

    public function scopeWhereUserType($query,$type){
        $query->where(function($q)use($type){
            $q->where('sender_type',$type)->orWhere('receiver_type',$type);
        });
    }
}
