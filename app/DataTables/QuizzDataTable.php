<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Topic;
use App\Models\Quizz;
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

class QuizzDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                 $tutors = ModelHasSubject::with('user')
                    ->where('subject_id', $row->subject_id)
                    ->get();
                return view('admin.quizzes.action', compact('row', 'tutors'))->render();
            })
            ->addColumn('answers', function ($row) {
                return view('admin.quizzes.answers', ['answers' => $row->multiple_choice])->render();
            })
            ->rawColumns(['answers', 'action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(Quizz $model): QueryBuilder
    {
        $formSlug = request()->route('formSlug');
        $subjectSlug = request()->route('subjectSlug');
        $topicSlug = request()->route('topicSlug');

        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        \Log::info('grade_id: ' . $grade->id);

        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();
        \Log::info('subject_id: ' . $subject->id);

        $topic = Topic::where('slug', $topicSlug)->where('grade_id', $grade->id)->where('subject_id', $subject->id)->firstOrFail();
        \Log::info('topic_id: ' . $topic->id);

        return $model->newQuery()
            ->with(['grade', 'subject', 'topic', 'user'])
            ->where('grade_id', $grade->id)
            ->where('subject_id', $subject->id)
            ->where('topic_id', $topic->id);
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
            Column::make('id'),
            Column::make('grade.name')->title('Grade'),
            Column::make('subject.name')->title('Subject'),
            Column::make('topic.name')->title('Topic'),
            Column::make('user.name')->title('Tutor'),
            Column::make('question')->title('Question'),
            Column::computed('answers')->title('Answers')->orderable(false)->searchable(false),
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
