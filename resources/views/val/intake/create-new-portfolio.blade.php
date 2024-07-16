@php
$title = 'Add Portfolio';
$description = 'create new portfolio...';
@endphp
@extends('layout.val-main-menu')
@section('title', 'Add Portfolio')
@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    <script src="{{ asset('js/dropdown-get-data.js') }}"></script>
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('property.addproperty') }}" > @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">select client type </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clienttype"
                            id="clienttype" />
                        <option value="">Client Type</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div><br/>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Client Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="propertyclientname" id="propertyclientname" />
                        <option value="">select client name </option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Contact Person </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clientcontactname" id="clientcontactname" />
                        <option value="">select contact</option>
                        <option value=""> </option>
                        </select>
                        <small id="clientcontactnamecheck" style="color: red;"> select contact name </small>
                    </div>
                </div><br />
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Valuation Type </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="valuationtype"
                            id="valuationtype" />
                        <option value="">select valuation type</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="valuationtypecheck" style="color: red;">required</small>
                    </div>
                    <label for="" class="col-sm-2 form-control-label">Valuation Purpose</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="valuationpurpose"
                            id="valuationpurpose" />
                        <option value="">select purpose</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="valuationpurposecheck" style="color: red;">required</small>
                    </div>
                </div><br/>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Payment Agreement</label>
                    <div class="col-sm-2">
                        <select class="js-example-basic-single w-100" name="valuationpaymentagreement"
                            id="valuationpaymentagreement" />
                        <option value="">payment agreement</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                        <small id="valuationpaymentagreementcheck" style="color: red;">required</small>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">No of Properties</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="totalnumberpropertyportfolio"
                     name="totalnumberpropertyportfolio" placeholder="0" autocomplete="off">
                    <small id="totalnumberpropertyportfoliocheck" style="color: red;">required</small>
                </div>
                <label for="ClientType" class="col-sm-2 form-control-label">Due Date</label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" id="portfolioduedate" name="portfolioduedate">
                        <small id="portfolioduedatecheck" style="color: red;"> date is required</small>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-val-new-portfolio" >
                                submit</button>
                        </div>
                    </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/intake.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <!-- Additional JS End-->
@endsection
