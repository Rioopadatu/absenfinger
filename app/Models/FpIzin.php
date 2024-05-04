<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FpUser;
class FpIzin extends Model
{
    use HasFactory;
    protected $table = 'fp_izin';

    protected $primaryKey = 'uid';

    public $fillable = [
        'uid',
        'keterangan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        'timestamp',
        'fp_user_uid',
    ];

    protected $casts = [
        'uid' => 'integer',
        'keterangan' => 'string',
        'tanggal_mulai' => 'date',
        'tangga_berakhir' => 'date',
        'status' => 'string',
    ];

    public static $rules = [
        'tanggal_mulai' => 'required',
        'tanggal_berakhir' => 'required',
        'status' => 'nullable',
        'keterangan' => 'required',
        'timestamp' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable',
    ];
    /**
     * Get the formatted timestamp attribute.
     *
     * @return string
     */
    public function getTanggalAttribute()
    {
        return \Carbon\Carbon::parse($this->timestamp)
            ->format('d/m/Y');
    }
    public function fp_user()
{
    return $this->belongsTo(FpUser::class, 'fp_user_uid');
}



}
