<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Test;
use App\Models\TestQuestion;
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

class TestQuestionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('questionAction', function ($row) {
                return view('admin.tests.questionAction', compact('row'))->render();
            })
            // ->addColumn('question_management', function ($row) {
            //     return view('admin.tests.question_management', compact('row'))->render();
            // })
            ->addColumn('show_answer', function ($row) {
                return view('admin.tests.answers', ['answer' => $row->answer, 'type' => $row->type])->render();
            })
            ->editColumn('test_id', fn($row) => $row->test->name ?? '-')
            ->rawColumns(['show_answer', 'questionAction'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(TestQuestion $model): QueryBuilder
    {
        $formSlug = request()->route('formSlug');
        $subjectSlug = request()->route('subjectSlug');
        $testSlug = request()->route('testSlug');

        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        $test = Test::where('slug', $testSlug)->where('grade_id', $grade->id)->where('subject_id', $subject->id)->firstOrFail();

        return $model->newQuery()
            ->with(['test'])
            ->where('test_id', $test->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('test-question-table')
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
            Column::make('test_id')->title('Test Name'),
            Column::make('question')->title('Question'),
            Column::make('show_answer')->title('Answer'),
            Column::make('type')->title('Type')->searchable(false),
            Column::computed('questionAction')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'TestQuestion_' . date('YmdHis');
    }

}
