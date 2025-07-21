<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Test;
use App\Models\ModelHasSubject;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TestDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('admin.tests.action', compact('row'))->render();
            })
            ->editColumn('grade_id', fn($row) => $row->grade->name ?? '-')
            ->editColumn('subject_id', fn($row) => $row->subject->name ?? '-')
            ->editColumn('user_id', fn($row) => $row->user->name ?? '-')
            ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(Test $model): QueryBuilder
    {
        $formSlug = request()->route('formSlug');
        $subjectSlug = request()->route('subjectSlug');
        $testSlug = request()->route('testSlug');

        $grade = Grade::where('slug', $formSlug)->firstOrFail();

        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        return $model->newQuery()
            ->with(['grade', 'subject', 'user'])
            ->where('grade_id', $grade->id)
            ->where('subject_id', $subject->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('quizz-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([Button::make('excel'), Button::make('csv'), Button::make('pdf'), Button::make('print'), Button::make('reset'), Button::make('reload')]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No.')
                ->searchable(false)
                ->orderable(false),
            Column::make('grade_id')->title('Grade'),
            Column::make('subject_id')->title('Subject'),
            Column::make('user_id')->title('Tutor'),
            Column::make('name')->title('Name'),
            Column::make('start_time')->title('Start Time'),
            Column::make('end_time')->title('End Time'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'Quizz_' . date('YmdHis');
    }

}
