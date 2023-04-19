@extends('layouts.layout_form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Detail Event {{$event->name}}</div>
                <div class="card-body">              
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" readonly value="{{$event->name}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea autocomplete="off" class="form-control" readonly id="description" name="description">{{$event->description}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" readonly value="{{$event->category}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" readonly value="{{$event->status}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" class="form-control" readonly value="{{$event->price}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" class="form-control" readonly value="{{$event->start_date}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="text" class="form-control" readonly value="{{$event->end_date}}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Group Name</label>
                            <input type="text" class="form-control" readonly value="{{$event->group_name}}">
                        </div>

                </div> 
        </div>
    </div>
</div>
</div>
@endsection
