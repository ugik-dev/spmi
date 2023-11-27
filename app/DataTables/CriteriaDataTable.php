<?php

namespace App\DataTables;

use App\Criterion;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CriteriaDataTable extends DataTable
{
  /**
   * Build DataTable class.
   *
   * @param mixed $query Results from query() method.
   * @return \Yajra\DataTables\DataTableAbstract
   */
  public function dataTable($query)
  {
    $query = Criterion::with('parent')->select('criteria.*');

    return datatables()
      ->eloquent($query)
      ->addIndexColumn()
      ->addColumn('action', function (Criterion $criterion) {
        return view('partials.action-buttons', ['model' => $criterion])->render();
      });
  }


  /**
   * Get query source of dataTable.
   *
   * @param \App\Criterion $model
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function query(Criterion $model)
  {
    // Load the parent relationship for hierarchical data
    return $model->newQuery()->with('parent');
  }


  /**
   * Optional method if you want to use html builder.
   *
   * @return \Yajra\DataTables\Html\Builder
   */
  public function html()
  {
    return $this->builder()
      ->setTableId('criteria-table')
      ->setTableAttribute('class', 'table table-bordered table-striped table-hover table-sm text-nowrap')
      ->parameters([
        'autoFill' => true,
        'colReorder' => true,
        'searchPanes' => true,
        'lengthChange' => true,
        'select' => true,
        'datetime' => true,
        'language' => [
          'url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        ],
      ])
      ->columns($this->getColumns())
      ->minifiedAjax()
      ->dom("<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-8'B><'col-sm-12 col-md-2'f>>rtip")
      ->orderBy(1, 'asc')
      ->buttons(
        Button::raw('add')
          ->text('<span class="button-add-icon-placeholder"></span> Tambah Kriteria')
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
      Column::make('code')
        ->title('Kode')
        ->width(180),
      Column::make('name')
        ->title('Nama'),
      Column::make('level')
        ->title('Level')
        ->width(80)
        ->orderable(true)
        ->searchable(true),
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
    return 'Criteria_' . date('YmdHis');
  }
}
