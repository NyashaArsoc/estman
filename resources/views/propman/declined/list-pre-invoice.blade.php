@php $title = 'Profoma Edited'; 
      $description = 'invoices edited before generated...'; @endphp
    @extends('layout.propman-main-menu')
    @section('title', 'Profoma')
    @section('additional css')
    <!-- Additional css Start-->
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
                                    <th>Name</th>
                                    <th>Property</th>
                                    <th>Period</th>
                                    <th>Currency</th>
                                    <th>Billed Amount</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count=1;@endphp
                                @foreach($invoice as $abc)
                                <tr>@php
                                    $totalbilled = ($abc->rental + $abc->rates + $abc->operationalcost +
                                    $abc->balancebd + $abc->interest + $abc->vat); @endphp
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->companyname}} {{ $abc->fullname}}</td>
                                    <td>{{ $abc->propertydescription }}</td>
                                    <td>{{ $abc->period }}</td>
                                    <td>{{ $abc->currencycode}}</td>
                                    <td>{{ $totalbilled }}</td>
                                    <td>@php $id= Crypt::encrypt($abc->id)@endphp   
                                        @if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm" id=""
                                        href="{{route('propdec.vieweditpre',$id)}}"
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a>  @endif   
                            </td> 
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Property</th>
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
		<script src="{{ asset('js/dropdown.js') }}"></script>
		<script src="{{ asset('js/add-banking-details.js') }}"></script> 
    <!-- Additional JS End-->
    @endsection