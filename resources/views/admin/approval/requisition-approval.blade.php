@php
  $adminintake = $adminintake ?? [];
  $adminapprove = $adminapprove ?? [];
  $admindecline = $admindecline ?? [];
  $adminmanage = $adminmanage ?? [];
  $user = $user ?? (object)['firstname' => 'Shania', 'lastname' => 'Nyaude'];

  $title = 'Approval Workflow';
  $description = 'Review and approve requisitions submitted by initiators. Requisition type is shown for clarity.';

  // Inject dummy requisition data directly in Blade
  $requisitions = collect([
    (object)[
      'id' => 1,
      'requisition_code' => 'REQ-2025-001',
      'submitted_by' => 'Tariro Moyo',
      'type' => 'procurement',
      'amount' => 1250.75,
      'status' => 'pending',
      'finance_approved' => false,
    ],
  ]);
@endphp

@extends('layout.admin-main-menu')

@section('title', $title)

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
            <th>Requisition ID</th>
            <th>Submitted By</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>
          @php $count = 1; @endphp

          @isset($requisitions)
            @forelse($requisitions as $req)
              @php $id = Crypt::encrypt($req->id); @endphp
              <tr>
                <td>{{ $count++ }}</td>
                <td>{{ $req->requisition_code }}</td>
                <td>{{ $req->submitted_by }}</td>
                <td><span class="badge badge-primary">{{ ucfirst($req->type) }}</span></td>
                <td>${{ number_format($req->amount, 2) }}</td>
                <td>
                  <span class="status-label text-warning font-weight-bold">
                    {{ ucfirst($req->status) }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.requisition.view', ['id' => $id]) }}" class="btn btn-sm btn-outline-primary">
                    <i class="ti-eye"></i> View
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted">No requisitions available for approval.</td>
              </tr>
            @endforelse
          @else
            <tr>
              <td colspan="7" class="text-center text-muted">Requisition data not loaded.</td>
            </tr>
          @endisset
        </tbody>
      </table>
      @include('layout.arlet')
    </div>
  </div>
</div>
<!-- Content End -->
@endsection

@section('additional js')
<!-- No approval logic needed -->
@endsection
