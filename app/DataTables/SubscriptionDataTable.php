<?php

namespace App\DataTables;

use App\Models\Plan;
use App\Models\User;
use App\Models\Profile;
use App\Models\Subscription;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SubscriptionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Subscription> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $users = User::all();
                $profiles = Profile::all();
                $plans = Plan::all();
                return view('admin.subscriptions.action', compact('row','users','profiles','plans'))->render();
            })
            // ->editColumn('start_date', function ($row) {
            //     return $row->start_date->format('d M Y');
            // })
            // ->editColumn('end_date', function ($row) {
            //     return $row->end_date->format('d M Y');
            // })
            ->editColumn('user_id', function ($row) {
                return $row->user->name;
            })
            ->setRowId('id')
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Subscription>
     */
    public function query(Subscription $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('subscription-table')
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
            Column::make('user_id')
                ->searchable(true),
            Column::make('plan_id')
                ->searchable(true),
            Column::make('duration'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('price'),
            Column::make('coupon_discount'),
            Column::make('total_amount'),
            Column::make('status'),
            Column::computed('action')->exportable(false)->printable(false)->orderable(false)->searchable(false),
        ];
    }

    /**
     * Return the filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Subscriptions_' . date('YmdHis');
    }
}
