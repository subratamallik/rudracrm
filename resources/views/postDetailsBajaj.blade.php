@extends('layouts.app')

@section('title', 'Master List')
@section('content')


<div class="mb-2">
    <table class="vm callingPartTable w100pc">
        <tr>
            <td class="pa-3 text-white">
                <p class="fw-bold">{{$response['post']->insured_name}}</p>
                <p class="mt-1">{{$response['post']->address}}</p>
                <p class="mt-1">{{$response['post']->city}}, {{$response['post']->state}}</p>
            </td>
            <td class="w300 pr-3 text-white text-right text-uppercase">
                <p>Status : <b>{{$response['post']->status}}</b></p>
                <p class="mt-1">Assigned: <b>{{$response['post']->user_name}}</b></p>


            </td>
        </tr>
    </table>
</div>

<div class="">
    <div class="heading"> Bajaj Details Information :</div>
    <div class="postTableDiv mb-4">
        <table class="table postTable vm">
            <tr>
                <td>HOID</td>
                <td>{{$response['post']->hoid}}</td>
                <td>Insured Name</td>
                <td>{{$response['post']->insured_name}}</td>
            </tr>
            <tr>
                <td>Policy Numbers</td>
                <td>{{$response['post']->policy_numbers}}</td>
                <td>Address</td>
                <td>{{$response['post']->address}}</td>
            </tr>
            <tr>
                <td>Allocated Date</td>
                <td>{{$response['post']->allocated_date}}</td>
                <td>City</td>
                <td>{{$response['post']->city}}</td>
            </tr>
            <tr>
                <td>Visit Date</td>
                <td>{{$response['post']->visit_date}}</td>
                <td>State</td>
                <td>{{$response['post']->state}}</td>
            </tr>
            <tr>
                <td>Report Submit Date</td>
                <td>{{$response['post']->report_submit_date}}</td>
            </tr>
        </table>
    </div>
</div>
<div class="mb-4">
    <div class="heading"> Documents:
        <div class="float-right text-right">
            <form id="docForm" class="display-inline" action="{{url('bajaj/fileupload')}}" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="postId" value="{{$response['post']->id}}">
                @csrf
                Upload Documents <input type="file" class="ml-2" name="file" multiple>
                <button type="submit" class="btn btn-sm btn-info">Upload</button>
            </form>
        </div>
    </div>
    @if (count($response['documents'])>0)
    <div class="bg-white pa-3">
        @foreach ($response['documents'] as $item)
        <p>
            <a target="_blank" class="fs-18" href="{{env('APP_URL')}}/storage/app/public/{{$item->file_name}}">{{$item->file_name}}</a>
        </p>
        @endforeach
    </div>
    @else
    <div class="noData mt-0">No documents found!</div>
    @endif
</div>
<div class="">
    <div class="heading"> Feedback Submitted:</div>
    <div class="noData mt-0">No feedback submitted!</div>
</div>

<!-- Modals -->
@endsection
@section('script')
@endsection