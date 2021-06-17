@extends('layouts.app')

@section('title', 'Master List')
@section('content')

<!-- Button trigger modal -->
<table class="heading-table vm">
    <tr>
        <td>
            {{$response['master_type']}} Management
        </td>
        <td>
            <form action="" method="GET" class="mb-0">
                @csrf
                <table class="table vm pa-0">
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="q" @if (isset($_GET['q']))
                                value="{{$_GET['q']}}" @endif>
                        </td>
                        <?php /*?>
                        @if ($response['master_type']=='process')
                        <td class="w100">
                            <label class="fw-bold mb-0">
                                <input type="checkbox" name="audit_status" value="1" @if (isset($_GET['audit_status'])
                                    && $_GET['audit_status']==1) checked @endif> Audit
                            </label>
                        </td>
                        @endif
                        <?php */?>
                        <td>
                            <button type="submit" class="btn-sm btn btn-success fw-bold">Search</button>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <td class="text-right">
            <button type="button" class="btn btn-sm btn-primary text-uppercase fw-bold" data-toggle="modal"
                data-target="#masterAdd">Add New</button>
        </td>
    </tr>
</table>
<table class="table table-bordered pa-1 vm">
    <thead>
        <tr>
            <td class="w50 text-center">ID#</td>
            <td class="w250">Title / Code</td>
            <td class="">Details</td>
            <td class="w75 text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($response['master'] as $item)
        <tr data-id="{{$item->id}}" data-title="{{$item->master_title}}" data-details="{{$item->master_details}}">
            <td class="text-center fw-bold">{{$item->id}}</td>
            <td class="fw-bold">{{$item->master_title}}</td>
            <td>
                @if ($item->audit_status==1)
                <span class="badge badge-danger">Audit</span>
                @endif
                {{$item->master_details}}
            </td>
            <td>
                <a class="btn btn-sm btn-success fw-bold text-white cp"
                    href="{{url('master/update/')}}/{{encoded($item->id)}}/{{$item->master_type}}">Edit</a>
            </td>

        </tr>
        @endforeach

    </tbody>
</table>
<div class="paginationdiv">
    {{ $response['master']->appends(request()->input())->links() }}
</div>
<!-- Modals -->
@include('modals.master_add')
@include('modals.master_edit')
@endsection

@section('script')
<script>
    $( document ).on('click','.edit',function() {
        var tr=$(this).closest('tr');
        var modalId=$("#masterEdit");
        modalId.find("[name='master_id']").val(tr.attr('data-id'));
        modalId.find("[name='master_title']").val(tr.attr('data-title'));
        modalId.find("[name='master_details']").val(tr.attr('data-details'));
        modalId.modal('show');
    });
</script>
@endsection