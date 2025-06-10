@php
$title = 'Declined Instructions';
$description = 'declined instructions on acknowledgement ...';
@endphp
@extends('layout.valuation-main-menu')
@section('title', 'Acknowledgement Declined')
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
                        <th>Contact</th>
                        <th>Property Type</th>
                        <th>Address</th>
                        <th>Valuer</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($acknow as $abc)
                    <tr>

                        <td>{{$count ++}}</td>
                        <td>{{$abc->companyname ?? ''}} {{$abc->clientfullname ?? ''}}</td>
                        <td>{{$abc->contactname}}</td>
                        <td>{{$abc->propertytype}}</td>
                        <td>{{$abc->streetaddress}}</td>
                        <td> {{ $abc->completedby }} </td>
                        @php $id= Crypt::encrypt($abc->id);$to_id= Crypt::encrypt($abc->allocatedto);
                        $instr_id= Crypt::encrypt($abc->instructionid); @endphp
                        <td><a class="btn btn-info btn-sm " id=""
                                href="{{route('valdec.viewsinglackwn',[$id,$instr_id])}}"
                                title="view"><i class="ti-eye mr-0-5"></i>view</a>
                            <!-- <a class="btn btn-warning btn-sm " onclick="confirminstruction(this); return false;"
                                href="{{route('valapp.confirmacknow',[$id,$instr_id,$to_id])}}"
                                title="archive"><i class="ti-files mr-0-5"></i>archive</a> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Client</th>
                        <th>Contact</th>
                        <th>Property Type</th>
                        <th>Address</th>
                        <th>Valuer</th>
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