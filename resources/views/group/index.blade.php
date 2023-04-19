@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Group') }} <button type="button" class="btn btn-outline-success btn-sm" id="add" style="width:10%; float: right;">Add</button></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id="table_groups" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;"></th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;  width: 60%;">Description</th>
                                <th style="text-align: center; width: 25%;">Action</th>
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

<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="group_title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="table_members" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th style="text-align: center; width: 5%;">No</th>
              <th style="text-align: center;  width: 60%;">Name</th>
              <th style="text-align: center;">Status</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
    $('#add').on('click', function(){
        window.open(
            "{{url('/mygroup/create')}}", 
            '_blank', 
            'width=800,height=500,resizable=yes,screenx=0,screeny=0'
        );
    });

    $(document).ready(function () {
      let table1= $('#table_groups').DataTable({
          ajax: {
            url : "{{url('/mygroup/gridview')}}",
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
            {target: 3, data: 'group_action'}
        ]
      });
      table1.buttons().remove();
    });

    function reloadDatatable() {
        $('#table_groups').DataTable().ajax.reload();
    }

    $('body').on('click', '.tombol_show', function(){
      let id = $(this).data('id');
      let name = $(this).data('name');
      $('#group_title').html(name)
      let table2= $('#table_members').DataTable({
          ajax: {
            url : "{{url('/mygroup/gridview_listmember')}}",
            data : {'id':id},
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
          destroy:true,
          button:false,
          columns: [
            {target: 0, data: 'DT_RowIndex',orderable: false, searchable: false},
            {target: 1, data: 'name'},
            {target: 2, data: 'status'}
        ]
      });
      table2.buttons().remove();
    })

    $('body').on('click', '.tombol_invite', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/mygroup/invite_people')}}"+"/"+id,
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })

    $('body').on('click', '.tombol_edit', function(){
      let id = $(this).data('id');
      window.open(
          "{{url('/mygroup/edit')}}"+"/"+id,
          '_blank', 
          'width=800,height=500,resizable=yes,screenx=0,screeny=0'
      );
    })
</script>
@endsection