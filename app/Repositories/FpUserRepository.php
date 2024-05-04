<?php

namespace App\Repositories;

use App\Models\FpUser;
use App\Repositories\BaseRepository;

/**
 * Class FpUserRepository
 * @package App\Repositories
 * @version June 3, 2021, 8:35 am UTC
*/

class FpUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'name',
        'role',
        'password',
        'cardno'
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
        return FpUser::class;
    }
}
