@php 
$title = 'Leases';
$description = 'tenant leases...'; 
$id= Crypt::encrypt($tenant->id);
$product= Crypt::encrypt('remittance');
if ($tenant->clienttypeid == 1){
    $lname   =  $tenant->fullname ;
    }else{
   $lname   =  $tenant->companyname ;
   } 
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Tenant Leases')
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('tenant.list')}}">List</a></li>
            <li class="breadcrumb-item"><a href="{{route('tenant.view',$id)}}">Tenant</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="addlandlord" method=""
                action="">
                <div class="form-group row">
                    <label for="LastName" class="col-sm-2 form-control-label">Name
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" value="{{ $lname }}" readonly>
                    </div>
             </div> 
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead> 
                                <tr>
                                    <th>No</th>
                                    <th>Description</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Rental</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($lease as $abc)
                            <tr>@php 
                                 if (trim($abc->available) == 'Y'){
                                        $status = 'active';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                    }else if (trim($abc->available) == 'D'){//include the deleted status
                                        $status = 'deleted';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }else{
                                    if (trim($abc->approval) == 'R'){ 
                                        $status = 'rejected';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }else{
                                        if (trim($abc->expiry) == 'Y'){
                                        $status = 'expired';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        }else{
                                            $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        }
                                    }
                                 }@endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->propertydescription }}</td>
                                    <td>{{ $abc->validfrom }}</td>
                                    <td>{{ $abc->validto }}</td>
                                    <td>{{ $abc->rentalcurrency.' '.number_format($abc->rental, 2)  }}</td>  
                                    <td><span class="{{ $badge }}">{{$status}}</span></td>  
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Description</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Rental</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
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
