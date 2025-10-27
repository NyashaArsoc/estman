@php
$title = 'Order Approval';
$description = 'Review and approve requisitions submitted by initiators. Requisition type is shown for clarity.';
@endphp
@extends('layout.admin-main-menu')
@section('title', 'Requisitions')
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
            <th>No</th>
            <th>Order No</th>
            <th>Submitted By</th>
            <th>Description</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>@php $count=1;@endphp
          @foreach($order as $abc)
          <tr>@php $id= Crypt::encrypt($abc->ordernumber);@endphp
            <td>{{ $count++ }}</td>
            <td>{{ $abc->ordernumber }} </td>
            <td> {{ $abc->operatorid }}</td>
            <td> {{ $abc->description }} </td>
            <td> {{ $abc->requisitiontype }} </td>
            <td> {{ $abc->currencycode }} {{ $abc->totalprice }} </td>
            <td> @if (in_array(3,$arraycontrolids))<a class="btn btn-info btn-sm " id=""
                href="{{route('admapp.viwsinglereqapp',$id)}}"
                title="view"><i class="ti-eye mr-0-5"></i>view</a> @endif
            </td>
          </tr>@endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Order No</th>
            <th>Submitted By</th>
            <th>Description</th>
            <th>Type</th>
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

@section('additional js')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const approveButtons = document.querySelectorAll('.btn-approve');

    function showConfirmation(action, id) {
      const confirmed = confirm(`Are you sure you want to ${action} requisition ${id}?`);
      if (confirmed) {
        console.log(`${action} confirmed for ${id}`);
        const statusLabel = document.querySelector(`button[data-id="${id}"]`).closest('tr').querySelector('.status-label');
        statusLabel.textContent = 'Approved';
        statusLabel.className = 'status-label text-success font-weight-bold';
      }
    }

    approveButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        showConfirmation('approve', id);
      });
    });
  });
</script>
@endsection