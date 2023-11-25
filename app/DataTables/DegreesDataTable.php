<?php

namespace App\DataTables;

use App\Degree;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DegreesDataTable extends DataTable
{
  /**
   * Build DataTable class.
   *
   * @param mixed $query Results from query() method.
   * @return \Yajra\DataTables\DataTableAbstract
   */
  public function dataTable($query)
  {
    return datatables()
      ->eloquent($query)
      ->addIndexColumn()
      ->addColumn('action', function (Degree $degree) {
        return view('partials.action-buttons', ['model' => $degree])->render();
      });
  }

  /**
   * Get query source of dataTable.
   *
   * @param \App\App\Degree $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Degree $model)
  {
    return $model->newQuery();
  }

  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html()
  {
    return $this->builder()
      ->setTableId('degrees-table')
      ->setTableAttribute('class', 'table table-bordered table-striped table-hover table-sm text-nowrap')
      ->parameters([
        'autoFill' => true,
        'colReorder' => true,
        'responsive' => true,
        'searchPanes' => true,
        'select' => true,
        'datetime' => true,
        'language' => [
          'url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        ],
        'initComplete' => "function () {
          $('div.dataTables_length select').addClass('form-control');
          $('div.dataTables_filter input').addClass('form-control');
      }"
      ])
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->dom('Bfrtip')
      ->orderBy(1, 'asc')
      ->buttons(
        Button::raw('add')
          ->text('<span class="button-add-icon-placeholder"></span> Tambah Jenjang')
          ->addClass('button-add'),
        Button::make('export')
          ->buttons([
            Button::make('excel'),
            Button::make('csv'),
            // Button::make('pdf')
          ]),
        Button::make('print'),
        Button::make('reset'),
        Button::make('reload'),
        Button::make('colvis')
          ->text('Visibilitas Kolom')
      );
  }

  /**
   * Get columns.
   *
   * @return array
   */
  protected function getColumns()
  {
    return [
      Column::computed('DT_RowIndex')
        ->title('#')
        ->orderable(false)
        ->searchable(false)
        ->exportable(false)
        ->printable(true)
        ->width(30)
        ->addClass('text-center'),
      Column::make('name')
        ->title('Nama'),
      Column::make('code')
        ->title('Kode'),
      Column::computed('action')
        ->title('Aksi')
        ->exportable(false)
        ->printable(false)
        ->width(150)
        ->addClass('text-center'),
    ];
  }

  /**
   * Get filename for export.
   *
   * @return string
   */
  protected function filename()
  {
    return 'Degrees_' . date('YmdHis');
  }
}
