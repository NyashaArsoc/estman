@php
$title = 'Staff Details';
$description = 'all staff details...';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Staff')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.hc') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hcman.liststff') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$staff->leavegroup}}</span>
        <hr />
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="staff-detail-tab" data-toggle="tab" href="#staff-detail" role="tab" aria-controls="staff-detail" aria-selected="true">Staff Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="leave-days-tab" data-toggle="tab" href="#leave-days" role="tab" aria-controls="leave-days" aria-selected="true">Leave Days</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="leave-application-tab" data-toggle="tab" href="#leave-application" role="tab" aria-controls="leave-application" aria-selected="true">Leave Applications</a>
            </li>
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="staff-detail" role="tabpanel" aria-labelledby="staff-detail-tab"><br />
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control " value="{{ $staff->fullname ?? ''}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Cell</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control " value="{{ $staff->cell ?? ''}}" readonly>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control " value="{{ $staff->email ?? ''}}" readonly>
                    </div>
                </div>
            </div>
            <div class="tab-pane show" id="leave-days" role="tabpanel" aria-labelledby="leave-days-tab"><br />
                <div class="table-responsive">
                    <hr />
                    <table class="datatable table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Days</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            @foreach($typegroup as $abc)
                            <tr>
                                @php
                                $id= Crypt::encrypt($abc->typegroupid);
                                @endphp
                                <td>{{$count ++}}</td>
                                <td>{{ $abc->leavetype }}</td>
                                <td>{{ $abc->daysavailable }}</td>
                                <td>
                                    <!-- <a class="btn btn-info btn-sm " id=""
                                        href=""
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Days</th>
                                <th>Option</th>
                            </tr>
                        </tfoot>
                    </table>
                    @include('layout.arlet')
                </div>
            </div>
            <div class="tab-pane show" id="leave-application" role="tabpanel" aria-labelledby="leave-application-tab"><br />
                <div class="table-responsive">
                    <hr />
                    <table class="datatable table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            @foreach($application as $abc)
                            <tr>
                                @php
                                $id= Crypt::encrypt($abc->id);
                                if (trim($abc->status) == 'A'){$status = 'approved';
                                $badge = "badge badge-pill bg-success badge-secondary";
                                }else if (trim($abc->status) == 'P'){
                                $status = 'pending';
                                $badge = 'badge badge-pill bg-warning badge-secondary';
                                }else if (trim($abc->status) == 'C'){
                                $status = 'confirmation pending';
                                $badge = 'badge badge-pill bg-warning badge-secondary';
                                }else{
                                $status = 'inactive';
                                $badge = 'badge badge-pill bg-danger badge-secondary';
                                }
                                @endphp
                                <td>{{$count ++}}</td>
                                <td>{{ $abc->description }}</td>
                                <td>{{ $abc->datefrom }}</td>
                                <td>{{ $abc->dateto }}</td>
                                <td><span class="{{ $badge }}">{{ $status }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                    @include('layout.arlet')
                </div>
            </div>
        </div><br />
        @include('layout.arlet')
    </div>
</div>
<!-- Content End-->

@endsection