<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FpUser
 * @package App\Models
 * @version June 3, 2021, 8:35 am UTC
 *
 * @property string $userid
 * @property string $name
 * @property integer $role
 * @property string $password
 * @property string $cardno
 */
class FpUser extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'fp_user';

    const CREATED_AT = 'created_at';
    const UPDATEDm_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $primaryKey='uid';


    public $fillable = [
        'uid',
        'id',
        'userid',
        'name',
        'role',
        'password',
        'cardno'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid' => 'integer',
        'userid' => 'string',
        'name' => 'string',
        'role' => 'integer',
        'password' => 'string',
        'cardno' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'userid' => 'nullable|string|max:255',
        'name' => 'nullable|string|max:255',
        'role' => 'nullable|integer',
        'password' => 'nullable|string|max:255',
        'cardno' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function fp_izin(): HasMany
    {
        return $this->hasMany(FpIzin::class, 'users_id', 'id');
    }
}
