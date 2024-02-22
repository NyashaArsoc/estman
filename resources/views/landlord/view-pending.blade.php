@php 
$title = 'Pending Landlord';
$description = 'approve/reject landlord...'; 
if ($landlord->clienttypeid == 1){
                                $owner   =  $landlord->fullname ;
                                $registration   =  $landlord->nationalID ;
                                $divclass   =   'dropdwn';
                             }else{
                                 $owner   =  $landlord->companyname ;
                                 $registration   =  $landlord->companynumber ;
                                 $divclass   =   'show';
                             } 
                             $id= Crypt::encrypt($landlord->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Pending Landlord')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('landlord.pending')}}">Pending</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="addlandlord" method="PUT"
                action="{{route('landlord.reject', $id)}}">@csrf
                <div class="form-group row">
                    <label for="ClientType" class="col-sm-2 form-control-label">Type</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $landlord->description }}" readonly>
                    </div>
                </div>
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label"> Name </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $owner }}" readonly>
                        </div>
                        <label for="LastName" class="col-sm-2 form-control-label">Registration
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $registration }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="VATNumber" class="col-sm-2 form-control-label">VAT Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $landlord->vatnumber }}" 
                           readonly>
                        </div>

                        <label for="BPNumber" class="col-sm-2 form-control-label">BP Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $landlord->bpnumber }}" 
                            readonly>
                        </div>
                    </div>
                <div class="form-group row">
                    <label for="Cell" class="col-sm-2 col-form-label">Cell
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $landlord->cell }}" 
                        readonly>
                    </div>
                    <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $landlord->tel }}"
                         readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                    <div class="col-sm-4">
                        <textarea type="text" class="form-control" rows="2" cols="3" 
                        readonly>{{ $landlord->contactaddress }}</textarea>
                    </div>
                    <label for="Email" class="col-sm-2 col-form-label">Email
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $landlord->email }}" 
                        readonly>
                    </div>
                </div>
                <div id="CorporateGroupContact" class="{{$divclass}}">
                    <br />
                    <h5>company contact person </h5>
                    <div class="form-group row">
                        <label for="FirstName" class="col-sm-2 form-control-label">First Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" value="{{ $contact->firstname ?? ''}}">
                        </div>

                        <label for="LastName" class="col-sm-2 form-control-label">Last Name
                        </label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" value="{{ $contact->lastname ?? ''}}" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                        </label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" value="{{ $contact->cell ?? ''}}" 
                            >
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email
                        </label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" value="{{ $contact->email ?? ''}}"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Email" class="col-sm-2 col-form-label">Reason for decline
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="ReasonsForDecline" 
                        id="ReasonsForDecline" />
                        <small id="reasonscheck" style="color: red;"> reasons for rejection</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-4">
                        <a onclick = "approvelandlord(this); return false;"
                        class="btn btn-success btn-sm" href="{{route('landlord.approve', $id)}}"
                        title="approve"><i class="ti-check mr-0-5"></i>approve</a>  
                        <button type="submit" class="btn btn-danger btn-sm" id="reject-landlord" 
                        onclick = "rejectlandlord(this); return false;"><i class="ti-close mr-0-5">
                            </i>reject</button>
                    </div>
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/landlord.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
