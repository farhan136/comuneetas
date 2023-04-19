@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Event') }} <button type="button" class="btn btn-outline-success btn-sm" id="add" style="width:10%; float: right;">Add</button></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id="table_events" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;"></th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;  width: 30%;">Description</th>
                                <th style="text-align: center; width: 15%;">Group</th>
                                <th style="text-align: center; width: 10%;">Status</th>
                                <th style="text-align: center; width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#add').on('click', function(){
        window.open(
            "{{url('/event/create')}}", 
            '_blank', 
            'width=800,height=500,resizable=yes,screenx=0,screeny=0'
        );
    });

    $(document).ready(function () {
      let table1= $('#table_events').DataTable({
          ajax: {
            url : "{{url('/event/gridview')}}",
            type : "POST",
            headers: {
               'X-CSRF-TOKEN': "{{csrf_token()}}",
            },
          },
          serverSide: true,
          paging: false,
          order: [[0, 'asc']],
          info: false,
          ordering:false,
          button:false,
          destroy:true,
          columns: [
            {target: 0, data: 'DT_RowIndex',orderable: false, searchable: false},
            {target: 1, data: 'name'},
            {target: 2, data: 'description'},
            {target: 3, data: 'group_name'},
            {target: 4, data: 'status'},
            {target: 5, data: 'event_action'}
        ]
      });
      table1.buttons().remove();
    });

    function reloadDatatable() {
        $('#table_events').DataTable().ajax.reload();
    }


    $('body').on('click', '.tombol_edit', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/event/edit')}}"+"/"+id,
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })

    $('body').on('click', '.tombol_show', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/event/show')}}"+"/"+id,
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })
</script>
@endsection