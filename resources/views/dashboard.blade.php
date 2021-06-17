@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')


@if (hpCheckRole('dashboard_user_info') || hpCheckRole('dashboard_basic_info'))
<div class="mb-3">
    <div class="row">
        @if (hpCheckRole('dashboard_user_info'))
        <div class="col-md-6">
            <div class="box-shadow">
                <div class="heading">User Info</div>
                <table class="table table-bordered vm">
                    @if ($response['total_users'])
                    <tr>
                        @foreach ($response['total_users'] as $key=>$value)
                        <td class="fw-bold ">{{$key}}</td>
                        <td class="fs-20 fw-bold">
                            <span class="badge badge-dark">{{$value}}</span>
                        </td>
                        @if(($loop->index%3)==2)
                    </tr>
                    @endif
                    @endforeach
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @endif
        @if (hpCheckRole('dashboard_basic_info'))
        <div class="col-md-6">
            <div class="box-shadow">
                <div class="heading">Basic Info</div>
                <table class="table table-bordered vm">
                    <tr>
                        <td class="fw-bold ">Total User Role</td>
                        <td class="fs-20 fw-bold">
                            <span class="badge badge-dark">{{$response['total_nasters']['user_role']}}</span>
                        </td>
                        <td class="fw-bold ">Total City</td>
                        <td class="fs-20 fw-bold">
                            <span class="badge badge-dark">{{$response['total_nasters']['city']}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ">Total Disposition</td>
                        <td class="fs-20 fw-bold">
                            <span class="badge badge-dark">{{$response['total_nasters']['disposition']}}</span>
                        </td>
                        <td class="fw-bold ">Total Process</td>
                        <td class="fs-20 fw-bold">
                            <span class="badge badge-dark">{{$response['total_nasters']['process']}}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endif
<div class="mb-3">
    <div class="row">
        @if (hpCheckRole('dashboard_priority_cases'))
        <div class="<?=(hpCheckRole('dashboard_csv_upload'))?'col-md-6':'col-md-12'?>">
            <div class="box-shadow">
                <div class="heading">Priority Cases
                    <a href="{{url('post?priority=all')}}" class="text-white float-right fw-bold">View All ></a>
                </div>
                <table class="table table-bordered vm">
                    <thead>
                        <tr>
                            <td>Account Number</td>
                            <td>Customer Info</td>
                            <td>Next Action</td>
                            <td>Priority</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($response['total_cases_priority'])>0)
                        @foreach ($response['total_cases_priority'] as $item)
                        <tr>
                            <td class="fw-bold">
                                <a href="{{url('post/details/')}}/{{encoded($item->id)}}">{{$item->account_no}}</a>

                            </td>
                            <td class="">
                                <p class="fw-bold">{{$item->customer_name}}</p>
                                <p class="fs-12">{{$item->process}}
                                    <span class="badge badge-secondary">{{$item->risk}}</span>
                                </p>
                            </td>
                            <td class="w125 fs-13 fw-bold">
                                <p>{{$item->next_action_date}}</p>
                                <p>{{$item->next_action_time}}</p>
                            </td>
                            <td class="text-center w100 {{strtolower(get_nxtactn_prrt($item->next_action_priority))}}">
                                <span
                                    class="badge badge-dark pb-1">{{get_nxtactn_prrt($item->next_action_priority)}}</span>

                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">
                                <div class="noData">No data found!</div>
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @if (hpCheckRole('dashboard_csv_upload'))
        <div class="<?=(hpCheckRole('dashboard_priority_cases'))?'col-md-6':'col-md-12'?>">
            <div class="box-shadow">
                <div class="heading">CSV Uploaded History</div>
                <table class="table table-bordered vm">
                    <thead>
                        <tr>
                            <td>Date</td>
                            <td>File Name</td>
                            <td>Uploaded By</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($response['csv_uploaded'])>0)
                        @foreach ($response['csv_uploaded'] as $item)
                        <tr>
                            <td class="fw-bold fs-12 w100">{{hpDate($item->uploaded_date)}}</td>
                            <td class="fw-bold">{{$item->filename}}</td>
                            <td class="w125 text-center">{{$item->name}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">
                                <div class="noData">No data found!</div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection