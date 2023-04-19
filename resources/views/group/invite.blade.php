@extends('layouts.layout_form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invite People To Your Group</div>
                <div class="card-body">              
                    <table id="people_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                            <tr>
                                <td style="text-align: center;">{{$loop->iteration}}</td>
                                <td style="text-align: center;">{{$member->username}}</td>
                                <td style="text-align: center;"><button class="btn btn-sm btn-outline-success btn-invite" data-id="{{$member->id_user}}">Send Email</button> </td>
                            </tr>
                            @empty
                            <tr>
                                <td style="text-align: center;" colspan="3">There is no data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> 
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">

<script type="text/javascript">
    $('.btn-invite').on('click', function(){
        let id = $(this).data('id');
        let group_id = {{$group_id}};
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3ccf1b',
          cancelButtonColor: '#f73416',
          confirmButtonText: 'Yes, send email!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url : "{{url('/mygroup/send_email')}}",
                data : {'id':id, 'group_id':group_id},
                type : "POST",
                headers: {
                   'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                success: function(ret) { 
                    console.log(ret);
                    // data = JSON.parse(ret);
                    // $('#messagetitle2').html(data.status);
                    // $('#show_info').modal('hide');
                    // $('#show_info2').modal('show');
                }
            })
            // Swal.fire(
            //   'Success!',
            //   'Your email has been sent.',
            //   'success'
            // )
          }
        })
    })
</script>
@endsection