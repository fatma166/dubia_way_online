<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeRole
 * 
 * @property int $id
 * @property string $name
 * @property string|null $modules
 * @property bool $status
 * @property int $restaurant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeRole extends Model
{
	protected $table = 'employee_roles';

	protected $casts = [
		'status' => 'bool',
		'restaurant_id' => 'int'
	];

	protected $fillable = [
		'name',
		'modules',
		'status',
		'restaurant_id'
	];
}
