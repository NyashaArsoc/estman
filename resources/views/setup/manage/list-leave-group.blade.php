@php $title = 'Leave Groups';
$description = 'list of all leave groups...';

@endphp
@extends('layout.setup-main-menu')
@section('title', 'Groups')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{$title}}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.setup')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{$title}}</h5>
        <p class="font-90 text-muted mb-1"> {{$description}}</p>
        <div class="table-responsive">
            <hr />
            <table class="datatable table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($group as $abc)
                    <tr>
                        @php
                        $id= Crypt::encrypt($abc->id);
                        if (trim($abc->isactive) == 'Y'){
                        $status = 'active';
                        $badge = "badge badge-pill bg-success badge-secondary";
                        $buttondisable = '<a onclick="deactivaterecord(this); return false;" class="btn btn-warning btn-sm"
                            href="' . route('setman.disablelevgrp',$id) . '" title="disable"><i class="ti-check mr-0-5">
                            </i>disable</a>';
                        $buttonactivate = '';
                        }else{
                        $status = 'blocked';
                        $badge = "badge badge-pill bg-danger badge-secondary";
                        $buttondisable = '';
                        $buttonactivate = '<a onclick="activaterecord(this); return false;" class="btn btn-success btn-sm"
                            href="' . route('setman.activlevgrp',$id) . '" title="activate"><i class="ti-check mr-0-5">
                            </i>activate</a>';
                        }
                        @endphp
                        <td>{{$count ++}}</td>
                        <td>{{$abc->description}}</td>
                        <td><span class="{{ $badge }}">{{$status}}</span></td>
                        <td>@if (in_array(2,$arraycontrolids)) <a class="btn btn-primary btn-sm " id=""
                                href="{{route('setman.typperlevgrp', $id)}}"
                                title="assign"><i class="ti-settings mr-0-5"></i>config</a>@endif
                            @if (in_array(2,$arraycontrolids)) <a class="btn btn-secondary btn-sm " id=""
                                href="{{route('setman.viewassignlevtyp', $id)}}"
                                title="assign"><i class="ti-layout-grid2 mr-0-5"></i>type</a>@endif
                            @if (in_array(7,$arraycontrolids)){!! $buttondisable !!}@endif
                            @if (in_array(8,$arraycontrolids)){!! $buttonactivate !!}@endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </tfoot>
            </table>
            @include('layout.arlet')
        </div>
    </div>
</div>
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
<!-- Additional JS End-->
@endsection