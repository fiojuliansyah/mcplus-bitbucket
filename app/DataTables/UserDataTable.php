<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $roles = Role::all();
                return view('admin.users.action', compact('row','roles'))->render();
            })
            ->addColumn('status', function ($row) {
                // Check if status is deactive
                if ($row->status == 'deactive') {
                    return '<span class="badge rounded-pill border border-danger text-danger">Deactive ' . $row->updated_at->format('d M Y') . '</span>';
                }

                // If the status is active
                return '<span class="badge rounded-pill border border-success text-success">Active</span>';
            })

            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->rawColumns(['action','status'])
            ->setRowId('id')
            ->addIndexColumn(); 
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel')->text('Export Excel'),
                        Button::make('csv')->text('Export CSV'),
                        Button::make('pdf')->text('Export PDF'),
                        Button::make('print')->text('Print'),
                        Button::make('reset')->text('Reset'),
                        Button::make('reload')->text('Reload')
                    ]);
    }


    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex') 
                ->title('No.')  
                ->searchable(false) 
                ->orderable(false), 
            Column::make('name')
                ->searchable(true),
            Column::make('email')
                ->searchable(true),
            Column::make('phone')
                ->searchable(true),
            Column::make('account_type'),
            Column::make('status'),
            Column::make('created_at')
                ->title('Join Date'),
            Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
