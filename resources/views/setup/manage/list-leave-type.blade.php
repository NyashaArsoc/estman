@php $title = 'Leave Type';
$description = 'list of all leave types...';

@endphp
@extends('layout.setup-main-menu')
@section('title', 'Type')
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
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($group as $abc)
                    <tr>
                        @php
                        $id= Crypt::encrypt($abc->id);
                        @endphp
                        <td>{{$count ++}}</td>
                        <td>{{$abc->description}}</td>
                        <td>@if (in_array(2,$arraycontrolids)) <a class="btn btn-primary btn-sm " id=""
                                href="{{route('setman.viewtype', $id)}}"
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
            @include('layout.arlet')
        </div>
    </div>
</div>
<!-- Content End-->
@endsection