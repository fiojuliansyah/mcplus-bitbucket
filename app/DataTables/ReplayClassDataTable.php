<?php

namespace App\DataTables;

use App\Models\Subject;
use App\Models\Topic;
use App\Models\Grade;
use App\Models\ReplayClass;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ReplayClassDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $subjects = Subject::with('grade')->get();
                $grades = Grade::all();
                return view('admin.replay_classes.action', compact('row','subjects', 'grades'))->render();
            })
<<<<<<< HEAD
            ->addColumn('video', function ($row) {
                return view('admin.replay_classes.video', compact('row'))->render();
            })
            ->rawColumns(['action', 'video'])
=======
            ->rawColumns(['action'])
>>>>>>> 64ff4f3 (Add Upload Replay Class to Cloudinary)
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(ReplayClass $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['grade', 'subject', 'topic', 'user']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('replay-class-table')
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
            Column::make('user.name')->title('User'),
<<<<<<< HEAD
            Column::make('video')->title('Video')->exportable(false)->printable(false)->orderable(false)->searchable(false),
=======
            Column::make('replay_url')->title('Video'),
            Column::make('replay_public_id')->title('Address'),
>>>>>>> 64ff4f3 (Add Upload Replay Class to Cloudinary)
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->addClass('text-center')
        ];
    }
}