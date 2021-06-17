@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>	
    <p><?= $message; ?></p>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>	
    <p><?= $message; ?></p>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>	
    <p><?= $message; ?></p>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>	
    <p><?= $message; ?></p>
</div>
@endif

@if ($message = Session::get('danger'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>	
    <p><?= $message; ?></p>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
    <ul class="list-group list-group-flush">
        @foreach ($errors->all(':message') as $value)
        <p><?= $value ?></p>
        @endforeach
    </ul>
</div>
@endif