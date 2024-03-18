@php $title = 'Lease Reports'; 
      $description = 'generating lease reports...'; @endphp
    @extends('layout.view-report-property')
    @section('title', 'Lease Reports')
    @section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
@endsection
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('report.viewlease')}}">List</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <form class="form-material material-primary" action="{{route('report.printstatement')}}" method="GET"> @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Lease</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="PropertyAddress" 
                    id="PropertyAddress"
                    />
                    <option value="">Property Decription</option>
                    {{-- <option value="all">All Properties </option> --}}
                    @foreach ($lease as $abc)
                        <option value="{{ $abc->id }}"> {{ $abc->streetaddress.' - '.$abc->propertydescription}} </option>
                        @endforeach
                    </select>
                    <small id="propertyaddresscheck" style="color: red;"> select property </small>
                </div> 
                <label for="" class="col-sm-2 form-control-label">Currency</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="RollCurrency" 
                    id="RollCurrency"
                    />
                    <option value="">Select Currency</option>
                    {{-- <option value="all">All Properties </option> --}}
                    @foreach ($code as $abc)
                        <option value="{{ $abc->code }}"> {{ $abc->code}} </option>
                        @endforeach
                    </select>
                    <small id="rollcurrencycheck" style="color: red;"> select property </small>
                </div> 
            </div><br />
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-statement-lease">
                        <i class="ti-download mr-0-5"></i>submit</button>
    
                </div>
            </div>
                </form>
            </div>
        </div>
        <!-- Content End-->
    @endsection
    @section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/report.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <!-- Additional JS End-->
    @endsection