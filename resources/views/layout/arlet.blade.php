{{-- Message --}}
@if (Session::has('success'))
<div class="container">
    <div class="msg msg-container">
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if (Session::has('error'))
<div class="container">
    <div class="msg msg-container">
<div class="alert alert-danger " role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
</div>
</div>
@endif