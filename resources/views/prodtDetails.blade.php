@extends('layouts.app')

@section('title', 'Master List')
@section('content')


<div class="fixed callingPart">
    <table class="vm callingPartTable w100pc">
        <tr>
            <td class="w100 pl-2">
                <a class="btn btn-info text-white goBack cp">< BACK</a>
            </td>
            <td class="w175 pl-2">
                <div class="callingNumber">
                    <input type="text" name="calling_number" id="calling_number_input"
                        class="calling_number_input form-control text-center fs-16" value=""
                        placeholder="Enter Number..">
                </div>
            </td>
            <td class="300 pl-3">
                <div class="calltype mt-4 mb-4">
                    <a class="btn btn-success fw-bold callbtn_off" href="#"><i class="fas fa-phone-alt"></i> Call</a>
                    <button class="btn btn-danger fw-bold stopbtn ml-2" type="button"><i class="fas fa-stop-circle"></i>
                        Stop</button>
                    <?php /*?>
                    <label class="fw-bold"><input type="radio" name="call_type" value="0" checked>
                        GSM</label>
                    <label class="ml-2 fw-bold"><input type="radio" name="call_type" value="+91">
                        CDMA</label>
                    <input type="text" name="calltime" readonly
                        class="timer form-control-normal ml-2 w100 text-center display-none">
                    <?php */?>
                </div>
            </td>
            <td class="text-right pr-1">
                <div class="callingbtns">
                    <?php /*?>
                    <button class="btn btn-success fw-bold callbtn">Call</button>
                    <button class="btn btn-info fw-bold ml-2 pausebtn" disabled>Hold</button>
                    <button class="btn btn-info fw-bold ml-2 mr-2 playbtn" disabled>Play</button>
                    <button class="btn btn-danger fw-bold stopbtn" type="button" disabled>Stop</button>
                    <?php */?>
                    <a href="{{url('report/callhistory')}}/{{encoded($response['post']->id)}}"
                        class="btn fw-bold btn-info"> <i class="fas fa-history"></i> History
                    </a>
                    <button type="button" class="addFeedback btn fw-bold btn-danger ml-2"><i
                            class="fas fa-comment-medical"></i> Feedback</button>
                    <button type="button" class="addNewContactInfo btn fw-bold btn-primary  ml-2 mr-2">
                        <i class="fas fa-address-book"></i> Contact
                    </button>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="callingDivWrapper">
    <div class="heading">
        <div class="row">
            <div class="col-md-7 text-white">
                Basic Information : /
                Process: <span class=""><b>{{$response['post']->process}}</b></span> /
                Disposition: <span class=""><b>{{hp_master($response['post']->disposition_id)}}</b></span> /

            </div>
            <div class="col-md-5 text-right">

            </div>
        </div>
    </div>


    <div class="postTableDiv mb-4">
        <table class="table postTable vm">
            <tr>
                <td>Account No</td>
                <td>{{$response['post']->account_no}}</td>
                <td>Customer Id</td>
                <td>{{$response['post']->customer_id}}</td>
                <td>Customer Name</td>
                <td>{{$response['post']->customer_name}}</td>
            </tr>
            <tr>
                <td>Product</td>
                <td>{{$response['post']->product}}</td>
                <td>CY Date</td>
                <td>{{$response['post']->cy_date}}</td>
                <td>Risk</td>
                <td>{{$response['post']->risk}}</td>
            </tr>
            <tr>
                <td>Total Outstanding</td>
                <td>{{$response['post']->total_outstanding}}</td>
                <td>NM</td>
                <td>{{$response['post']->nm}}</td>
                <td>RB</td>
                <td>{{$response['post']->rm}}</td>
            </tr>
            <tr>
                <td>Stab</td>
                <td>{{$response['post']->stab}}</td>
                <td>Disposition</td>
                <td>{{hp_master($response['post']->disposition_id)}}</td>
            </tr>
            <tr>
                <td>Residential Address</td>
                <td>{{$response['post']->residance_address}}</td>
                <td>Pin Code</td>
                <td>{{$response['post']->residance_pin_no}}</td>
                <td> Cont No:</td>
                <td>{{$response['post']->residence_cont_no}}</td>
            </tr>
            <tr>
                <td>Office Address</td>
                <td>{{$response['post']->office_address}}</td>
                <td>Pin Code</td>
                <td>{{$response['post']->office_pin_code}}</td>
                <td> Cont No:</td>
                <td>{{$response['post']->office_cont_no}}</td>
            </tr>
            <tr>
                <td>FE Name</td>
                <td>{{$response['post']->fe_name}}</td>
                <td>TL Name</td>
                <td>{{$response['post']->tl_name}}</td>
                <td> Zone:</td>
                <td>{{$response['post']->zone}}</td>
            </tr>
        </table>
    </div>
