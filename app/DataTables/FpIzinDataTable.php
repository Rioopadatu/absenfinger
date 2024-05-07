<?php

namespace App\DataTables;

use App\Models\FpIzin;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Auth;
use App\Models\FpUser;
class FpIzinDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'fp_izin.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FpIzin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FpIzin $model)
    {
        $fp_user = FpUser::where('uid', Auth::user()->id)->first();


        if($fp_user->role == 1){
            return $model->newQuery()
            ->whereHas('fp_user')
            ->with(['fp_user']);
            // ->orderBy('timestamp','desc');
        }else{
            return $model->newQuery()
                ->where('fp_user_uid', $fp_user->uid)
                ->whereHas('fp_user')
                ->with(['fp_user']);
                // ->orderBy('timestamp','desc');

        }

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
                // 'stateSave' => true,
                //'order'     => [[0, 'desc']],
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
            'uid',
            ['data' => 'fp_user.name',     'name' => 'fp_user.name',     'title' => 'Nama'],
            ['data' => 'tanggal_berakhir',     'name' => 'tanggal_berakhir',     'title' => 'Mulai',"searchable"=> false],
            ['data' => 'tanggal_berakhir',     'name' => 'tanggal_berakhir',     'title' => 'Berakhir'],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                // 'render' => 'function(data, type, full, meta) {
                //     if (data == null) {
                //         return "<p>Menunggu</p>";
                //     } else if (data == 1) {
                //         return "<p>Di Terima</p>";
                //     } else if (data == 2) {
                //         return "<p>Di Tolak</p>";
                //     } else {
                //         return "<p>Tidak Di Temukan</p>";
                //     }
                // }'
            ],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false, 'printable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'fp_izin_datatable_' . time();
    }
}
