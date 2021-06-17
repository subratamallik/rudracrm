@extends('layouts.app')

@section('title', 'User List')
@section('content')
<div class="useraddform">
    <div class="heading mb-3">
<div class="row">
    <div class="col-md-6">
        Update user : <span class="text-success">{{$response['userDetails']->name}}</span>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{url('user/assign-city')}}/{{encoded($response['userDetails']->id)}}" class="btn btn-sm btn-primary fw-bold mr-2">
            Assign City
        </a>
        <a href="{{url('user/assign-process')}}/{{encoded($response['userDetails']->id)}}" class="btn btn-sm btn-primary fw-bold">
            Assign Process
        </a>
    </div>
</div>

    </div>
    <div class="heading">Basic User information</div>
    <div class="bg-white pa-3">
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{encoded_secure($response['userDetails']->id)}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{$response['userDetails']->name}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="roles" class="form-control w150">
                            @foreach ($response['roles'] as $item)
                            <option value="{{$item->id}}"
                                <?php if($response['userDetails']->role==$item->id){echo 'selected';}?>>
                                {{$item->master_details}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email ID</label>
                        <input type="text" name="email" class="form-control w300"
                            value="{{$response['userDetails']->email}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" class="form-control w200"
                            value="{{$response['userDetails']->mobile}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control w200"
                            value="{{$response['userDetails']->username}}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="heading mt-4">Update Password</div>
    <div class="bg-white pa-3">
        <form action="{{url('user/update-password')}}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{encoded_secure($response['userDetails']->id)}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control w200">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection

@section('script')

@endsection