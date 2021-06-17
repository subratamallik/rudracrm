@extends('layouts.app')

@section('title', 'CSV Upload')
@section('content')
<div class="">
    <div class="heading">Bajaj - Upload CSV of Cases</div>
    <div class="bg-white pa-3">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <table class="table border-none">
                <tr>
                    <td>Upload xlsx</td>
                    <td>
                        <input type="file" name="file" class="">
                        <p class="mt-2">Accept only .xlsx file.</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" class="btn btn-primary">Submit</button></td>
                </tr>
            </table>
            <div class="mt-3">
                [ <a href="{{ asset('assets/csv-format/bajaj.zip') }}" target="_blank" class="fw-bold">Click
                    here</a> to download the file format! ]
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection