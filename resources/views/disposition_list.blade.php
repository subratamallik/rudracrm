@extends('layouts.app')

@section('title', 'Disposition List')
@section('content')

<!-- Button trigger modal -->
<div>
    <table class="table vm mb-0 pa-0">
        <tr>
            <td class="heading w300">Disposition

                @if (isset($_GET['title']) && $_GET['title']!='')
                : <span class="text-muted">{{$_GET['title']}}</span>
                @endif

            </td>
            <td class="">
                <form action="" id="searchDisPForm" method="GET" class="mb-0">
                    @if (isset($_GET['parent_id']))
                        <input type="hidden" name="parent_id" value="{{$_GET['parent_id']}}">
                    @endif
                    @if (isset($_GET['title']))
                        <input type="hidden" name="title" value="{{$_GET['title']}}">
                    @endif
                    <select name="process_id" class="form-control processSelect">
                        <option value="">All Process</option>
                        @foreach ($response['process'] as $item)
                        <option value="{{$item->id}}" @if (isset($_GET['process_id']) && $_GET['process_id']==$item->id )
                            selected
                            @endif
                            >{{$item->master_title}}
                            @if ($item->master_details!='')
                            [{{$item->master_details}}]
                            @endif
                        </option>
                        @endforeach
                    </select>
                </form>
            </td>

            <td class="text-right w200">
                <a type="button" class="btn btn-sm btn-primary text-uppercase fw-bold text-white" data-toggle="modal"
                    data-target="#dispositionAdd">Add New
                    @if (isset($_GET['title']) && $_GET['title']!='')
                    SUB - <span class="text-white">{{$_GET['title']}}</span>
                    @endif
                    </button>
            </td>
        </tr>
    </table>
</div>
<table class="table table-bordered pa-1 vm">
    <thead>
        <tr>
            <td class="w50 text-center">ID#</td>
            <td class="w250">Code</td>
            <td class="">Details</td>
            <td class="w250">Process</td>
            <td class="w75 text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        @if (count($response['disposition'])>0)
        @foreach ($response['disposition'] as $item)
        <tr data-id="{{$item->id}}" data-title="{{$item->master_title}}" data-details="{{$item->master_details}}">
            <td class="text-center fw-bold">{{$item->id}}</td>
            <td class="fw-bold">
                <?php /*?>
                @if (!isset($_GET['parent_id']))
                <a
                    href="{{url('disposition/list')}}?parent_id={{$item->id}}&process_id={{$item->process_id}}&title={{$item->master_title}}">{{$item->master_title}}</a>
                @else
                {{$item->master_title}}
                @endif
                <?php */?>
                {{$item->master_title}}
            </td>
            <td>{{$item->master_details}}</td>
            <td>{{$item->process_title}}</td>
            <td><a href="{{url('disposition/edit')}}/{{encoded($item->id)}}"
                    class="edit btn btn-sm btn-success fw-bold text-white cp">Edit</a></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6">
                <div class="noData">
                    No record found!
                </div>
            </td>
        </tr>
        @endif
    </tbody>
</table>

<!-- Modals -->
@include('modals.disposition_add')
@endsection

@section('script')
<script>
    $( document ).on('change','.processSelect',function() {
        $('#searchDisPForm').submit();
    });
</script>
@endsection