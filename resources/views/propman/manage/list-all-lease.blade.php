@php $title = 'Manage Lease'; 
      $description = 'list of all leases...'; @endphp
    @extends('layout.propman-main-menu')
    @section('title', 'Manage Lease')
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
                                    <th>Address</th>
                                    <th>Description</th>
                                    <th>Valid From - Till</th>
                                    <th>Rental</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody> @php $count=1;@endphp
                                @foreach($lease as $abc)
                                <tr> @php 
                                    $id= Crypt::encrypt($abc->id); 
                                 if(trim($abc->expiry) == 'Y'){
                                    $status = 'expired';
                                    $badge = 'badge badge-pill bg-danger badge-secondary';
                                    $buttondeactivate = '';
                                    $buttonview = '';
                                    $buttonedit = '';
                                    $buttonrenew = '<a class="btn btn-info btn-sm"  href=""
                                     title="renew"><i class="ti-pencil mr-0-5"></i>renew</a>';
                                 }else{
                                    if (trim($abc->available) == 'Y'){
                                        $status = 'available';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                        $buttondeactivate = '<a onclick = "deactivatelease(this); 
                                        return false;" class="btn btn-danger btn-sm" href=""
                                     title="disable"><i class="ti-close mr-0-5"></i>disable</a>';
                                     $buttonview = '<a class="btn btn-info btn-sm"  href="' . route('propma.viewlea',$id) . '"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>';
                                     $buttonrenew = '';
                                     $buttonedit = '<a class="btn btn-secondary btn-sm"  href="' . route('propma.editlea',$id) . '"
                                     title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>';
                                    }else if (trim($abc->available) == 'D'){//include the deleted status
                                        $status = 'deleted';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate = '';
                                        $buttonview = '';
                                        $buttonrenew = '';
                                        $buttonedit = '';
                                    }else{
                                    if (trim($abc->approval) == 'R'){ 
                                        $status = 'rejected';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate = '';
                                        $buttonview = '';
                                        $buttonrenew = '';
                                    }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate ='';
                                        $buttonview = '';
                                        $buttonrenew = '';
                                    }
                                    $buttonedit = '';
                                    }
                                 }
                                 @endphp 
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->tenantcompanyname }} {{ $abc->tenantfullname }}</td>
                                    <td>{{ $abc->streetaddress }}</td>
                                    <td>{{ $abc->propertydescription }}</td>
                                    <td>{{ $abc->validfrom}} <b>TO</b> {{ $abc->validto }}</td>
                                    <td>{{ $abc->currencycode }} {{ number_format($abc->rental, 2) }}</td>
                                    <td><span class="{{ $badge }}">{{$status}}</span></td>
                                    <td>@if (in_array(3,$arraycontrolids)){!! $buttonview !!} @endif
                                        @if (in_array(7,$arraycontrolids)){!! $buttondeactivate !!} @endif
                                        @if (in_array(8,$arraycontrolids)){!! $buttonrenew !!}  @endif
                                        @if (in_array(2,$arraycontrolids)){!! $buttonedit !!} @endif
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Valid From - Till</th>
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
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection