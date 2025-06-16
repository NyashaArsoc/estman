@php
$title = 'Leave Group';
$description = 'below are group details .';
$groupid= Crypt::encrypt($group->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'View Leave Group')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.setup') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setman.listlevgrp') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$group->description ?? '' }}</span>
        <hr />
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="config-detail-tab" data-toggle="tab" href="#config-detail" role="tab" aria-controls="config-detail" aria-selected="true">Config Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="work-days-tab" data-toggle="tab" href="#work-days" role="tab" aria-controls="work-days" aria-selected="true">Working Days</a>
            </li>
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="config-detail" role="tabpanel" aria-labelledby="config-detail-tab"><br />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Description</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($list as $abc)
                        <tr>
                            @php $tid= Crypt::encrypt($abc->typeid);$gid= Crypt::encrypt($abc->groupid); @endphp
                            <td>{{$count ++}}</td>
                            <td>{{$abc->description}}</td>
                            <td>@if (in_array(2,$arraycontrolids)) <a class="btn btn-primary btn-sm " id=""
                                    href="{{route('setman.typlevgrpconf', [$tid,$gid])}}"
                                    title="assign"><i class="ti-settings mr-0-5"></i>config</a>@endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Description</th>
                            <th>Option</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="tab-pane show" id="work-days" role="tabpanel" aria-labelledby="days-days-tab"><br />
                <h5 class="mt-2">Select Working Days</h5>
                <hr />
                <div class="form-group row">
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="mon" name="days" value="Mon">
                            <label class="form-check-label" for="mon">Mon</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="tue" name="days" value="Tue">
                            <label class="form-check-label" for="tue">Tue</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="wed" name="days" value="Wed">
                            <label class="form-check-label" for="wed">Wed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="thu" name="days" value="Thu">
                            <label class="form-check-label" for="thu">Thu</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="fri" name="days" value="Fri">
                            <label class="form-check-label" for="fri">Fri</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="sat" name="days" value="Sat">
                            <label class="form-check-label" for="sat">Sat</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="sun" name="days" value="Sun">
                            <label class="form-check-label" for="sun">Sun</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="hol" name="days" value="Hol">
                            <label class="form-check-label" for="hol">Holiday</label>
                        </div>
                    </div>
                </div>
                @if (in_array(1,$arraycontrolids)) <button type="submit" class="btn btn-primary"
                    id="btn-sbt-work-days">submit</button> @endif
            </div>
        </div><br />
        @include('layout.arlet')
    </div>
</div>
<!-- Content End-->

@endsection