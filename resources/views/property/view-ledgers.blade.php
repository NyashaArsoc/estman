@php 
$title = 'Subledgers';
$description = 'property subledgers...'; 
$id= Crypt::encrypt($property->id);
$product= Crypt::encrypt('property');
if ($property->landlordclienttype == 1){
    $owner   =  $property->fullname ;
    }else{
   $owner   =  $property->companyname ;
   } 
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Property Subledgers')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('property.list')}}">List</a></li>
            <li class="breadcrumb-item"><a href="{{route('property.view',$id)}}">Property</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="" method="POST"
                action="{{route('landlord.createsub',['id'=>$id,'product'=>$product])}}">@csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Landlord Name
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $owner }}" readonly>
                    </div>
                    <label for="" class="col-sm-2 form-control-label">Address </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $property->streetaddress }}" readonly>
                    </div>
             </div> 
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead> 
                                <tr>
                                    <th>No</th>
                                    <th>Account Code</th>
                                    <th>Currency</th>
                                    <th>GL Code</th>
                                    <th>GL Name</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($ledgers as $abc)
                            <tr>
                               
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->accountcode }}</td>
                                    <td>{{ $abc->currencycode }}</td>
                                    <td>{{ $abc->code }}</td>
                                    <td>{{ $abc->description }}</td>  
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Account Code</th>
                                    <th>Currency</th>
                                    <th>GL Code</th>
                                    <th>GL Name</th>
                                </tr>
                            </tfoot>
                        </table>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-submit" >
                            create ledgers</button>
                    </div>
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/landlord.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
@endsection
