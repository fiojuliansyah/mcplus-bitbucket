<?php

namespace App\DataTables;

use App\Models\Subject;
use App\Models\Topic;
use App\Models\Grade;
use App\Models\LiveClass;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class LiveClassDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $subjects = Subject::with('grade')->get();
                $grades = Grade::all();
                return view('admin.live_classes.action', compact('row','subjects', 'grades'))->render();
            })
            ->editColumn('start_time', function ($row) {
                return \Carbon\Carbon::parse($row->start_time)->format('d M Y H:i');
            })
            ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function query(LiveClass $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['grade', 'subject', 'topic', 'user']);
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('live-class-table')
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
<<<<<<< HEAD
<<<<<<< HEAD
            Column::make('id'),
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
=======
            Column::make('id'),
>>>>>>> dc16350 (Add Update and Delete Live Class)
            Column::make('grade.name')->title('Grade'),
            Column::make('subject.name')->title('Subject'),
            Column::make('topic.name')->title('Topic'),
            Column::make('user.name')->title('User'),
            Column::make('agenda')->title('Agenda'),
            Column::make('start_time')->title('Start Time'),
            Column::make('status')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false),
                // ->addClass('text-center')
        ];
    }

    // public function getColumns(): array
    // {
    //     return [
    //         Column::computed('DT_RowIndex')
    //             ->title('No.')
    //             ->searchable(false)
    //             ->orderable(false),
    //         Column::make('topic')->searchable(true),
    //         Column::make('start_time'),
    //         Column::make('status'),
    //         Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false),
    //     ];
    // }

    protected function filename(): string
    {
        return 'LiveClasses_' . date('YmdHis');
    }
}
