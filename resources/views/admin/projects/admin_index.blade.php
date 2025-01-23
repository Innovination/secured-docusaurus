@extends('layouts.admin')
@section('content')
@can('project_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.projects.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.project.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.project.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Project">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('global.actions') }}
                    </th>
                    <th>
                        {{ trans('cruds.project.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.project.fields.project_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.project.fields.slug') }}
                    </th>
                    <th>
                        {{ trans('cruds.project.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.project.fields.remarks') }}
                    </th>
                    <th>
                        {{ trans('cruds.project.fields.allowed_users') }}
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('project_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.projects.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.projects.admin_view') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
      { data: 'actions', name: '{{ trans('global.actions') }}' },
      { data: 'id', name: 'id' },
      { data: 'project_name', name: 'project_name' },
      {
          data: 'slug',
          name: 'slug',
          render: function ( data, type, row ) {
              return '<a href="/admin/project/' + row.slug + '" target="_blank">' + data + '</a>';
          }
      },
      {
          data: 'status',
          name: 'status',
          render: function (data, type, row) {
              let color = data === 'Pending' ? 'red' : (data === 'In Progress' ? 'orange' : 'green');
              return `<span class="badge" style="background-color: ${color}; color: white;">${data}</span>`;
          }
      },
      { data: 'remarks', name: 'remarks' },
      { data: 'allowed_users', name: 'allowed_users.name' }
    ],
    orderCellsTop: true,
    order: [[ 2, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Project').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection
