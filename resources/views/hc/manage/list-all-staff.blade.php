@php $title = 'Staff List';
$description = 'list of all staff...'; @endphp
@extends('layout.hc-main-menu')
@section('title', 'Manage Staff')
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
                        <th>Group</th>
                        <th>Cell</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>@php $count=1;@endphp
                    @foreach($staff as $abc)
                    <tr>
                        @php
                        $uid= Crypt::encrypt($abc->staffid);
                        $gid= Crypt::encrypt($abc->groupid);
                        if (trim($abc->isavailable) == 'Y'){
                        $status = 'available';
                        $badge = "badge badge-pill bg-success badge-secondary";
                        }else{
                        $status = 'inactive';
                        $badge = 'badge badge-pill bg-danger badge-secondary';
                        }
                        @endphp
                        <td>{{$count ++}}</td>
                        <td>{{ $abc->fullname  }}</td>
                        <td>{{ $abc->leavegroup  }}</td>
                        <td>{{ $abc->cell }}</td>
                        <td>{{ $abc->email }}</td>
                        <td><span class="{{ $badge }}">{{$status}}</span></td>
                        <td>
                            @if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm" href="{{route('hcman.viwstff',[$uid,$gid])}}"
                                title="view"><i class="ti-eye mr-0-5"></i>view</a> @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Group</th>
                        <th>Cell</th>
                        <th>Email</th>
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