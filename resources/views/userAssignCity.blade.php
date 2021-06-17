@extends('layouts.app')

@section('title', 'User List')
@section('content')
<div class="">
    <div class="row">
        <div class="col-md-6">
            <div class="useraddform bg-white">
                <div class="heading">City Assigned to user : <span
                        class="text-success">{{$response['userDetails']->name}}</span>
                </div>
                @if (count($response['city_assigned'])>0)
                <form action="{{url('user/process-priority-update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{encoded_secure($response['userDetails']->id)}}">
                    <div class="">
                        <table class="table table-bordered vm">
                            <thead>
                                <tr>
                                    <td class="">Process Title</td>
                                    <td class="text-center">Action</td>
                                </tr>
                            </thead>
                            @foreach ($response['city_assigned'] as $item)
                            <tr>
                                <td>
                                    <p class="fw-bold">{{$item->master_title}}
                                        <span class="fs-13 text-muted">{{$item->master_details}}</span>
                                    </p>
                                </td>
                                <td class=" w100 text-center">
                                    <a href="{{url('user/assign-city-remove')}}/{{encoded($response['userDetails']->id)}}/{{encoded($item->id)}}"
                                        class="btn btn-sm btn-danger fw-bold"
                                        onclick="return confirm('Are you sure to remove city {{$item->master_title}} from {{$response['userDetails']->name}}?')">Remove</a>
                                </td>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </form>
                @else
                <div class="noData">No record found!</div>
                @endif

            </div>
        </div>
        <div class="col-md-6">
            <div class="heading">List of Available City</div>
            <table class="table table-bordered vm">
                <thead>
                    <tr>
                        <td class="">Process Title</td>
                        <td class="w100 text-center">Assign</td>
                    </tr>
                </thead>
                @foreach ($response['city'] as $item)
                <tbody>
                    <tr>
                        <td>
                            <p class="fw-bold">{{$item->master_title}}
                                <span class="fs-13 text-muted">{{$item->master_details}}</span>
                            </p>
                        </td>
                        <td class="text-center w100">
                            <a href="{{url('user/assign-city')}}/{{encoded($response['userDetails']->id)}}/{{encoded($item->id)}}"
                                class="btn btn-sm btn-primary fw-bold"
                                onclick="return confirm('Are you sure to assign city {{$item->master_title}} to {{$response['userDetails']->name}}?')">Assign</a>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>





@endsection

@section('script')

@endsection