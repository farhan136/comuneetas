@extends('layouts.layout_form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Group</div>
                <div class="card-body">              
                    <form action="{{url('/mygroup/store', empty($group) ? '' : $group->id)}}" method="post">
                         @csrf
                          <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" autocomplete="off" name="name" value="{{empty($group) ? '' : $group->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea autocomplete="off" class="form-control" id="description" name="description">{{empty($group) ? '' : $group->description}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div> 
        </div>
    </div>
</div>
</div>
@endsection

