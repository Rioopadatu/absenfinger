<?php

namespace App\Repositories;

use App\Models\FpIzin;
use App\Repositories\BaseRepository;

/**
 * Class FpIzinRepository
 * @package App\Repositories
 * @version June 3, 2021, 8:49 am UTC
*/

class FpIzinRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'keterangan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FpIzin::class;
    }
}
