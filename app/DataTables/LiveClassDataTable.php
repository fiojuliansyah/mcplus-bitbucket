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
            ->addColumn('zoom-links', function ($row) {
                if ($row->status === 'draft') {
                    return 'Need Approval';
                }

                $startUrl = $row->zoom_start_url;
                $joinUrl = $row->zoom_join_url;

                return "
                    <a href='{$startUrl}' target='_blank' class='badge bg-warning me-1'>
                        <i class='fa-solid fa-link fa-xs'></i> Host
                    </a>
                    <a href='{$joinUrl}' target='_blank' class='badge bg-info'>
                        <i class='fa-solid fa-external-link-alt fa-xs'></i> Guest
                    </a>
                ";
            })
            ->addColumn('approval', function ($row) {
                if ($row->status !== 'scheduled') {
                    $approveRoute = route('admin.live-classes.approve', $row->id);
                    $formId = 'approve-form-' . $row->id;

                    return "
                        <a href='#' class='badge bg-success'
                        onclick=\"event.preventDefault(); document.getElementById('{$formId}').submit();\">
                            <i class='fa fa-check'></i> Approve
                        </a>

                        <form id='{$formId}' action='{$approveRoute}' method='POST' style='display: none;'>
                            " . csrf_field() . "
                        </form>
                    ";
                }

                return "<span class='badge bg-success'>Approved</span>";
            })
            ->editColumn('start_time', function ($row) {
                return \Carbon\Carbon::parse($row->start_time)->format('d M Y H:i');
            })
            ->rawColumns(['action','attendance','zoom-links','approval'])
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
            Column::computed('zoom-links')
                ->title('Links')
                ->exportable(false)
                ->printable(false)
                ->orderable(false),
            Column::computed('approval')
                ->title('Approval')
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
