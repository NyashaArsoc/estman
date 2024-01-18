@php
$title = 'Lease Rates/Charges';
$description = 'unposted new lease balances...'; @endphp
@extends('layout.main-layout')
@section('title', 'Post Balances')

@section('additional css')
    <!-- Additional css Start-->
    <link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <!-- Additional css End-->
@endsection
@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <div class="table-responsive">
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Curreny</th>
                            <th>Balance b/d</th>
                            <th>Rates/Utilities</th>
                            <th>Operation Cost</th>
                            <th>Deposit Paid</th>
                            <th>Admin Paid</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody> @php $count=1;@endphp
                        @foreach($balances as $abc)
                        @php
                        if ($abc->clienttypeid == 1){//individual
                            $tenantname   =  $abc->fullname ;
                         }else{
                             $tenantname   =  $abc->companyname ;
                         } 
                         @endphp 
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $tenantname}}</td>
                            <td>{{ $abc->code }}</td>
                            <td>{{number_format($abc->balancebd, 2)}}</td>
                            <td>{{number_format($abc->ratescosts, 2)}}</td>
                            <td>{{number_format($abc->operationalcosts, 2)}}</td>
                            <td>{{number_format($abc->deposit, 2)}}</td>
                            <td>{{number_format($abc->adminpaid, 2)}}</td>
                            <td>@php $id= Crypt::encrypt($abc->leaseid);$code= Crypt::encrypt($abc->code); @endphp
                                <a class="btn btn-info btn-sm" href="{{route('transact.postnewbal',['id'=>$id,'code'=>$code])}}"
                                 title="view"><i class="ti-share mr-0-5"></i>post</a>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Curreny</th>
                            <th>Balance b/d</th>
                            <th>Rates/Utilities</th>
                            <th>Operation Cost</th>
                            <th>Deposit Paid</th>
                            <th>Admin Paid</th>
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
