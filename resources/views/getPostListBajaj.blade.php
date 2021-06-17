@extends('layouts.app')

@section('title', 'Post List')
@section('content')

<div class="heading">Bajaj - List of Cases</div>
<table class="table border-none vm mb-0 pa-0">
    <tr>
        <td class="">
            <form action="" id="searchDisPForm" method="GET" class="mb-0">
                <table class="table vm">
                    <tr>
                        <td>
                            <input type="text" name="q" class="form-control" @if (isset($_GET['q']))
                                value="{{$_GET['q']}}" @endif placeholder="Search here..">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success">Search</button>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        @if (hpCheckRole('process_assing'))
        <td class="text-right w200">
            <a href="{{url('bajaj/csv/upload')}}" class="btn btn-sm btn-primary fw-bold">
                Upload CSV of Cases
            </a>
        </td>
        @endIf
    </tr>
</table>
@if (count($response['post'])>0)
<form action="{{url('bajaj/post/reassign')}}" method="POST">
    @csrf
    <table class="table table-bordered vm pa-0 postTableList">
        <thead>
            @if (hpCheckRole('process_assing'))
            <tr>
                <td colspan="8" class="heading w200 actionTd">
                    <span class="text-white">Reassign To</span>
                    <select  name="post_assign_user_id" class="fs-14 ml-2 mr-2" style="padding: 5px;" required>
                        <option value="">Select Tele Caller</option>
                        @foreach ($response['telecallers'] as $item)
                        <option value="{{$item->id}}">{{$item->name}} [{{$item->username}}]</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </td>
            </tr>
            @endif
            <tr>
                @if (hpCheckRole('process_assing'))
                <td class="text-center"><input type="checkbox" id="selectAllChbox"></td>
                @endIf
                <td class=" text-center">HOID</td>
                <td class=" text-center">Policy Numbers</td>
                <td class=" text-center">Claim Numbers</td>
                <td class=" text-center">Allocated Date</td>
                <td class="">Customer Name</td>
                <td class="text-center">Assigned</td>
                <td class=" text-center">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($response['post'] as $item)
            <tr>
                @if (hpCheckRole('process_assing'))
                <td class="w50 text-center"><input type="checkbox" name="post_id[]" value="{{$item->id}}"></td>
                @endIf
                <td class="w50 fw-bold text-center">{{$item->hoid}}</td>
                <td class="w150 fs-14 text-center">{{$item->policy_numbers}}</td>
                <td class="w150 fs-14 text-center">{{$item->claim_number}}</td>
                <td class="w150 fs-14 text-center">{{$item->allocated_date}}</td>
                <td class="">
                    <p class="fw-bold">{{$item->insured_name}}</p>
                    <p class="fs-11">{{$item->address}}</p>
                </td>
                <td class="w150 fs-14 text-center">
                    <p>{{$item->user_name}}</p>
                    <p class="fs-12">{{$item->user_username}}</p>
                </td>
                <td class="text-center w50">
                    <a href="{{url('bajaj/post/details/'.$item->id)}}"
                        class="btn btn-sm btn-success fw-bold">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="paginationdiv">
        {{ $response['post']->appends(request()->input())->links() }}
        <div class="clear"></div>
    </div>
</form>
@else
<div class="noData">
    No Record Found !
</div>
@endif

@endsection

@section('script')
<script>
    $(document).on('click','#selectAllChbox',function(){
        if(this.checked) {
            $('.postTableList').find(':checkbox').prop('checked', this.checked)
        }
        else {
            $('.postTableList').find(':checkbox').prop('checked', this.checked)
        }
    });

    $('.postTableList tbody tr td:nth-child(1)').click(function(event) {
    if (event.target.type !== 'checkbox') {
      $(':checkbox', this).trigger('click');
    }
  });
</script>
@endsection