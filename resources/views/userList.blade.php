@extends('layouts.app')

@section('title', 'User List')
@section('content')

<div class="heading">List Of Users</div>
<table class="table table-bordered vm">
    <thead>
        <tr>
            <td class="w50 text-center">ID#</td>
            <td class="">Name</td>
            <td class="w100 text-center">Mobile</td>
            <td class="w150 text-center">Username</td>
            <td class="w100 text-center">Role</td>
            <td class="w100 text-center">Status</td>
            <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($response['users'] as $item)
        <tr>
            <td class="fw-bold text-center">{{$item->id}}</td>
            <td class="fw-bold">{{$item->name}}</td>
            <td class="text-center">{{$item->mobile}}</td>
            <td class="text-center">{{$item->username}}</td>
            <td class="text-center {{helperPermalink($item->role_key)}}"><span class="badge badge-default border-default pb-1">{{$item->role_title}}</span></td>
            <td class="text-center text-uppercase fw-bold {{helperPermalink($item->status)}}">{{$item->status}}</td>
            <td class="text-center w100">
                <a href="{{url('user/user-edit')}}/{{encoded($item->id)}}" class="btn btn-sm btn-success fw-bold"><i class="fas fa-pencil-alt"></i> Edit</a>
                <?php /*?>
                <a href="{{url('user/assign-city')}}/{{encoded($item->id)}}" title="Assign City" class="btn btn-sm btn-primary fw-bold">AC</a>
                <a href="{{url('user/assign-process')}}/{{encoded($item->id)}}" title="Assign Process" class="btn btn-sm btn-info fw-bold">AP</a>
                <?php */?>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

@endsection

@section('script')

@endsection