@extends('layouts.app_blank')

@section('title', 'Login')
@section('content')
<div class="loginWrapper">
    <div class="heading">
        Login
    </div>
    <div class="container bg-white pa-3">
        <form method="POST" action="">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" name="username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection