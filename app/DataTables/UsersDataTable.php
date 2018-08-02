<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    /*
    public function dataTable($query)
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'user.action');
    }
    */

     /**
     * Get query source of dataTable.
     *
     * @param \App\Test $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $users = User::select();
        
        return $this->applyScopes($users);
    }



    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->make(true);
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
                    //->ajax('')
                    //->ajax(url('admin/getUserData'))
                    //->addAction(['width' => '120px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'nachname',
            'vorname',
            'klasse',
            'iserv_id',
            'email',
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            'dom'     => 'Bfrtip',
            'buttons' => [
                'create',
                'print',
            ],
        ];
    }

     /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users' . date('YmdHis');
    }
}
