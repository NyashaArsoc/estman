@php
  $adminintake = $adminintake ?? [];
  $adminapprove = $adminapprove ?? [];
  $admindecline = $admindecline ?? [];
  $adminmanage = $adminmanage ?? [];
  $user = $user ?? (object)['firstname' => 'Shania', 'lastname' => 'Nyaude'];
  $requisitions = $requisitions ?? [];
  $title = 'Manage Requisitions';
@endphp

@extends('layout.admin-main-menu')

@section('title', $title)

@section('content')
<style>
  .table th,
  .table td {
    border: 1px solid #ced4da;
  }
  .table th {
    font-weight: bold;
    background-color: #f8f9fa;
    color: #000;
  }
  .table td {
    vertical-align: middle;
  }
  .btn-sm {
    border-radius: 6px;
    font-weight: 500;
    padding: 6px 16px;
    font-size: 14px;
    height: 38px;
  }
  .btn-primary { background-color: #007bff; color: #fff; }
  .badge-success { background-color: #28a745; }
  .badge-danger { background-color: #dc3545; }
  .badge-warning { background-color: #ffc107; color: #212529; }
</style>

<div class="page-header">
  <h3 class="page-title" style="color: #000;">{{ $title }}</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">Manage</li>
    </ol>
  </nav>
</div>

<p>Track and review all submitted requisitions below.</p>

<div class="table-responsive mt-4">
  <table class="table table-bordered table-hover">
    <thead class="thead-dark">
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
      @forelse($requisitions as $index => $req)
        @php
          $viabilityClass = $req->is_viable ? 'badge-success' : 'badge-danger';
          $statusClass = match($req->status) {
            'approved' => 'badge-success',
            'declined' => 'badge-danger',
            default => 'badge-warning',
          };
          $id = Crypt::encrypt($req->id);
        @endphp
        <tr class="{{ $index % 2 === 0 ? 'table-light' : '' }}">
          <td>{{ $index + 1 }}</td>
          <td><strong>{{ $req->id }}</strong></td>
          <td>{{ $req->vendor }}</td>
          <td>{{ ucfirst($req->category) }}</td>
          <td>${{ number_format($req->amount, 2) }}</td>
          <td><span class="badge {{ $viabilityClass }}">{{ $req->is_viable ? 'Viable' : 'Not Viable' }}</span></td>
          <td><span class="badge {{ $statusClass }}">{{ ucfirst($req->status) }}</span></td>
          <td>{{ $req->submitted_by }}</td>
          <td>{{ $req->description }}</td>
          <td>
            <a href="{{ route('admin.requisition.view', ['id' => $id]) }}" class="btn btn-sm btn-primary">View</a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="10" class="text-center text-muted">No requisitions found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
