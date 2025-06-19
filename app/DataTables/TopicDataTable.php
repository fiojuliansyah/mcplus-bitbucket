<?php

namespace App\DataTables;

use App\Models\Topic;
use App\Models\Grade;
use App\Models\Subject;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class TopicDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('admin.topics.action', compact('row'))->render();
            })
            ->editColumn('grade_id', fn($row) => $row->grade->name ?? '-')
            ->editColumn('subject_id', fn($row) => $row->subject->name ?? '-')
            ->addColumn('status', function ($row) {
                return $row->status == 'inactive'
                    ? '<span class="badge rounded-pill border border-danger text-danger">Deactive</span>'
                    : '<span class="badge rounded-pill border border-success text-success">Active</span>';
            })
            ->editColumn('created_at', fn($row) => $row->created_at->format('d M Y'))
            ->setRowId('id')
            ->addIndexColumn()
            ->rawColumns(['action', 'status']);
    }


    public function query(Topic $model): QueryBuilder
    {
        $formSlug = request()->route('formSlug');
        $subjectSlug = request()->route('subjectSlug');

        $grade = Grade::where('slug', $formSlug)->firstOrFail();
        $subject = Subject::where('slug', $subjectSlug)->where('grade_id', $grade->id)->firstOrFail();

        if($grade && $subject){
            return $model->newQuery()->where('grade_id', $grade->id);
        }

        return $model->newQuery()->whereRaw('1 = 0');
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('topic-table')
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
            Column::make('grade_id')->title('Grade'),
            Column::make('subject_id')->title('Subject'),
            Column::make('name')->title('Topic'),
            Column::make('status'),
            Column::make('created_at')->title('Created At'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false),
        ];
    }


    protected function filename(): string
    {
        return 'Topics_' . date('YmdHis');
    }
}
