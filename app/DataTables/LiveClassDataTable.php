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
            ->addColumn('attendance', function ($row) {
                $attendanceUrl = route('admin.live-classes.attendance', $row->id);
                return "<a href='{$attendanceUrl}' class='badge bg-light' style='color: black;'><i class='fa-solid fas fa-file-alt fa-xs'></i> Attendance</a>";
            })
            ->addColumn('link-host', function ($row) {
                $attendanceUrl = $row->zoom_start_url;
                return "<a href='{$attendanceUrl}' target='_blank' class='badge bg-warning'><i class='fa-solid fa-link fa-xs'></i> Click Here</a>";
            })
            ->addColumn('link-join', function ($row) {
                $attendanceUrl = $row->zoom_join_url;
                return "<a href='{$attendanceUrl}' target='_blank' class='badge bg-info'><i class='fa-solid fa-external-link-square-alt fa-xs'></i> Click Here</a>";
            })
            ->editColumn('start_time', function ($row) {
                return \Carbon\Carbon::parse($row->start_time)->format('d M Y H:i');
            })
            ->rawColumns(['action','attendance','link-host','link-join'])
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
            Column::make('id'),
            Column::make('grade.name')->title('Grade'),
            Column::make('subject.name')->title('Subject'),
            Column::make('topic.name')->title('Topic'),
            Column::make('user.name')->title('User'),
            Column::make('agenda')->title('Agenda'),
            Column::make('start_time')->title('Start Time'),
            Column::make('status')->title('Status'),
            Column::computed('attendance')
                ->exportable(false)
                ->printable(false)
                ->orderable(false),
            Column::computed('link-host')
                ->title('Link Host/Tutor')
                ->exportable(false)
                ->printable(false)
                ->orderable(false),
            Column::computed('link-join')
                ->title('Link Student')
                ->exportable(false)
                ->printable(false)
                ->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->orderable(false),
        ];
    }

    protected function filename(): string
    {
        return 'LiveClasses_' . date('YmdHis');
    }
}
