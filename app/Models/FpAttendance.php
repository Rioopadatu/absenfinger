<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FpAttendance
 * @package App\Models
 * @version June 3, 2021, 8:49 am UTC
 *
 * @property string $id
 * @property string|\Carbon\Carbon $timestamp
 * @property integer $type
 */
class FpAttendance extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'fp_attendance';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $primaryKey='pk';

    protected $appends = ['tanggal'];

    public $fillable = [
        'uid',
        'id',
        'timestamp',
        'type',
        'state',
        'mesin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid' => 'integer',
        'id' => 'string',
        'timestamp' => 'datetime',
        'type' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'timestamp' => 'nullable',
        'type' => 'nullable|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

 /*   public function getFpUserAttribute(){
        return FpUser::where('userid','like', $this->id."%")->first();
    }*/

    public function getTanggalAttribute(){
        return $this->timestamp->format("d/m/Y H:i");
    }

    public function fp_user()
    {
        return $this->belongsTo(\App\Models\FpUser::class, 'id','id');
    }

}
