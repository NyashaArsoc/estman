@php
$title = 'Allocate Property';
$description = 'select properties to allocate...';
@endphp
@extends('layout.no-menu-layout')
@section('title', $title)
@section('additional css')
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
<script src="{{ asset('js/dropdown-get-data.js') }}"></script>
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">

        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5>Valuer Name: </h5>
                <p class="font-90 text-muted mb-1">Check the items you want to allocate</p>
            </div>
        </div>
        <form action="" method="POST" id="defaultform" enctype="multipart/form-data">
            @csrf
            <div>
                <button type="submit" class="btn btn-primary" id="btn-upload-stkbatch">Allocate
                    <span id="selected-items-info"></span>
                </button>
            </div>
            <div class="table-responsive">
                <!-- <div class="alert alert-primary" id="selected-items-info" role="alert" style="display: none;"></div> -->
                <hr />
                <table class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Property Type</th>
                            <th>Location </th>
                            <th>Street Address </th>
                            <th>Select <input type="checkbox" id="select-all"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @foreach($type as $abc)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $abc->description }}</td>
                            <td>{{ $abc->description }}</td>
                            <td>{{ $abc->description }}</td>
                            <td>
                                <input type="checkbox" name="selected_serials[]" value="{{ $abc->id }}" class="select-item">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Property Type</th>
                            <th>Location </th>
                            <th>Street Address </th>
                            <th>Select</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
        <!-- <div class="mt-3"></div> -->
        @include('layout.arlet')
    </div>
</div>
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/validation/intake.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.select-item');
        const selectedItemsInfo = document.getElementById('selected-items-info');
        const allocateButton = document.getElementById('btn-upload-stkbatch');

        function updateSelectedItemsInfo() {
            const selectedCount = document.querySelectorAll('.select-item:checked').length;
            // selectedItemsInfo.style.display = selectedCount > 0 ? 'block' : 'none';
            selectedItemsInfo.textContent = selectedCount > 0 ? `${selectedCount} items selected` : '';
            allocateButton.disabled = selectedCount === 0;
        }

        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            updateSelectedItemsInfo();
        });

        itemCheckboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedItemsInfo));

        updateSelectedItemsInfo(); // Initial check
    });
</script>
<!-- Additional JS End-->
@endsection