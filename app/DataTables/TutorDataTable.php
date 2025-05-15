<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Subject;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TutorDataTable extends DataTable
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
                return view('admin.tutors.action', compact('row', 'roles'))->render();
            })
            ->addColumn('class_management', function ($row) {
                $subjects = Subject::all();
                return view('admin.tutors.class_management', compact('row', 'subjects'))->render();
            })
            ->addColumn('status', function ($row) {
                return $row->status == 'deactive'
                    ? '<span class="badge rounded-pill border border-danger text-danger">Deactive</span>'
                    : '<span class="badge rounded-pill border border-success text-success">Active</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->rawColumns(['action', 'status', 'class_management'])
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
        return $model->newQuery()->where('account_type', 'tutor');  // Only tutors
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('tutor-table')
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
            Column::make('status'),
            Column::make('created_at')
                ->title('Join Date'),
            Column::computed('class_management')->exportable(false)->printable(false)->orderable(false)->searchable(false),
            Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Tutor_' . date('YmdHis');
    }
}
