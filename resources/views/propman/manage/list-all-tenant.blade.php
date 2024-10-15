@php $title = 'Manage Tenants'; 
      $description = 'list of all tenants...'; @endphp
    @extends('layout.propman-main-menu')
    @section('title', 'Manage Tenants')
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
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Registration</th>
                                    <th>Cell</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($tenant as $abc)
                            <tr>
                                @php
                                $id= Crypt::encrypt($abc->id); 
                                if (trim($abc->available) == 'Y'){
                                        $status = 'available';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                        $buttondeactivate = '<a onclick = "deactivaterecord(this); 
                                        return false;" class="btn btn-warning btn-sm" href="' . route('propdec.disten',$id) . '"
                                     title="disable"><i class="ti-close mr-0-5"></i>disable</a>';
                                     $buttonview = '<a class="btn btn-info btn-sm"  href="' . route('propma.viewtena',$id) . '"
                                     title="view"><i class="ti-eye mr-0-5"></i>view</a>';
                                     $buttonedit = '<a class="btn btn-secondary btn-sm"  href="' . route('propma.edittena',$id) . '"
                                     title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>';
                                    }else if (trim($abc->available) == 'D'){//include the deleted status
                                        $status = 'deleted';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate = '';
                                        $buttonview = '';
                                        $buttonedit = '';
                                    }else{
                                    if (trim($abc->approval) == 'R'){ 
                                        $status = 'rejected';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate = '';
                                        $buttonview = '';
                                        $buttonedit = '';
                                    }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                        $buttondeactivate ='';
                                        $buttonview = '';
                                        $buttonedit = '';
                                    }
                                 }
                                 @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->clienttype }}</td>
                                    <td>{{  $abc->companyname  }} {{  $abc->fullname  }}</td>
                                    <td>{{  $abc->nationalid  }} {{  $abc->companynumber  }}</td>
                                    <td>{{ $abc->cell }}</td>
                                    <td>{{ $abc->email }}</td>
                                    <td><span class="{{ $badge }}">{{$status}}</span></td>
                                    <td>
                                        @if (in_array(3,$arraycontrolids)){!! $buttonview !!} @endif
                                        @if (in_array(2,$arraycontrolids)){!! $buttonedit !!} @endif
                                        @if (in_array(7,$arraycontrolids)){!! $buttondeactivate !!} @endif
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Registration</th>
                                    <th>Cell</th>
                                    <th>Email</th>
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