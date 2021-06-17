<div class="modal fade" id="addNewContactInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Contact Info.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('post/new-contact')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{encoded($response['post']->id)}}">
                    <table class="table vm table-bordered">
                        <tr>
                            <td class="w100">Phone Number</td>
                            <td>
                                <input type="text" name="phone" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>
                                <textarea name="address" class="form-control" rows="4"></textarea>
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