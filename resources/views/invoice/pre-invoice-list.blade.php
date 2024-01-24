@php $title = 'Profoma Billed'; 
      $description = 'profoma pending generation...'; 
    
@endphp
    @extends('layout.main-layout')
    @section('title', 'Profoma Billed')
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
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
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
                                    <th>Period</th>
                                    <th>Currency</th>
                                    <th>Billed Amount</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>@php $count=1;@endphp
                                @foreach($invoice as $abc)
                               @php
                                $totalbilled = ($abc->rental + $abc->rates + $abc->operationalcost +
                                $abc->balancebd + $abc->interestbd);
                                  if ($abc->clienttypeid == 1){
                                    $tname   =  $abc->fullname ;
                                   }else{
                                     $tname   =  $abc->companyname ;
                                 } 
                               @endphp
                                   <tr>
                                    <td>{{$count ++}}</td>
                                    <td>{{$tname }}</td> 
                                    <td>{{\Carbon\Carbon::createFromTimestamp(strtotime
                                    ($abc->period))->format('M-Y')}}</td>
                                    <td>{{ $abc->currencycode }}</td>
                                    <td>{{ $totalbilled }}</td>
                                    <td>@php $id= Crypt::encrypt($abc->id) @endphp
                                        <a class="btn btn-info btn-sm " id=""
                                        href="{{route('invoice.viewpro', $id)}}"
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Period</th>
                                    <th>Currency</th>
                                    <th>Billed Amount</th>
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
    <!-- Additional JS End-->
    @endsection