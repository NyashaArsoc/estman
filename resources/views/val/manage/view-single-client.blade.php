@php
$title = 'View Client Details';
$description = 'Below are the details of the client.';
if ($client->clienttypeid == 1){
$fullname   =  $client->firstname.' '.$client->lastname ;
  }else{
  $fullname   =  $client->companyname; }
@endphp
@extends('layout.no-menu-layout')
@section('title', 'View Client Details')
@section('additional css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
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

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="client-info-tab" data-toggle="tab" href="#client-info" role="tab" aria-controls="client-info" aria-selected="true">Client Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-person-info-tab" data-toggle="tab" href="#contact-person-info" role="tab" aria-controls="contact-person-info" aria-selected="false">Contact Person</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="client-info" role="tabpanel" aria-labelledby="client-info-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{$fullname ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Contact Cell:</strong></td>
                            <td>{{$client->cell ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Tel:</strong></td>
                            <td>{{$client->tel ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{$client->email ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Address:</strong></td>
                            <td>{{$client->contactddress ?? ''}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="contact-person-info" role="tabpanel" aria-labelledby="contact-person-info-tab">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>FullName</th>
                            <th>Cell</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($contact as $abc)
                        <tr>
                            @php
                            $id = Crypt::encrypt($abc->id);
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- Content End -->
@endsection
