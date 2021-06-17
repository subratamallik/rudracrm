@extends('layouts.app')

@section('title', 'CSV Upload')
@section('content')
<div class="">
    <div class="heading">Generate Report</div>
    <div class="bg-white pa-3">
        <form action="{{url('csv/upload/process')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table border-none">
                <tr>
                    <td class="w200">Select Process</td>
                    <td>
                        <select name="process_id" class="w150">
                            @foreach ($response['process'] as $item)
                            <option value="{{$item->id}}">{{$item->master_title}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select Date Range</td>
                    <td>
                        <input type="date" name="fromDate" id="">
                        TO <input type="date" name="toDate" id="">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" class="btn btn-primary">Export Report</button></td>
                </tr>
            </table>

        </form>
    </div>
</div>
@endsection

@section('script')

@endsection