</div>
<div class="postDetailsMoreInfo mb-4">
    @if (count($response['post_contact'])>0)
    <div class="addContactInfo mb-3">
        <div class="heading">Additional Contact Information</div>
        <table class="table table-bordered vm">
            <thead>
                <tr>
                    <td>Phone Number</td>
                    <td>Address</td>
                    <td class="text-center">Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($response['post_contact'] as $item)
                <tr>
                    <td class="fw-bold">{{$item->phone}}</td>
                    <td>{{$item->address}}</td>
                    <td class="text-center w150"><button type="button"
                            class="callbtn_off_add addToCall btn btn-sm fw-bold btn-success"
                            data-phone="{{$item->phone}}">Select to Call</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <div class="heading">More Information</div>
    @if ($response['post']->post_meta && count($response['post']->post_meta)>0)
    <table class="table postMetaTable vm ">
        <tr>
            @foreach ($response['post']->post_meta as $key=>$value)
            <td>{{ $key}}</td>
            <td>{{$value}}</td>
            @if (($loop->index+1)%3==0)
        </tr>
        @endif
        @endforeach
    </table>
    @else
    <div class="noData">No more information found!</div>
    @endif

</div>

<!-- Modals -->
@include('modals.call_feedback_modal')
@include('modals.add_new_contact_info')
<?php /*?>
@include('modals.start_calling')
<?php */?>

@endsection

@section('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.6.5/timer.jquery.min.js'></script>
<script>
    $( document ).on('click','.addFeedback',function() {
        var modalId=$("#callFeedbackModal");
        modalId.find('#callSource').val('manual');   
        modalId.find('#phoneNumber').val('');   
        modalId.modal({
            show:true,
            backdrop: 'static',
            keyboard: false
        })
    });
    $(document).on('click','.callbtn',function(){
        //start time
        $('.timer').show();
        $('.timer').timer({
            format: '%H:%M:%S'
        });
        $('.timer').timer('start');
        // 
        $(this).html('Calling...');
        $('.callbtn').attr('disabled','disabled');
        // connected
        setTimeout(function() {   
            $('.callbtn').html('Connected');
            $('.callbtn').removeClass('callbtn');
            $('.pausebtn').removeAttr('disabled','disabled');
            $('.stopbtn').removeAttr('disabled','disabled');
        }, 1000);
    });
    $(document).on('click','.pausebtn',function(){
        $('.timer').timer('pause');
        $('.pausebtn').attr('disabled','disabled');
        $('.playbtn').removeAttr('disabled','disabled');
    });
    $(document).on('click','.playbtn',function(){
        $('.timer').timer('resume');
        $('.pausebtn').removeAttr('disabled','disabled');
        $('.playbtn').attr('disabled','disabled');
    });
    $(document).on('click','.stopbtn',function(){
        $('.timer').timer('pause');
        var modalId=$("#callFeedbackModal");
        modalId.find('#callSource').val('automatic');   
        modalId.find('#phoneNumber').val($('.calling_number_input').val());     
        modalId.modal({
            show:true,
            backdrop: 'static',
            keyboard: false
        })      
    });

    $(document).on('click','.addNewContactInfo',function(){
        var modalId=$("#addNewContactInfoModal");
        modalId.modal({
            show:true,
            backdrop: 'static',
            keyboard: false
        })      
    });

    $(document).on('click','.addToCall',function(){
        $('.calling_number_input').val($(this).attr('data-phone'));
    });
  
    $(document).on('click','.callbtn_off',function(){
        var calling_number_input=$('#calling_number_input').val();
        if(calling_number_input=="" || calling_number_input<10){
            alert('Please enter correct contact number!');
            $('#calling_number_input').focus();
        }
        if(calling_number_input.length>=10){
            umobility(calling_number_input);
        }
    });

    $(document).on('click','.callbtn_off_add',function(){
        var calling_number_input=$(this).attr('data-phone');
        if(calling_number_input.length>=10){
            umobility(calling_number_input);
        }
    });

    function umobility(number){
        window.location.href="umobility://"+number;
    }

</script>
@endsection