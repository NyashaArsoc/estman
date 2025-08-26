@php
$title = 'Instruction Journey';
$description = 'instruction stages completed and pending...';
$instr_id= Crypt::encrypt($instr->id);
$attachementdoc = ($upload !== null && !is_null($upload->reportdoc)) ? 'download report' : '';
$attachementexcel = ($upload !== null && !is_null($upload->reportexcel)) ? 'download schedule' : '';
$reportdoc = ($upload !== null && !is_null($upload->reportdoc)) ? route('valapp.downdoc',[$instr_id]) : '';
$reportexc = ($upload !== null && !is_null($upload->reportexcel)) ? route('valapp.downexc',[$instr_id]) : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', $title)
@section('additional css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/journey.css') }}" />
@endsection

@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('valman.listinstr') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="vettingTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="client-info-tab" data-toggle="tab" href="#client-info" role="tab" aria-controls="client-info" aria-selected="true">Client Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="order-journey-tab" data-toggle="tab" href="#order-journey" role="tab" aria-controls="order-journey" aria-selected="false">Instruction Journey</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="vettingTabContent">
            <!-- Client Information -->
            <div class="tab-pane fade" id="client-info" role="tabpanel" aria-labelledby="client-info-tab">
                <h5 class="mt-2">Client Details</h5>
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Full Name:</strong></td>
                            <td>{{$client->companyname ?? ''}} {{$client->lastname ?? ''}}
                                {{$client->firstname ?? ''}}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Person:</strong></td>
                            <td>{{$client->contactfirstname ?? ''}} {{$client->contactlastname ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{$client->email ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Cell:</strong></td>
                            <td>{{$client->cell ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{$client->email ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Order Information -->
            <div class="tab-pane show active" id="order-journey" role="tabpanel" aria-labelledby="order-journey-tab">
                <h5 class="mt-2">Instruction Journey</h5>
                <ul class="timeline">
                    @foreach($instruction as $abc => $data)
                    @if($data->status !== null)
                    <li class="timeline-item">
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">
                                    {{ $data->stage }}

                                    @if(trim($data->status) === 'C')
                                    <span class="badge badge-pill bg-success">Completed</span>
                                    @elseif(trim($data->status) <> 'C')
                                        <span class="badge badge-pill bg-warning">In Progress</span>
                                        @endif
                                </h4>
                                <p>
                                    <small class="text-muted">
                                        {{ $data->completedon ? \Carbon\Carbon::parse($data->completedon)->format('d M Y H:i') : '' }}
                                    </small>
                                </p>
                            </div>
                            <div class="timeline-body">
                                <p>
                                    @if($data->completedby)
                                    Actioned by: <strong>{{ $data->completedby }}</strong>
                                    @else
                                    Not yet actioned
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
                <div class="row mb-3">
                    <hr />
                    <div class="col-md-6">
                        <h5><a href="{{ $reportdoc }}">{{ $attachementdoc}}</a></h5>
                        <h5><a href="{{ $reportexc }}">{{ $attachementexcel}}</a></h5>
                    </div>
                </div>
            </div>

            @include('layout.arlet')
        </div>
    </div>
</div>
<!-- Content End-->
@endsection

@section('additional js')
<script src="{{ asset('js/validation/intake.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
@endsection