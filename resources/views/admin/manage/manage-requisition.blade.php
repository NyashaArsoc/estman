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
            <th>Requisition ID</th>
            <th>Vendor</th>
            <th>Category</th>
            <th>Amount</th>
            <th>Viability</th>
            <th>Status</th>
            <th>Submitted By</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $count = 1; @endphp
          @foreach($requisitions as $req)
            @php
              $isViable = property_exists($req, 'is_viable') ? $req->is_viable : null;
              $viabilityClass = $isViable ? 'badge-success' : 'badge-danger';
              $viabilityLabel = $isViable ? 'Viable' : 'Not Viable';

              $statusClass = match(trim($req->status ?? '')) {
                'approved' => 'badge-success',
                'declined' => 'badge-danger',
                default => 'badge-warning',
              };

              $id = Crypt::encrypt($req->id);
            @endphp
            <tr>
              <td>{{ $count++ }}</td>
              <td><strong>{{ property_exists($req, 'id') ? $req->id : 'N/A' }}</strong></td>
              <td>{{ property_exists($req, 'vendor') && trim($req->vendor) !== '' ? $req->vendor : 'Not specified' }}</td>
              <td>{{ property_exists($req, 'category') && trim($req->category) !== '' ? ucfirst(trim($req->category)) : 'Not specified' }}</td>
              <td>${{ number_format(property_exists($req, 'amount') ? $req->amount : 0, 2) }}</td>
              <td><span class="badge {{ $viabilityClass }}">{{ $viabilityLabel }}</span></td>
              <td><span class="badge {{ $statusClass }}">{{ ucfirst(trim($req->status ?? 'Pending')) }}</span></td>
              <td>{{ property_exists($req, 'submitted_by') && trim($req->submitted_by) !== '' ? $req->submitted_by : 'Unknown' }}</td>
              <td>{{ property_exists($req, 'description') && trim($req->description) !== '' ? $req->description : 'Not specified' }}</td>
              <td>
                <a href="{{ route('admin.requisition.view', ['id' => $id]) }}" class="btn btn-info btn-sm" title="View">
                  <i class="ti-eye mr-0-5"></i>View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
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
    console.log('Manage requisition table loaded');
  });
</script>
@endsection
