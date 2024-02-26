@php $title = 'Add Bank'; 
      $description = 'add landlord banking details to the system...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Banking Details')
    @section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
    <!-- additional Js-->
        <script src="{{ asset('js/dropdown-get-data.js') }}"></script> 
    <!-- additional js end-->
    @endsection
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <form class="form-material material-primary" method="POST"
                action="{{ route('landlord.addbank') }}">@csrf
                    <div class="form-group row">
                        <label for="ClientType" class="col-sm-2 form-control-label">Type<i class="text-danger">*</i></label>
                        <div class="col-sm-4">
                            <select class="js-example-basic-single w-100" name="BankLandlordClientType" 
                            id="BankLandlordClientType"  onChange="getLandlord();" />
                            <option value="">Select Client Type</option>
                            @foreach($type as $typ)
                            <option value="{{ $typ->id }}">  {{ $typ->description }}
                            </option>
                            @endforeach
                            </select>
                            <small id="banklandlordtypecheck" style="color: red;"> select landlord type </small>
                        </div>
                        <label for="LandlordName" class="col-sm-2 form-control-label">Landlord Name<i
                            class="text-danger">*</i></label>
                            <div class="col-sm-4">
                                <select class="js-example-basic-single w-100" name="LandlordName"
								id="LandlordName" />
                                <option value="">Select Landlord Name</option>
								<option value="">    </option>
                                </select>
                            </div> 
                    </div>
              
                    <h5>Banking Details  </h5>
                    <div class="table-responsive" style="margin-top: 15px;">
						<table class="table table-bordered table-hover" id="landlordbanking">
							<thead>
								<tr>
								<th class="text-center">No</th>
								<th class="text-center">Curreny<i class="text-danger">*</i></th>
								<th class="text-center">Account Name<i class="text-danger">*</i></th>
								<th class="text-center">Bank Name<i class="text-danger">*</i></th>
								<th class="text-center">Branch</th>
								<th class="text-center">Account Number<i class="text-danger">*</i></th>
								<th class="text-center">Option</th>
								</tr>
							</thead>
							<tbody id="addBankItem">
								<tr>
								<td></td><td>
									<select class="js-example-basic-single w-100" name="Currency"
								id="Currency"  tabindex="1" required/>
                                <option value="">Select Currency </option>
                                @foreach($currency as $abc)
								<option value="{{ $abc->code }}">  {{ $abc->code }}</option> 
                                @endforeach
                                </select>
                                <small id="currencycheck" style="color: red;"> select currency</small>
                                    </td>
                                    <td>
                                        <input name="AccountName" class="form-control" id="AccountName" value=""
                                            tabindex="2" type="text">
                                            <small id="accountnamecheck" style="color: red;"></small>
                                    </td>
                                    <td>
                                        <input name="BankName" class="form-control" id="BankName" value=""
                                            tabindex="3" type="text">
                                            <small id="banknamecheck" style="color: red;"></small>
                                    </td>
                                    <td>
                                        <input name="Branch" class="form-control " id="Branch" value=""
                                            tabindex="4" type="text">
                                    </td>
                                    <td>
                                        <input name="AccountNumber" class="form-control " id="AccountNumber" value=""
                                            tabindex="5" type="text">
                                            <small id="accountnumbercheck" style="color: red;"></small>
                                    </td>                                         
									<td align="center" colspan="2">
									<input id="add-banking-item" class="btn btn-info" name="submit-banking-item" 
									 value="Save" tabindex="6" type="button">
                                    </td>
								</tr>
							</tbody>
							<tfoot>
		
							</tfoot>
						</table>
					</div>
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-submit-banking" value="{{$title}}">
                                {{$title}}</button>

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
    <script src="{{ asset('js/validation/landlord.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
        <script src="{{ asset('js/select2.js') }}"></script>
		<script src="{{ asset('js/dropdown.js') }}"></script>
		<script src="{{ asset('js/add-table-details.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection