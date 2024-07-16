@php
$title = 'Add Property';
$description = 'add property to the system...';
@endphp
@extends('layout.val-main-menu')
@section('title', 'Add Property')
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
                    <label for="" class="col-sm-2 form-control-label">Client Type </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="clienttype"
                            id="clienttype" />
                        <option value="">Select Client Type</option>
                        @foreach ($type as $typ)
                            <option value="{{ $typ->id }}"> {{ $typ->description }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <label for="City" class="col-sm-2 col-form-label">Client Name </label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="propertyclientname" id="propertyclientname" />
                        <option value="">Select Client Name</option>
                        <option value=""> </option>
                        </select>
                    </div>
                    <small id="propertyclientnamecheck" style="color: red;"> select client name </small>
                </div><br />
                <h5>Property Details  </h5>
                    <div class="table-responsive" style="margin-top: 15px;">
						<table class="table table-bordered table-hover" id="tblnewpropertydetails">
							<thead>
								<tr>
								<th class="text-center">No</th>
								<th class="text-center">Type</th>
								<th class="text-center">Province</th>
								<th class="text-center">Town</th>
								<th class="text-center">Surbub</th>
								<th class="text-center"> Street   Address</th>
								<th class="text-center">Option</th>
								</tr>
							</thead>
							<tbody id="addBankItem">
								<tr>
								<td></td><td>
									<select class="js-example-basic-single w-100" name="propertytype"
								id="propertytype"  tabindex="1"/>
                                <option value="">Type</option>
                                @foreach($type as $abc)
                                <option value="{{ $abc->id }}">  {{ $abc->description }}
                                </option>@endforeach
                                </select>
                                <small id="propertytypecheck" style="color: red;">required</small>
                                    </td>
                                    <td>
                                        <select class="js-example-basic-single w-100" name="propertyprovince"
                                        id="propertyprovince" />
                                        <option value="">Province </option>
                                        @foreach($type as $abc)
                                        <option value="{{ $abc->id }}">  {{ $abc->description }}
                                        </option>@endforeach
                                        </select>
                                        <small id="propertyprovincecheck" style="color: red;">required</small>
                                    </td>
                                    <td>
                                        <select class="js-example-basic-single w-100" name="propertytown"
                                        id="propertytown"/>
                                        <option value="">Town </option>
                                        @foreach($type as $abc)
                                        <option value="{{ $abc->id }}">  {{ $abc->description }}
                                        </option>@endforeach
                                        </select>
                                        <small id="propertytowncheck" style="color: red;">required</small>
                                    </td>
                                    <td>
                                        <select class="js-example-basic-single w-100" name="propertysurbub"
                                        id="propertysurbub"/>
                                        <option value="">Surbub </option>
                                        @foreach($type as $abc)
                                        <option value="{{ $abc->id }}">  {{ $abc->description }}
                                        </option>@endforeach
                                        </select>
                                        <small id="propertysurbubcheck" style="color: red;">required </small>
                                    </td>   
                                    <td>
                                        <textarea type="text" class="form-control" 
                                        name="propertyaddress" rows="2" cols="4" id="propertyaddress"></textarea>
                                            <small id="propertyaddresscheck" style="color: red;"> required</small>
                                    </td>                                       
									<td align="center" colspan="2">
									<input id="add-new-property" class="btn btn-info" name="submit-new-property" 
									 value="Save" tabindex="6" type="button">
                                    </td>
								</tr>
							</tbody>
							<tfoot>
		
							</tfoot>
						</table>
					</div><br />
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-val-new-property" >
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
