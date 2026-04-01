<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminRole
 *
 * @property int $id
 * @property string $name
 * @property string|null $modules
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AdminRole extends Model
{
    use HasFactory;
	protected $table = 'admin_roles';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'modules',
		'status'
	];
}
