@extends('layouts.app')

@section('title', 'User List')
@section('content')
<div class="useraddform">
    <div class="heading mb-3">
        <div class="row">
            <div class="col-md-6">
                Update Disposition : <span class="text-success">{{$response['disposition']->master_title}}</span>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{url('disposition/list')}}" class="btn btn-sm">
                    < Back to Disposition List</a> </div> </div> </div> <div class="heading">Disposition information
            </div>
            <div class="bg-white pa-3">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="disposition_id" value="{{encoded_secure($response['disposition']->id)}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Process</label>
                                <select name="process_id" class="form-control w350">
                                    @foreach ($response['process'] as $item)
                                    <option value="{{$item->id}}" @if ($response['disposition']->process_id==$item->id)
                                        selected
                                        @endif
                                        >{{$item->master_title}}
                                        @if ($item->master_details!='')
                                        [{{$item->master_details}}]
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="master_title" class="form-control w300"
                                    value="{{$response['disposition']->master_title}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="master_details" class="form-control"
                                    rows="3">{{$response['disposition']->master_details}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Available For</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="avaiablefor[]" value="field"
                                        id="field"
                                        @if (in_array('field',explode(',',$response['disposition']->avaiablefor)))
                                        checked
                                    @endif
                                        >
                                    <label class="form-check-label" for="field">
                                        Field
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="avaiablefor[]" value="tc"
                                        id="tc"
                                        @if (in_array('tc',explode(',',$response['disposition']->avaiablefor)))
                                            checked
                                        @endif
                                        >
                                    <label class="form-check-label" for="tc">
                                        Tele Caller
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

        @endsection

        @section('script')

        @endsection