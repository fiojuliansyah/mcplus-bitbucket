<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SubjectDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Subject> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $grades = Grade::all();
                return view('admin.subjects.action', compact('row', 'grades'))->render();
            })
            // ->addColumn('content_management', function ($row) {
            //     return view('admin.subjects.content_management', compact('row'))->render();
            // })
            ->addColumn('topic_management', function ($row) {
                return view('admin.subjects.topic_management', compact('row'))->render();
<<<<<<< HEAD
            })
            ->addColumn('test_management', function ($row) {
                return view('admin.subjects.test_management', compact('row'))->render();
=======
>>>>>>> 304dd22 (Add Datatable & CRUD for Topics)
            })
            ->editColumn('grade_id', function ($row) {
                return $row->grade->name;
            })
            ->addColumn('status', function ($row) {
                return $row->status == 'inactive' ? '<span class="badge rounded-pill border border-danger text-danger">Deactive</span>' : '<span class="badge rounded-pill border border-success text-success">Active</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            // ->rawColumns(['action', 'status', 'content_management'])
<<<<<<< HEAD
            ->rawColumns(['action', 'status', 'topic_management', 'test_management'])
=======
            ->rawColumns(['action', 'status', 'topic_management'])
>>>>>>> 304dd22 (Add Datatable & CRUD for Topics)
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Subject>
     */
    public function query(Subject $model): QueryBuilder
    {
        $slug = request()->route('slug');

        $grade = Grade::where('slug', $slug)->first();

        if ($grade) {
            return $model->newQuery()->where('grade_id', $grade->id);
        }

        return $model->newQuery()->whereRaw('1 = 0');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subject-table')
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
            Column::make('grade_id')
                ->title('Grade')
                ->searchable(true),
            Column::make('name')
                ->searchable(true),
            Column::make('status'),
            Column::make('created_at'),
            Column::computed('topic_management')->title('Topic Management')->exportable(false)->printable(false)->orderable(false)->searchable(false),
<<<<<<< HEAD
            Column::computed('test_management')->title('Test Management')->exportable(false)->printable(false)->orderable(false)->searchable(false),
=======
>>>>>>> 304dd22 (Add Datatable & CRUD for Topics)
            // Column::computed('content_management')->exportable(false)->printable(false)->orderable(false)->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Subject_' . date('YmdHis');
    }
}
