@php
$title = 'View Property';
$description = 'below are property details .';
$id= Crypt::encrypt($property->id);
$mandate= Crypt::encrypt($property->mandate);
$otherattachement= Crypt::encrypt($property->otherattachement);
if ($property->propertytypeid == 1){
    $divclasscompany      =   'dropdwn';
    $divclassindividual   =   'show';
 }else{
    $divclasscompany   =   'show';
    $divclassindividual   =   'dropdwn';
 }
 $attachementrequiredpdf = (!is_null($property->mandate)) ? 'download file' : '';
$attachementnotrequired = (!is_null($property->otherattachement)) ? 'download file' : '';
$requiredpdf    = (!is_null($property->mandate)) ? route('propapp.dwnmandpdf',[$mandate]) : '';
$notrequiredpdf = (!is_null($property->otherattachement)) ? route('propapp.dwnothrpdf',[$otherattachement]) : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'View')
@section('additional css')
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propapp.listten') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$property->propertytype ?? '' }}</span><hr/>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="property-detail-tab" data-toggle="tab" href="#property-detail" role="tab" aria-controls="property-detail" aria-selected="true">Property Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="additional-info-tab" data-toggle="tab" href="#additional-info" role="tab" aria-controls="additional-info" aria-selected="true">Additional Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="lease-info-tab" data-toggle="tab" href="#lease-info" role="tab" aria-controls="lease-info" aria-selected="true">Lease Information</a>
            </li>
        </ul>
        <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('propapp.propapp', $id)}}">@csrf
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="property-detail" role="tabpanel" aria-labelledby="property-detail-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $property->fullname ?? ''}}  {{ $property->companyname ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Province:</strong></td>
                            <td>{{ $property->province ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>City/Town:</strong></td>
                            <td> {{ $property->city ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Location/Surburb:</strong></td>
                            <td> {{ $property->location ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Street Address:</strong></td>
                            <td>{{ $property->streetaddress ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Stand Number:</strong></td>
                            <td>{{ $property->standnumber ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Highlights:</strong></td>
                            <td>{{ $property->comments ?? ''}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                    <div id="residential" class="{{$divclassindividual}}">
                        <tr>
                            <td><strong>Rooms:</strong></td>
                            <td>{{ $property->rooms ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Bedrooms:</strong></td>
                            <td>{{ $property->bedrooms ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Bathrooms:</strong></td>
                            <td>{{ $property->bathrooms ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Stories:</strong></td>
                            <td>{{ $property->stories ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Expected Rental:</strong></td>
                            <td>{{ $property->currencycode ?? ''}} {{ number_format($property->expectedrental,2) ?? ''}} </td>
                        </tr>
                    </div>
                        <div id="commercial" class="{{$divclasscompany}}">
                        <tr>
                            <td><strong>Total Area (Sqm):</strong></td>
                            <td>{{ $property->totalarea ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Lettable Area (Sqm):</strong></td>
                            <td>{{ $property->lettablearea ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Expected Rate:</strong></td>
                            <td>{{ $property->currencycode ?? ''}} {{ $property->ratesqm ?? ''}} </td>
                        </tr>
                        </div>
                        <tr>
                            <td><strong>Commission Type:</strong></td>
                            <td>{{ $property->commissiontype ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Commission %:</strong></td>
                            <td>{{ $property->commission ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Mandate document:</strong></td>
                            <td><a href="{{ $requiredpdf }}">{{ $attachementrequiredpdf}}</a> </td>
                        </tr>
                        <tr>
                            <td><strong>Other Attachments:</strong></td>
                            <td><a href="{{ $notrequiredpdf }}">{{ $attachementnotrequired}}</a> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="lease-info" role="tabpanel" aria-labelledby="lease-info-tab">
                <h5 class="mt-2">Lease</h5><hr/>
                <table  class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No </th> <th>Name</th> <th>From</th><th>To</th><th>Rental</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($lease as $abc)
                        <tr>
                           @php
                               if (trim($abc->available) == 'Y'){
                                    $status = 'available';
                                    $badge = "badge badge-pill bg-success badge-secondary";
                                }else if (trim($abc->available) == 'D'){//include the deleted status
                                    $status = 'deleted';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }else{
                                if (trim($abc->approval) == 'R'){ 
                                    $status = 'rejected';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }else{
                                    $status = 'inactive';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                }
                             }
                           @endphp
                            <td>{{$count ++}}</td><td>{{ $abc->tenantfullname }} {{ $abc->tenantcompanyname ?? ''}}</td>
                            <td>{{ $abc->validfrom }}</td><td>{{ $abc->validto }}</td><td>{{ $abc->currencycode }}{{ number_format($abc->rental,2) }}</td>
                            <td><span class="{{ $badge }}">{{$status}}</span></td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><br/>
        @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/approvalpropman.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
<script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
