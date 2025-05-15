<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Grade;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class GradeDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $tutors = User::where('account_type', 'tutor')->get();
                return view('admin.grades.action', compact('row', 'tutors'))->render();
            })
            ->addColumn('subject_management', function ($row) {
                return view('admin.grades.subject_management', compact('row'))->render();
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->rawColumns(['action','subject_management'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(Grade $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('grade-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([Button::make('excel'), Button::make('csv'), Button::make('pdf'), Button::make('print'), Button::make('reset'), Button::make('reload')]);
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
            Column::make('created_at'),
            Column::computed('subject_management')->exportable(false)->printable(false)->orderable(false)->searchable(false),
            Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false),
        ];
    }

    /**
     * Return the filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Grades_' . date('YmdHis');
    }
}
