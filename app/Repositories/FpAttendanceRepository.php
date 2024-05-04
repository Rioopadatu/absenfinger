<?php

namespace App\Repositories;

use App\Models\FpAttendance;
use App\Repositories\BaseRepository;

/**
 * Class FpAttendanceRepository
 * @package App\Repositories
 * @version June 3, 2021, 8:49 am UTC
*/

class FpAttendanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'timestamp',
        'type'
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
        return FpAttendance::class;
    }
}
