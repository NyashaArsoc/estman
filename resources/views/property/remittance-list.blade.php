@php $title = 'Remit Property'; 
      $description = 'list of all monthly remittance...'; @endphp
    @extends('layout.main-layout')
    @section('title', 'Remit List')
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
                                    <th>Landlord</th>
                                    <th>Property Address</th>
                                    <th>Currency</th>
                                    <th>Billed</th>
                                    <th>Period</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($remit as $abc)
                            <tr>
                                @php if ($abc->clienttypeid == 1){//individual
                                    $owner   =  $abc->fullname ;
                                 }else{
                                     $owner   =  $abc->companyname ;
                                 }@endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $owner }}</td>
                                    <td>{{ $abc->propertyaddress }}</td>
                                    <td>{{ $abc->currencycode }}</td>
                                    <td>{{ $abc->totalbilled }}</td>
                                    <td>{{ $abc->period }}</td>
                                    <td>@php $id= Crypt::encrypt($abc->propertyid);
                                    $currency= Crypt::encrypt($abc->currencycode); 
                                    $period= Crypt::encrypt($abc->period); @endphp
                                        <a class="btn btn-info btn-sm " id=""
                                        href="{{route('property.remitprepare',['id'=>$id,'currency'=>$currency,'period'
                                        =>$period])}}"
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a>
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Landlord</th>
                                    <th>Property Address</th>
                                    <th>Currency</th>
                                    <th>Billed</th>
                                    <th>Period</th>
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