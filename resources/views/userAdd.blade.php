@extends('layouts.app')

@section('title', 'User List')
@section('content')

<div class="useraddform">
    <div class="heading">Add new user</div>
    <div class="bg-white pa-3">
        <form action="" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="roles" class="form-control w150">
                            @foreach ($response['roles'] as $item)
                            <option value="{{$item->id}}">{{$item->master_details}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email ID</label>
                        <input type="text" name="email" class="form-control w300">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" class="form-control w200">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control w200">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control w250">
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