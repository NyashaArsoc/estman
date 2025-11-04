@php
$title = 'Landlord Diary';
@endphp

@extends('layout.propman-main-menu')

@section('title', $title)

@section('content')
<div class="container-fluid">
  <h4>{{ $title }}</h4>

  <form method="GET" action="{{ route('prop.report.landlord.generate') }}">
    <div class="row">
      <div class="col-md-4">
        <label for="date_from">Date From</label>
        <input type="date" name="date_from" id="date_from" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label for="date_to">Date To</label>
        <input type="date" name="date_to" id="date_to" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label for="format">Export Format</label>
        <select name="format" id="format" class="form-control" required>
          <option value="pdf">PDF</option>
          <option value="excel">Excel</option>
        </select>
      </div>
    </div>
    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Generate Report</button>
    </div>
  </form>
</div>
@endsection
