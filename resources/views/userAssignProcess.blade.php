@extends('layouts.app')

@section('title', 'User List')
@section('content')
<div class="">
    <div class="row">
        <div class="col-md-6">
            <div class="useraddform bg-white">
                <div class="heading">Assigned process to user : <span
                        class="text-success">{{$response['userDetails']->name}}</span>
                </div>
                @if (count($response['process_assigned'])>0)
                <form action="{{url('user/process-priority-update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{encoded_secure($response['userDetails']->id)}}">
                    <div class="">
                        <table class="table table-bordered vm">
                            <thead>
                                <tr>
                                    <td class="">Process Title</td>
                                    <td class="text-center">Pririty</td>
                                    <td class="text-center">Action</td>
                                </tr>
                            </thead>
                            @foreach ($response['process_assigned'] as $item)
                            <tr>
                                <td>
                                    <p class="fw-bold">{{$item->master_title}}
                                        <span class="fs-13 text-muted">{{$item->master_details}}</span>
                                    </p>
                                </td>
                                <td class="text-center w100">
                                    <input type="text" class="form-control w75 form-control-sm text-center"
                                        name="priority[{{$item->users_process_id}}]" value="{{$item->priority}}">
                                </td>
                                <td class=" w100 text-center">
                                    <a href="{{url('user/assign-process-remove')}}/{{encoded($response['userDetails']->id)}}/{{encoded($item->id)}}"
                                        class="btn btn-sm btn-danger fw-bold"
                                        onclick="return confirm('Are you sure to remove process {{$item->master_title}} from {{$response['userDetails']->name}}?')">Remove</a>
                                </td>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="fs-13 fw-bold text-muted">After change the priority please click on update
                                    button to save</td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-sm fw-bold">Update</button>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </form>
                @else
                <div class="noData">No record found!</div>
                @endif

            </div>
        </div>
        <div class="col-md-6">
            <div class="heading">List of Available Process</div>
            <table class="table table-bordered vm">
                <thead>
                    <tr>
                        <td class="">Process Title</td>
                        <td class="w100 text-center">Assign</td>
                    </tr>
                </thead>
                @foreach ($response['process'] as $item)
                <tbody>
                    <tr>
                        <td>
                            <p class="fw-bold">{{$item->master_title}}
                                <span class="fs-13 text-muted">{{$item->master_details}}</span>
                            </p>
                        </td>
                        <td class="text-center w100">
                            <a href="{{url('user/assign-process')}}/{{encoded($response['userDetails']->id)}}/{{encoded($item->id)}}"
                                class="btn btn-sm btn-primary fw-bold"
                                onclick="return confirm('Are you sure to assign process {{$item->master_title}} to {{$response['userDetails']->name}}?')">Assign</a>
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