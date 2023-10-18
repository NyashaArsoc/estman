@php $title = 'Rejected Landlords'; 
      $description = 'landlords rejected...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Landlord Rejected')
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
                                    <th>Reason</th>
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
                                    <td>{{ $land->reasons }}</td>
                                    <td>@php $id= Crypt::encrypt($land->id); @endphp
                                     <a class="btn btn-secondary btn-sm view_landlord" id=""
                                     href="{{route('landlord.edit', $id)}}"
                                     title="view"><i class="ti-pencil mr-0-5"></i>edit</a>
                                     <a onclick = "deletelandlord(this); return false;"
                                     class="btn btn-danger btn-sm" href="{{route('landlord.deleterejected', $id)}}"
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
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection