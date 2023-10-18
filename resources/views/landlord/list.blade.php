@php $title = 'Manage Landlords'; 
      $description = 'list of all landlords...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Manage Landlords')
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
                                @foreach($landlord as $land)
                            <tr>
                                @php if ($land->clienttypeid == 1){
                                    $owner   =  $land->fullname ;
                                    $registration   =  $land->nationalID ;
                                 }else{
                                     $owner   =  $land->companyname ;
                                     $registration   =  $land->companynumber ;
                                 } @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $land->description }}</td>
                                    <td>{{ $owner}}</td>
                                    <td>{{ $registration }}</td>
                                    <td>{{ $land->cell }}</td>
                                    <td>{{ $land->email }}</td>
                                    <td><span class="badge badge-pill  bg-success badge-secondary">Success</span></td>
                                    <td><a class="btn btn-secondary btn-sm" href = ""
                                     title="Edit Landlord"><i class="ti-pencil mr-0-5"></i>Edit</a> 
                                     <a class="btn btn-info btn-sm view_landlord" id=""
                                     title="Deactivate Landlord"><i class="ti-eye mr-0-5"></i>view</a>
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