@extends('layouts.app')

@section('title', 'Master List')
@section('content')


<div class="heading">
    <div class="row">
        <div class="col-md-8">Call History</div>
        <div class="col-md-4 text-right">
            <a class="cp btn btn-sm btn-primary fw-bold backBtn text-white"> Back</a> </div>
    </div>
</div>
@if (count($response['callHistory'])>0)
<table class="table table-bordered vm">
    <thead>
        <tr>
            <td class="w100 text-center">Duration</td>
            <td class="w125 text-center">Calling Date</td>
            <td class="w125 text-center">Number</td>
            <td class="w150 text-center">Disposition</td>
            <td class="w100 text-center">Sub Disp.</td>
            <td class="w100 text-center">Workable?</td>
            <td class="">Feedback Note</td>
            <td class="w150 text-center">Called By</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($response['callHistory'] as $item)
        <tr>
            <td class="fw-bold text-center w100">
                <span class="badge badge-dark fs-16">{{$item->calltime}}</span>
            </td>
            <td class="text-center fw-bold fs-13 w125 ">{{hpDate($item->create_date, 'd M Y H:i:s')}}</td>
            <td class="text-center fw-bold w125 ">{{$item->phone}}</td>
            <td class="fw-bold text-center w150">{{$item->disposition}}</td>
            <td class="fw-bold text-center">{{$item->sub_disposition_code}}</td>
            <td class="fw-bold text-center">{{$item->workable_status}}</td>
            <td class="">{{$item->note}}</td>
            <td class="w150 text-center">{{$item->user_name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="noData bg-white">No data found !</div>
@endif
@endsection

@section('script')
@endsection