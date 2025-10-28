@php
$title = 'Manage Requisitions';
$description = 'Track and review all submitted requisitions. Viability and status are shown for clarity.';
@endphp

@extends('layout.admin-main-menu')

@section('title', 'Manage Requisitions')

@section('content')
<!-- Content Start -->
<div class="container-fluid">
  <h4>{{ $title }}</h4>
  <ol class="breadcrumb no-bg mb-1">
    <li class="breadcrumb-item active">{{ $title }}</li>
  </ol>

  <div class="box box-block bg-white">
    <h5>{{ $title }}</h5>
    <p class="font-90 text-muted mb-1">{{ $description }}</p>

    <div class="table-responsive">
      <hr />
      <table class="datatable table table-hover table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Order No</th>
            <th>Submitted By</th>
            <th>Type</th>
            <th>Description</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>@php $count=1;@endphp
          @foreach($order as $abc)
          <tr>@php $id= Crypt::encrypt($abc->ordernumber);
            if (trim($abc->requisitionstatus) == 'declined'){
            $badge = 'bg-danger';
            }elseif (trim($abc->requisitionstatus) == 'pending'){
            $badge = 'bg-info';
            }elseif (trim($abc->requisitionstatus) == 'completed'){
            $badge = 'bg-success';
            }else{
            $badge = 'bg-warning';
            }
            @endphp
            <td>{{ $count++ }}</td>
            <td>{{ $abc->ordernumber }} </td>
            <td> {{ $abc->operatorid }}</td>
            <td> {{ $abc->requisitiontype }} </td>
            <td> {{ $abc->description }} </td>
            <td><span class="badge badge-pill {{ $badge }}">{{$abc->requisitionstatus}}</span> </td>
            <td> {{ $abc->currencycode }} {{ $abc->totalprice }} </td>
            <td> @if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm " id=""
                href="{{route('admapp.viwsinglereqapp',$id)}}"
                title="view"><i class="ti-eye mr-0-5"></i>view</a> @endif
            </td>
          </tr>@endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Order No</th>
            <th>Submitted By</th>
            <th>Type</th>
            <th>Description</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Options</th>
          </tr>
        </tfoot>
      </table>
      @include('layout.arlet')
    </div>
  </div>
</div>
<!-- Content End -->
@endsection