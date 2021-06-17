@extends('layouts.app')

@section('title', 'User List')
@section('content')
<div class="useraddform">
    <div class="heading"> Edit {{$response['master']->master_type}} : <span
            class="text-success">{{$response['master']->master_title}}</span></div>
    <div class="bg-white pa-3">
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="master_id" value="{{encoded_secure($response['master']->id)}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="master_title" class="form-control w300"
                            value="{{$response['master']->master_title}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Details</label>
                        <textarea name="master_details" class="form-control w50pc"
                            rows="3">{{$response['master']->master_details}}</textarea>
                    </div>
                </div>
            </div>
            @if ($response['master']->master_type=='process')
                
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Audit Status</label>
                        <p class="mt-2">
                            <label>
                            <input type="hidden" name="audit_status" value="0">
                            <input type="checkbox" name="audit_status" value="1" 
                            @if ($response['master']->audit_status==1)
                                checked
                            @endif
                            >
                        Please tick the checkbox, when you want to hide previous month's call history!
                    </label>
                        </p>
                    </div>
                </div>
            </div>
            @endif
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

@endsection

@section('script')

@endsection