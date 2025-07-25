@php
$title = 'Dashboard';
@endphp
@extends('layout.hc-main-menu')
@section('title', 'Human Capital Dashboard')
@section('additional css')


<!-- Font Awesome 4.7 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
<style>
    .card-icon {
        font-size: 1.8rem;
        opacity: 0.7;
    }
</style>
@section('content')
<!-- Main Content -->
<div class="container">
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-block text-white bg-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Total Leave Applied</h6>
                        <h3>{{$totalapplication}}</h3>
                    </div>
                    <i class="fa fa-calendar card-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-block text-white bg-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Approved</h6>
                        <h3>{{$approvedapplication}}</h3>
                    </div>
                    <i class="fa fa-check card-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-block text-white bg-danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Rejected</h6>
                        <h3>{{$rejectedapplication}}</h3>
                    </div>
                    <i class="fa fa-times card-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart and Table -->
    <div class="row">
        <!-- Table -->
        <div class="col-md-6 mb-4">
            <div class="card card-block p-3">
                <h5 class="mb-3">Recent Leave Applications</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-default">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Days</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            @foreach($application as $abc)
                            <tr>@php
                                if (trim($abc->status) == 'P' || trim($abc->status) == 'C'){
                                $status = 'pending';$badge = "badge badge-pill bg-info badge-secondary";
                                }else if(trim($abc->status) == 'D'){
                                $status = 'declined';$badge = "badge badge-pill bg-danger badge-secondary";
                                }else if(trim($abc->status) == 'A'){
                                $status = 'approved';$badge = "badge badge-pill bg-success badge-secondary";
                                }
                                @endphp
                                <td>{{$count ++}}</td>
                                <td>{{ $myuser->lastname}} {{ $myuser->firstname}}</td>
                                <td>{{ $abc->description}}</td>
                                <td>{{ (int)$abc->daysapplied}}</td>
                                <td><span class="{{ $badge }}">{{$status}}</span></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
@yield ('additional js')