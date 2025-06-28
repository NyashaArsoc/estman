@php $title = 'Leave Type';
$uid= Crypt::encrypt($staff->id);
$description = 'list of all leave types staff has...';@endphp
@extends('layout.no-menu-layout')
@section('title', 'Add Days')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{$title}}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.hc')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hcin.addday') }}">List</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{$title}}</h5>
        <p class="font-90 text-muted mb-1"> {{$description}}</p>
        <span class="badge badge-pill bg-primary">{{ $staff->lastname }} {{ $staff->firstname}} : {{ $staffgroup->description}}</span>
        <div class="table-responsive">
            <hr />
            <table class="datatable table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($typegroup as $abc)
                    <tr>
                        @php
                        $id= Crypt::encrypt($abc->id);
                        @endphp
                        <td>{{$count ++}}</td>
                        <td>{{ $abc->description }}</td>
                        <td>
                            <a class="btn btn-info btn-sm " id=""
                                href="{{route('hcin.daytotyp',[$id,$uid])}}"
                                title="view"><i class="ti-eye mr-0-5"></i>view</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
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