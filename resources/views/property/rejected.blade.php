@php $title = 'Rejected Properties'; 
      $description = 'properties rejected...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Properties Rejected')
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
                                    <th>Landlord</th>
                                    <th>Type</th>
                                    <th>Currency</th>
                                    <th>Location</th>
                                    <th>Address</th>
                                    <th>Reason</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($property as $abc)
                            <tr>@php if ($abc->landlordclienttype == 1){//individual
                                $owner   =  $abc->fullname ;
                             }else{
                                 $owner   =  $abc->companyname ;
                             } @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $owner}}</td>
                                    <td>{{ $abc->propertytype }}</td>
                                    <td>{{ $abc->code }}</td>
                                    <td>{{ $abc->location }}</td>
                                    <td>{{ $abc->streetaddress }}</td>
                                    <td>{{ $abc->reasons }}</td>
                                    <td>@php $id= Crypt::encrypt($abc->id); @endphp
                                        <a class="btn btn-secondary btn-sm view" id=""
                                        href="{{route('property.editview', $id)}}"
                                        title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>
                                        <a onclick = "deleteproperty(this); return false;"
                                        class="btn btn-danger btn-sm" href="{{route('property.deleterejected', $id)}}"
                                        title="delete"><i class="ti-close mr-0-5"></i>delete</a>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Landlord</th>
                                    <th>Type</th>
                                    <th>Currency</th>
                                    <th>Location</th>
                                    <th>Address</th>
                                    <th>Reason</th>
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