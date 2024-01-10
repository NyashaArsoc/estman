@php $title = 'Manage Lease'; 
      $description = 'list of all leases...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Manage Lease')
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
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Rental</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody> @php $count=1;@endphp
                                @foreach($lease as $abc)
                                <tr> @php //if ($abc->available = 'o'){
                                    if (trim($abc->available) =='Y'){
                                        $status = 'active'; 
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                     }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary'; 
                                    } 
                                if ($abc->clienttypeid == 1){//individual
                                    $tenantname   =  $abc->fullname ;
                                 }else{
                                     $tenantname   =  $abc->companyname ;
                                 } 
                                 @endphp 
                                 
                                    <td>{{$count ++}}</td>
                                    <td>{{ $tenantname}}</td>
                                    <td>{{ $abc->propertydescription }}</td>
                                    <td>{{ $abc->validfrom}}</td>
                                    <td>{{ $abc->validto }}</td>
                                    <td>{{ $abc->rentalcurrency.' '.number_format($abc->rental, 2) }}</td>
                                    <td><span class="{{ $badge }}">{{$status}}</span></td>
                                    <td>@php $id= Crypt::encrypt($abc->id); @endphp
                                     <a class="btn btn-info btn-sm" href="{{route('lease.view', $id)}}"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                     <a onclick = "DeactivateLandlord(this); return false;"
                                     class="btn btn-warning btn-sm" href=""
                                     title="View Landlord"><i class="ti-close mr-0-5"></i>deactivate</a>
                                     <a onclick = "DeleteLandlord(this); return false;"
                                     class="btn btn-danger btn-sm" href=" "
                                     title="View Landlord"><i class="ti-close mr-0-5"></i>delete</a>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th>Rental</th>
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
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
        <script src="{{ asset('js/select2.js') }}"></script>
		<script src="{{ asset('js/dropdown.js') }}"></script>
		<script src="{{ asset('js/add-banking-details.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection