@php
$title = 'Assign Type';
$description = 'assign leave type to group...';
$id= Crypt::encrypt($group->id);
$joinedgroupsis = $typegroup->implode('typeid', ',');
$arraygroupids = explode(',',$joinedgroupsis);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Assign Leave Type')
@section('additional css')
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset ('css/popupforms/add_role.css') }}" />
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.setup')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('setman.listlevgrp')}}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="" method="PUT"
            action="{{ route('setman.assigntyplevgrp',$id) }}">@csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control "
                        value="{{$group->description}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="AssignTo" class="col-sm-2 col-form-label">Assign To</label>
                <div class="col-sm-10">
                    <span class="btn btn-info btn-lg" data-toggle="modal"
                        data-target="#myModalAssignTo" class="fa fa-bars" title="Open AssignTo"></span>
                </div>
            </div>
            <!-- ........................Assign To Modal.......................... -->
            <div class="container">
                <!-- Modal -->
                <div class="modal fade" id="myModalAssignTo" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <table border="3" align="center">
                                    <tr>
                                        <th>Groups</th>
                                        <td> </td>
                                    </tr>
                                    @foreach($type as $abc)
                                    <tr>
                                        <td>{{ $abc->description}}</td>
                                        <td><input type="checkbox" name="ChangeRoleGroup[]"
                                                value="{{$abc->id}}" @if(in_array($abc->id,$arraygroupids))
                                            checked @endif > </td>
                                    </tr>
                                    @endforeach
                                </table>`
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ........................END Assign To Modal.......................... -->
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-submit-levtype">submit</button>
                </div>
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intake-setup.js') }}"></script>
<!-- Additional JS End-->
@endsection