@php $title = 'Lease Reports'; 
      $description = 'generating lease reports...'; @endphp
    @extends('layout.view-report-lease')
    @section('title', 'Lease Reports')
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
                                </tr>
                            </thead>
                            <tbody> @php $count=1;@endphp
                                @foreach($lease as $abc)
                                <tr> @php 
                                    $id= Crypt::encrypt($abc->id);
                                if ($abc->clienttypeid == 1){//individual
                                    $tenantname   =  $abc->fullname ;
                                 }else{
                                     $tenantname   =  $abc->companyname ;
                                 } 
                                 if(trim($abc->expiry) == 'Y'){
                                    $status = 'expired';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                 }else{
                                    if (trim($abc->available) == 'Y'){
                                        $status = 'available';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                     $buttonrenew = '';
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
                                 }
                                 @endphp 
                                    <td>{{$count ++}}</td>
                                    <td>{{ $tenantname}}</td>
                                    <td>{{ $abc->propertydescription }}</td>
                                    <td>{{ $abc->validfrom}}</td>
                                    <td>{{ $abc->validto }}</td>
                                    <td>{{ $abc->rentalcurrency.' '.number_format($abc->rental, 2) }}</td>
                                    <td><span class="{{ $badge }}">{{$status}}</span></td>
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
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection