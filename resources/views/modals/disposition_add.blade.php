<div class="modal fade" id="dispositionAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if (isset($_GET['title']) && $_GET['title']!='')
                    Add Sub Disposition of <span class="text-info">{{$_GET['title']}}</span>
                    @else
                    Add Disposition
                    @endif

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('disposition/add')}}" method="POST">
                @csrf
                @if (isset($_GET['parent_id']) && $_GET['parent_id']!='' )
                <input type="hidden" name="parent_id" value="{{encoded($_GET['parent_id'])}}">
                @endif
                <div class="modal-body">
                    <table class="table vm table-bordered">
                        <tr>
                            <td class="w100">Process</td>
                            <td>
                                <select name="process_id" class="form-control">
                                    @foreach ($response['process'] as $item)
                                    <option value="{{$item->id}}" @if (isset($_GET['process_id']) &&
                                        $_GET['process_id']==$item->id)
                                        selected
                                        @endif
                                        >
                                        {{$item->master_title}}
                                        @if ($item->master_details!='')
                                        [{{$item->master_details}}]
                                        @endif

                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="w100">Code</td>
                            <td><input type="text" name="master_title" class="form-control"></td>
                        </tr>
                        <tr>
                            <td class="w100">Description</td>
                            <td><textarea name="master_details" class="form-control" rows="3"></textarea></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>