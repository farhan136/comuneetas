@extends('layouts.layout_form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">              
                    <form action="{{url('/event/store', empty($event) ? '' : $event->id)}}" method="post">
                         @csrf
                          <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" autocomplete="off" name="name" value="{{empty($event) ? '' : $event->name}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea autocomplete="off" class="form-control" id="description" name="description">{{empty($event) ? '' : $event->description}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select autocomplete="off" class="form-control" name="category" required>
                                <option value=""></option>
                                <option value="Reuni"  {{isset($event) && $event->category == "Reuni" ? 'selected' : ''}}>Reuni</option>
                                <option value="Arisan" {{isset($event) && $event->category == "Arisan" ? 'selected' : ''}} >Arisan</option>
                                <option value="Pengajian" {{isset($event) && $event->category == "Pengajian" ? 'selected' : ''}} >Pengajian</option>
                                <option value="Lainnya" {{isset($event) && $event->category == "Lainnya" ? 'selected' : ''}} >Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" autocomplete="off" min="{{$current_date}}" value="{{empty($event) ? '' : $event->start_date}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" autocomplete="off" min="{{$current_date}}" value="{{empty($event) ? '' : $event->end_date}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" autocomplete="off" value="{{empty($event) ? '' : $event->price}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Group</label>
                            <select autocomplete="off" class="form-control" name="group" required>
                                <option value=""></option>
                                @foreach($groups as $group)
                                <option value="{{$group->id}}" {{isset($event) && $event->group_id == $group->id ? 'selected' : ''}}>{{$group->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($state == 'edit' && $event->group->admin_id == Auth::user()->id && ($event->status == 'Requested' || $event->status == 'Waiting To Do'))
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select autocomplete="off" class="form-control" name="status" required>
                                @if($event->status == 'Requested')
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                @elseif($event->status == 'Waiting To Do')
                                    <option value="Waiting To Do">Waiting To Do</option>
                                    <option value="Cancelled">Cancelled</option>
                                @endif
                            </select>
                        </div>
                        @endif

                        @if($state == 'edit')
                            @if($event->status != 'Rejected' && $event->status != 'Cancelled')
                                <button type="submit" class="btn btn-success">Submit</button>
                            @endif
                        @else
                            <button type="submit" class="btn btn-success">Submit</button>
                        @endif

                        
                    </form>
                </div> 
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $('#start_date').on('change', function() {
        $('#end_date').val('');
        $('#end_date').attr('min', $('#start_date').val());
    })
</script>
@endsection
