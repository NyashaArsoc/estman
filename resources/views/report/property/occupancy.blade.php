@php $title = 'Property Occupancy'; 
      $description = 'generating property reports...'; @endphp
    @extends('layout.view-report-property')
    @section('title', 'Property Occupancy')
    @section('content')
        <!-- Content Start-->
        <div class="container-fluid">
            <h4>{{$title}}</h4>
            <ol class="breadcrumb no-bg mb-1">
                <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('report.viewprop')}}">List</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <form class="form-material material-primary" id="" method="GET"
                 action="{{ route('report.printoccu') }}">@csrf
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Address</th>
                                    <th>Property Type</th>
                                    <th>Tenants</th>
                                    <th>Rate Occupied</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($occupany as $abc)
                            <tr>@php 
                             if (trim($abc->occupancy) == 'F'){
                                        $status = 'fully occupied';
                                        $badge = "badge badge-pill bg-success badge-secondary";
                                    }else if (trim($abc->occupancy) == 'P'){//include the deleted status
                                        $status = 'partially occupied';
                                        $badge = 'badge badge-pill bg-warning badge-secondary';
                                    }else if (trim($abc->occupancy) == 'E'){ 
                                        $status = 'empty';
                                        $badge = 'badge badge-pill bg-warning badge-secondary';
                                    }else{
                                        $status = 'inactive';
                                        $badge = 'badge badge-pill bg-danger badge-secondary';
                                    }
                                if($abc->propertytypeid == 1 && trim($abc->occupancy) == 'F'){
                                    $rate = '100 %' ;
                                }else{$rate =number_format($abc->occupancyrate,2).' %';}
                                 @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->streetaddress }}</td>
                                    <td>{{ $abc->propertytype }}</td>
                                    <td>{{ $abc->totaltenants }}</td>
                                    <td>{{ $rate }}</td>
                                    <td><span class="{{ $badge }}">{{$status}}</span></td>
                                   
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Address</th>
                                    <th>Property Type</th>
                                    <th>Tenants</th>
                                    <th>Rate Occupied</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                        @include('layout.arlet')
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-submit" >
                            <i class="ti-download mr-0-5"></i>export</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!-- Content End-->
    @endsection
    @section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection