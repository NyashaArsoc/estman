@php $title = 'Pending Approval'; 
      $description = 'tenants pending approval...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Tenant Approval')
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
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($tenant as $ten)
                            <tr>
                                @php if ($ten->clienttypeid == 1){
                                    $owner   =  $ten->fullname ;
                                    $registration   =  $ten->nationalid ;
                                 }else{
                                     $owner   =  $ten->companyname ;
                                     $registration   =  $ten->companynumber ;
                                 } @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $ten->typedescription }}</td>
                                    <td>{{ $owner}}</td>
                                    <td>{{ $registration }}</td>
                                    <td>{{ $ten->cell }}</td>
                                    <td>{{ $ten->email }}</td>
                                    <td>@php $id= Crypt::encrypt($ten->id); @endphp
                                        <a class="btn btn-info btn-sm view_landlord" id=""
                                        href="{{route('tenant.viewpending', $id)}}"
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                        <a onclick = "approvetenant(this); return false;"
                                        class="btn btn-success btn-sm" href="{{route('tenant.approve', $id)}}"
                                        title="activate"><i class="ti-check mr-0-5"></i>activate</a>
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