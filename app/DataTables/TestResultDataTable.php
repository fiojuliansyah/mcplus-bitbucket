<?php

namespace App\DataTables;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Grade;
use App\Models\Subject;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TestResultDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_name', fn($row) => $row->user->name ?? '-')
            ->addColumn('answer_detail', function ($row) {
                return view('admin.tests.components.answer_detail', compact('row'))->render();
            })
            ->editColumn('submitted_at', fn($row) => $row->created_at->format('d M Y H:i'))
            ->rawColumns(['user_name', 'answer_detail'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(TestResult $model): QueryBuilder
    {
        $formSlug = request()->route('formSlug');
        $subjectSlug = request()->route('subjectSlug');
        $testSlug = request()->route('testSlug');

        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        $test = Test::where('slug', $testSlug)
                    ->where('grade_id', $grade->id)
                    ->where('subject_id', $subject->id)
                    ->firstOrFail();

        return $model->newQuery()
            ->with('user')
            ->where('test_id', $test->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('student-results-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No.')
                ->searchable(false)
                ->orderable(false),
            Column::make('user_name')->title('Student'),
            Column::make('total_questions')->title('Total Questions'),
            Column::make('correct_answers')->title('Correct'),
            Column::make('score')->title('Score (%)'),
            Column::make('submitted_at')->title('Submitted At'),
            Column::computed('answer_detail')
                ->title('Answer Detail')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'StudentResults_' . date('YmdHis');
    }
}
