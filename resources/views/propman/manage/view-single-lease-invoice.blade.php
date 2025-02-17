@php $title = 'Invoices Billed'; 
      $description = 'invoices generated...'; 
$tenantid = Crypt::encrypt($lease->tenantid);
$propertyid = Crypt::encrypt($lease->propertyid);
@endphp
    @extends('layout.no-menu-layout')
    @section('title', 'Invoices')
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
                <li class="breadcrumb-item"><a href="{{ route('propma.propinvo') }}">List</a></li>
                <li class="breadcrumb-item"><a href="{{ route('propma.viewpropinvo',$tenantid) }}">Tenant</a></li>
                <li class="breadcrumb-item"><a href="{{ route('propma.viewteninvo',[$tenantid,$propertyid]) }}">Lease</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            <div class="box box-block bg-white">
                <h5>{{$title}}</h5>
                <p class="font-90 text-muted mb-1"> {{$description}}</p>
                <span class="badge badge-pill bg-primary">{{ $lease->tenantfullname ?? ''}}
                    {{$lease->tenantcompanyname ?? '' }} : {{ $lease->propertydescription ?? ''}}</span><hr/>
                <div class="table-responsive">
                    <hr/><table  class="datatable table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Period</th>
                                    <th>Currency</th>
                                    <th>Billed Amount</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count=1;@endphp
                                @foreach($invoice as $abc)
                                <tr>
                                    <td>{{$count ++}}</td>
                                    <td>{{ $abc->invoicenumber}}</td>
                                    <td>{{\Carbon\Carbon::createFromTimestamp(strtotime
                            ($abc->datestamp))->format('M d, Y')}}</td>
                                    <td>{{ $abc->period }}</td>
                                    <td>{{ $abc->currencycode}}</td>
                                    <td>{{ $abc->totalbilled}}</td>
                                    <td>@php $id= Crypt::encrypt($abc->id);
                                        $lid= Crypt::encrypt($abc->leaseid);@endphp   
                                        @if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm" id=""
                                        href="{{route('propma.viewgeninvo',[$id,$lid])}}"
                                        title="view"><i class="ti-eye mr-0-5"></i>view</a>  @endif   
                            </td> 
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
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