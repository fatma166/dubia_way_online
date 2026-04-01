<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 *
 * @property int $id
 * @property int|null $conversation_id
 * @property int|null $sender_id
 * @property string|null $message
 * @property string|null $file
 * @property bool $is_seen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Message extends Model
{
	protected $table = 'messages';

	protected $casts = [
		'conversation_id' => 'int',
		'sender_id' => 'int',
		'is_seen' => 'bool'
	];

	protected $fillable = [
		'conversation_id',
		'sender_id',
		'message',
		'file',
		'is_seen'
	];
    public function sender()
    {
        return $this->belongsTo(UserInfo::class, 'sender_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
