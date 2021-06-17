<div class="modal fade" id="callFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Submit Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('post/submit-report')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{encoded($response['post']->id)}}">
                    <input type="hidden" name="source" id="callSource" value="manual">
                    <input type="hidden" name="phone" id="phoneNumber" value="">
                    <table class="table vm table-bordered">
                        <tr>
                            <td class="w100">Disposition</td>
                            <td>
                                <select name="disposition_id" class="form-control text-capitalize fw-bold">
                                    @foreach ($response['disposition'] as $item)
                                    <option value="{{$item->id}}">{{$item->master_title}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Sub Disp. Code</td>
                            <td>
                                <input type="text" name="sub_disposition_code" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Workable Status</td>
                            <td>
                                <select name="workable_status" class="form-control text-capitalize fw-bold">
                                    @foreach (workable_status() as $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Note</td>
                            <td>
                                <textarea name="note" class="form-control" rows="4"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Next Action Date</td>
                            <td>
                                <input type="date" name="next_action_date" class="form-control-normal">
                                <input type="time" name="next_action_time" class="form-control-normal">
                            </td>
                        </tr>
                        <tr>
                            <td>Action Priority</td>
                            <td>
                                <select name="next_action_priority"  class="form-control-normal">
                                    <option value="">Select</option>
                                    @foreach (nxtactn_prrt() as $key=>$val)
                                    <option value="{{$val}}">{{$key}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn fw-bold btn-success">Save</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>