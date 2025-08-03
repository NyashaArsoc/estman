@php
$title = 'Edit Client';
$description = 'below are client details .';
$id= Crypt::encrypt($client->id);
$divindividualclass = $client->clienttypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $client->clienttypeid != 1 ? 'hide': 'dropdwn';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Edit Client')
@section('additional css')
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.val') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('valman.listclient') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$client->description ?? '' }}</span>
        <hr />
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="client-detail-tab" data-toggle="tab" href="#client-detail" role="tab" aria-controls="client-detail" aria-selected="true">Client Details</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="client-contact-tab"
                    data-toggle="tab" href="#client-contact" role="tab" aria-controls="client-contact" \
                    aria-selected="true">Contact Person</a> </li>
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="client-detail" role="tabpanel" aria-labelledby="client-detail-tab">
                <br />
                <form class="form-material material-primary" method="POST" id="defaultform"
                    action="{{ route('valman.updtclient', $id) }}">@csrf
                    <br />
                    <div id="individualgroup" class="{{$divindividualclass}}">
                        <div class="form-group row">
                            <label for="FirstName" class="col-sm-2 form-control-label">First Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    value="{{ $client->firstname ?? ''}}" autocomplete="off">
                                <small id="firstnamecheck" style="color: red;">required</small>
                            </div>
                            <label for="LastName" class="col-sm-2 form-control-label">Last Name
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    value="{{ $client->lastname ?? ''}}" autocomplete="off">
                                <small id="lastnamecheck" style="color: red;">required</small>
                            </div>
                        </div>
                    </div>
                    <div id="corporategroup" class="{{$divcompanyclass}}">
                        <div class="form-group row">
                            <label for="CompanyName" class="col-sm-2 form-control-label">Company Name</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companyname" name="companyname"
                                    value="{{ $client->companyname ?? ''}}" autocomplete="off">
                                <small id="companynamecheck" style="color: red;">required</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Cell" class="col-sm-2 col-form-label">Cell
                        </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cell" name="cell"
                                value="{{ $client->cell ?? ''}}" autocomplete="off">
                            <small id="cellcheck" style="color: red;">required</small>
                        </div>
                        <label for="Tel" class="col-sm-2 col-form-label">Tel</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="Tel" name="tel"
                                value="{{ $client->tel ?? ''}}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ContactAddress" class="col-sm-2 col-form-label">Contact Address</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="billingaddress" name="billingaddress"
                                value="{{ $client->contactddress ?? ''}}">
                        </div>
                        <label for="Email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ $client->email ?? ''}}" autocomplete="off">
                            <small id="emailcheck" style="color: red;">required</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        @if (in_array(2,$arraycontrolids))
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-edit-client">submit</button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="tab-pane show" id="client-contact" role="tabpanel" aria-labelledby="client-contact-tab">
                <h5 class="mt-2">Contact</h5>
                @if (in_array(1,$arraycontrolids))
                <a class="btn btn-primary btn-sm" href="{{route('valin.newclient', $id)}}
                " title="add">create new</a>
                @endif
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>FullName</th>
                            <th>Cell</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Option </th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($contact as $abc)
                        <tr>
                            @php
                            $contactid = Crypt::encrypt($abc->id);
                            if(trim($abc->isavailable)=='Y'){
                            $status = 'available';
                            $badge = 'badge badge-pill bg-success badge-secondary';
                            }else{
                            $status = 'inactive';
                            $badge = 'badge badge-pill bg-danger badge-secondary';
                            }
                            @endphp
                            <td>{{$count ++}}</td>
                            <td>{{$abc->firstname }} {{$abc->lastname }}</td>
                            <td>{{$abc->cell}} </td>
                            <td>{{$abc->email}} </td>
                            <td><span class="{{ $badge }}">{{ $status }}</span></td>
                            <td><a class="btn btn-secondary btn-sm" href="{{route('valman.editaddclient',[$id,$contactid])}}"
                                    title="edit"><i class="ti-pencil mr-0-5"></i>edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><br />
    @include('layout.arlet')
</div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<!-- Additional JS End-->
<script src="{{ asset('js/validation/intakevaluation.js') }}"></script>
@endsection