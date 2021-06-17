@extends('layouts.app')

@section('title', 'Post List')
@section('content')

<div class="heading">List of Cases</div>
<table class="table border-none vm mb-0 pa-0">
    <tr>
        <td class="">
            <form action="" id="searchDisPForm" method="GET" class="mb-0">
                <table class="table vm">
                    <tr>
                        <td class="w250">
                            <select name="process_id" class="form-control processSelect">
                                <option value="">All Process</option>
                                @foreach ($response['process'] as $item)
                                <option value="{{$item->id}}" @if (isset($_GET['process_id']) &&
                                    $_GET['process_id']==$item->id )
                                    selected
                                    @endif
                                    >{{$item->master_title}}
                                    @if ($item->master_details!='')
                                    [{{$item->master_details}}]
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="w250">
                            <select name="disposition_id" class="form-control processSelect">
                                <option value="">All Disposition</option>
                                <option value="0" @if (isset($_GET['disposition_id']) && $_GET['disposition_id']=="0" )
                                    selected @endif>Only Blank</option>
                                @foreach ($response['disposition'] as $item)
                                <option value="{{$item->id}}" @if (isset($_GET['disposition_id']) &&
                                    $_GET['disposition_id']==$item->id )
                                    selected
                                    @endif
                                    >{{$item->master_title}}
                                </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="date" class="form-control w175 display-inline" name="from_date"
                                value="<?=(isset($_GET['from_date']) && $_GET['from_date']!="")?$_GET['from_date']:''?>">
                            to
                            <input type="date" class="form-control w175 display-inline" name="to_date"
                                value="<?=(isset($_GET['to_date']) && $_GET['to_date']!="")?$_GET['to_date']:''?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" name="q" class="form-control" @if (isset($_GET['q']))
                                value="{{$_GET['q']}}" @endif
                                placeholder="Search by account no/ customer no/ telecaller - username, mobile">
                        </td>
                        <td>
                            <select name="priority" class="form-control w150 display-inline">
                                <option value="">Select Priority</option>
                                <option value="all" @if (isset($_GET['priority']) && $_GET['priority']=="all" ) selected
                                    @endif>All Priority</option>
                                    
                                @foreach (nxtactn_prrt() as $key=>$val)
                                <option value="{{$val}}" @if (isset($_GET['priority']) && $_GET['priority']==$val )
                                    selected @endif>{{$key}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="ml-2 btn btn-success">Search</button>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        @if (hpCheckRole('process_assing'))
        <td class="text-right w200">
            <a href="{{url('csv/upload')}}" class="btn btn-sm btn-primary fw-bold">
                Upload CSV of Cases
            </a>
        </td>
        @endIf
    </tr>
</table>
@if (count($response['post'])>0)
<form action="{{url('post/reassign')}}" method="POST">
    @csrf
    <table class="table table-bordered vm pa-0 postTableList">
        <thead>
            @if (hpCheckRole('process_assing'))
            <tr>
                <td colspan="9" class="heading w200 actionTd">
                    <span class="text-white">Reassign To</span>
                    <select name="post_assign_user_id" class="fs-14 ml-2 mr-2" style="padding: 5px;" required>
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
                <td class=" text-center">Account No</td>
                <td class=" text-center">Customer ID</td>
                <td class="">Customer Name</td>
                <td class=" text-center">Process</td>
                <td class=" text-center">Disposition</td>
                <td class=" text-center">Priority</td>
                <td class="">Assigned TC</td>
                <td class=" text-center">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($response['post'] as $item)
            <tr data-href="{{url('post/details')}}/{{encoded($item->id)}}">
                @if (hpCheckRole('process_assing'))
                <td class="w50 text-center"><input type="checkbox" name="post_id[]" value="{{$item->id}}"></td>
                @endIf
                <td class="link w150 fw-bold text-center">{{$item->account_no}}</td>
                <td class="link w150 fw-bold text-center">{{$item->customer_id}}</td>
                <td class="link ">{{$item->customer_name}}</td>
                <td class="link w200 text-center">{{$item->process}}</td>
                <td class="link w200 text-center">{{hp_master($item->disposition_id)}}</td>
                <td class="link w100 text-center">{{get_nxtactn_prrt($item->next_action_priority)}}</td>
                <td class="link w200 ">{{$item->user_name}} <span class="fs-13">({{$item->user_username}})</span></td>
                <td class="text-center w50">
                    <a href="{{url('post/details')}}/{{encoded($item->id)}}"
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