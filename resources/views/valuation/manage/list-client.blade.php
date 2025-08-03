@php
$title = 'Clients';
$description = 'list of all clients ...';
@endphp
@extends('layout.valuation-main-menu')
@section('title', 'Clients')
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
                        <th>Description</th>
                        <th>Name</th>
                        <th>Cell</th>
                        <th>Email</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($client as $abc)
                    <tr>@php
                        if ($abc->clienttypeid == 1){
                        $fullname = $abc->firstname.' '.$abc->lastname ;
                        }else{
                        $fullname = $abc->companyname;
                        }@endphp
                        <td>{{$count ++}}</td>
                        <td>{{$abc->description}}</td>
                        <td>{{$fullname}}</td>
                        <td>{{$abc->cell}}</td>
                        <td>{{$abc->email}}</td>
                        @php $id= Crypt::encrypt($abc->id); @endphp
                        <td>@if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm 
                                        " id="" href="{{route('valman.viewclient', $id)}}"
                                title="view"><i class="ti-eye mr-0-5"></i>view</a>@endif
                            @if (in_array(2,$arraycontrolids))<a class="btn btn-secondary btn-sm 
                                        " id="" href="{{route('valman.editclient', $id)}}"
                                title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>@endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Name</th>
                        <th>Cell</th>
                        <th>Email</th>
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