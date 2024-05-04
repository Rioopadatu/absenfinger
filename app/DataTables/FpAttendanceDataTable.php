<?php

namespace App\DataTables;

use App\Models\FpAttendance;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class FpAttendanceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable;//->addColumn('action', 'fp_attendances.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FpAttendance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FpAttendance $model)
    {
        return $model->newQuery()
            ->whereHas('fp_user')
            ->where('timestamp', '>=',Carbon::today()->subMonths(1)->day(1))
            //->where('timestamp', '<=', Carbon::today()->day(1))
            ->with(['fp_user'])
            ->orderBy('timestamp','desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                //'order'     => [[0, 'desc']],
                'buttons'   => [
                    //['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            //'uid',
            'id',
            ['data' => 'fp_user.name',     'name' => 'fp_user.name',     'title' => 'Nama'],
            ['data' => 'tanggal',     'name' => 'tanggal',     'title' => 'Tanggal',"searchable"=> false],
            //'type'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'fp_attendances_datatable_' . time();
    }
}
