@php
$title = 'All Reports stages';
$description = 'Report stages...';
@endphp
@extends('layout.valuation-main-menu')
@section('title', 'Reports')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{$title}}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
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
                        <th>Client</th>
                        <th>Valuer</th>
                        <th>Created On</th>
                        <th>Street Address</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($stage as $abc)
                    <tr>
                        @php
                        $status = trim($abc->current_stage)=='Completed' ?
                        'bg-success': 'bg-warning';
                        @endphp
                        <td>{{$count ++}}</td>
                        <td>{{$abc->companyname ?? ''}} {{$abc->lastname ?? ''}}{{$abc->firstname ?? ''}}</td>
                        <td>{{$abc->allocatedto}}</td>
                        <td>{{$abc->datestamp}}</td>
                        <td>{{$abc->streetaddress}}</td>
                        <td><span class="badge badge-pill {{ $status }}">{{$abc->current_stage}}</span> </td>
                        @php $id= Crypt::encrypt($abc->id); @endphp
                        <td><a class="btn btn-info btn-sm " id=""
                                href="{{route('valman.viewinstrstage',$id)}}"
                                title="view"><i class="ti-eye mr-0-5"></i>view</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Client</th>
                        <th>Valuer</th>
                        <th>Created On</th>
                        <th>Street Address</th>
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