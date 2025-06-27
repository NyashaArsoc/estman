@php $title = 'Leave Days';
$description = 'list of all staff...'; @endphp
@extends('layout.hc.hc-main-menu')
@section('title', 'Add Days')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{$title}}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.hc')}}">Dashboard</a></li>
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
                        <th>Name</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($staff as $abc)
                    <tr>
                        @php
                        $id= Crypt::encrypt($abc->id);
                        @endphp
                        <td>{{$count ++}}</td>
                        <td>{{ $abc->lastname }} {{ $abc->firstname}}</td>
                        <td>
                            <a class="btn btn-info btn-sm " id=""
                                href="{{route('hcin.lstgrpusr',$id)}}"
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