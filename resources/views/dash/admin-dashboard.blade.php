@php
$title = 'Dashboard';
@endphp
@extends('layout.admin-main-menu')
@section('title', 'Admin Dashboard')

@section('content')
<!-- Content Start-->
<!-- Content Start-->

<div class="container-fluid px-3">
    <div class="row">
        <!-- Total Requisitions -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="box box-block tile tile-2 bg-gradient-primary text-white shadow-sm p-3 position-relative overflow-hidden">
                <div class="t-icon">
                    <i class="ti-clipboard text-white"></i>
                </div>
                <div class="t-content">
                    <h6 class="text-uppercase fw-bold mb-1">Total Requisitions</h6>
                    <h4 class="fw-bolder">13</h4>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="box box-block tile tile-2 bg-gradient-warning text-white shadow-sm p-3 position-relative overflow-hidden">
                <div class="t-icon">
                    <i class="ti-timer text-white"></i>
                </div>
                <div class="t-content">
                    <h6 class="text-uppercase fw-bold mb-1">Pending Approvals</h6>
                    <h4 class="fw-bolder">6</h4>
                </div>
            </div>
        </div>

        <!-- Approved Requests -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="box box-block tile tile-2 bg-gradient-success text-white shadow-sm p-3 position-relative overflow-hidden">
                <div class="t-icon">
                    <i class="ti-check text-white"></i>
                </div>
                <div class="t-content">
                    <h6 class="text-uppercase fw-bold mb-1">Approved Requests</h6>
                    <h4 class="fw-bolder">10</h4>
                </div>
            </div>
        </div>

        <!-- Rejected Requests -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="box box-block tile tile-2 bg-gradient-danger text-white shadow-sm p-3 position-relative overflow-hidden">
                <div class="t-icon">
                    <i class="ti-close text-white"></i>
                </div>
                <div class="t-content">
                    <h6 class="text-uppercase fw-bold mb-1">Rejected Requests</h6>
                    <h4 class="fw-bolder">2</h4>
                </div>
            </div>
        </div>

        <!-- Total Value of Requests -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
            <div class="box box-block tile tile-2 bg-gradient-info text-white shadow-sm p-3 position-relative overflow-hidden">
                <div class="t-icon">
                    <i class="ti-stats-up text-white"></i>
                </div>
                <div class="t-content">
                    <h6 class="text-uppercase fw-bold mb-1">Total Value of Requests</h6>
                    <h4 class="fw-bolder">$24,000</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    html, body {
        overflow-x: hidden !important;
        max-width: 100%;
    }


    .wrapper {
        overflow: hidden !important;
        width: 100% !important;
    }

    .site-content {
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }

    .content-area {
        overflow: visible !important;
    }


    .site-sidebar {
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }


    body.fixed-sidebar {
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }


    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }


    .container-fluid {
        max-width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        overflow: visible !important;
    }

    .content-area .container-fluid {
        padding-right: 20px;
        padding-left: 20px;
    }


    .row {
        margin-right: -10px;
        margin-left: -10px;
        overflow: visible !important;
    }

    .row > [class*='col-'] {
        padding-right: 10px;
        padding-left: 10px;
    }

    .tile {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 120px;
        border: none !important;
        border-radius: 0px;
        width: 100%;
    }

    .tile:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }

    .t-content {
        position: relative;
        z-index: 2;
    }

    .t-content h6 {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
        opacity: 0.9;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .t-content h4 {
        font-size: 1.3rem;
        margin: 0;
        font-weight: 700;
    }

    .t-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        opacity: 0.2;
        z-index: 1;
    }

    .t-icon i {
        font-size: 30px;
    }


    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #00c6ff);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffb400, #ff6f00);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #00b09b, #96c93d);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #ff416c, #ff4b2b);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
    }


    @media (max-width: 575px) {
        .t-content h6 {
            font-size: 0.7rem;
        }

        .t-content h4 {
            font-size: 1.1rem;
        }

        .t-icon i {
            font-size: 25px;
        }

        .tile {
            height: 110px;
        }

        .container-fluid {
            padding-right: 10px;
            padding-left: 10px;
        }

        .row {
            margin-right: -5px;
            margin-left: -5px;
        }

        .row > [class*='col-'] {
            padding-right: 5px;
            padding-left: 5px;
        }
    }

    @media (max-width: 767px) {
        .tile:hover {
            transform: none;
        }
    }
</style>

<!-- Content End-->
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<!-- Additional JS End-->
@endsection
