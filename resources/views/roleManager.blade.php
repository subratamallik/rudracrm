@extends('layouts.app')

@section('title', 'Master List')
@section('content')

<div class="heading">Role Management</div>
<form action="" method="POST">
    @csrf
    <table class="table vm roleManagerTable">
        @foreach ($response['roles'] as $item)
        <tr>
            <td class="fw-bold bg-default w200">{{$item->master_details}}</td>
            <td>
                @foreach ($response['modules'] as $itemModule)
                <label class="bg-default pa-1 <?php if(isset($response['role_manager'][$item->id]) &&  in_array($itemModule->id,explode(',',$response['role_manager'][$item->id]))){echo "active";}?>">                    
                    <input type="checkbox" name="module[{{$item->id}}][]" value="{{$itemModule->id}}"
                        <?php if(isset($response['role_manager'][$item->id]) &&  in_array($itemModule->id,explode(',',$response['role_manager'][$item->id]))){echo "checked";}?>>
                    {{$itemModule->title}}
                    {{$itemModule->module_name}}
                </label>
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>
    <button type="submit" class="btn btn-primary">Save</button>
</form>


<!-- Modals -->

@endsection

@section('script')

@endsection