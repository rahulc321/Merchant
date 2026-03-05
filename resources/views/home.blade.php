@extends('layouts.admin')

@section('title', 'LMS Merchant - Dashboard')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
html,
body {
    overflow-x: hidden;
}

/* ===== CARD ===== */
.card {
    border: none;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.05);
}

.widget-content-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.widget-heading {
    font-size: 16px;
    font-weight: 600;
}

.widget-subheading {
    font-size: 13px;
    opacity: .8;
}

.widget-numbers {
    font-size: 26px;
    font-weight: 700;
}

/* ===== GRADIENTS ===== */
.bg-1 {
    background: linear-gradient(45deg, #1a2a6c, #1f3c88);
    color: #fff;
}

.bg-2 {
    background: linear-gradient(45deg, #11998e, #38ef7d);
    color: #fff;
}

.bg-3 {
    background: linear-gradient(45deg, #4e54c8, #8f94fb);
    color: #fff;
}

.bg-4 {
    background: linear-gradient(45deg, #fc4a1a, #f7b733);
    color: #fff;
}

.bg-5 {
    background: linear-gradient(45deg, #232526, #414345);
    color: #fff;
}

/* QR box */
.qr-box {
    text-align: center;
}

.qr-box img {
    border-radius: 12px;
    padding: 10px;
    background: #fff;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .08);
}
</style>

<div class="main-content app-content">
    <div class="container-fluid">

        <!-- ===== PAGE HEADER ===== -->
        <div class="d-flex justify-content-between align-items-center my-4 flex-wrap gap-2">
            <div>
                <h4 class="mb-1">Hi, {{ \Auth::user()->full_name }} 👋</h4>
                <p class="text-muted mb-0">
                    Welcome back! Here’s an overview of your business performance for this month.
                </p>
            </div>
        </div>
        @if (Auth::user()->roles->contains('title', 'Admin'))
        <!-- ===== KPI CARDS ===== -->
        <div class="row mb-4">

            <!-- TOTAL MERCHANT -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-1">
                    <div class="widget-content-wrapper">
                        <div>
                            <div class="widget-heading">
                                <i class="fas fa-store me-2"></i>Total Merchants
                            </div>
                            <div class="widget-subheading">Active partners</div>
                        </div>
                        <div class="widget-numbers">
                            {{ $totalMerchants ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOTAL USERS -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-2">
                    <div class="widget-content-wrapper">
                        <div>
                            <div class="widget-heading">
                                <i class="fas fa-users me-2"></i>Total Users
                            </div>
                            <div class="widget-subheading">Registered customers</div>
                        </div>
                        <div class="widget-numbers">
                            {{ $totalUsers ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ TOTAL ORDERS (NEW) -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-3">
                    <div class="widget-content-wrapper">
                        <div>
                            <div class="widget-heading">
                                <i class="fas fa-shopping-cart me-2"></i>Total Orders
                            </div>
                            <div class="widget-subheading">Orders placed</div>
                        </div>
                        <div class="widget-numbers">
                            {{ $totalOrders ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
            @else

            <style>
            .student-wrapper {
                margin-top:-20px !important;
                min-height: 85vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f4f6f9;
                padding: 5px 15px;
            }

            /* ===== ID CARD ===== */
            .student-id-card {
                width: 650px;
                height: 380px;
                border-radius: 20px;
                padding: 30px;
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, #6cc1b9, #7fd1c6);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                color: #0d3b3a;
            }

            /* subtle pattern effect */
            .student-id-card::before {
                content: "";
                position: absolute;
                width: 900px;
                height: 900px;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 2%, transparent 2%);
                background-size: 40px 40px;
                top: -200px;
                left: -200px;
                transform: rotate(20deg);
            }

            /* left section */
            .id-left {
                position: relative;
                z-index: 2;
                width: 60%;
            }

            .id-title {
                font-size: 36px;
                font-weight: 800;
                letter-spacing: 2px;
            }

            .id-subtitle {
                font-size: 14px;
                letter-spacing: 3px;
                margin-bottom: 25px;
            }

            .id-label {
                font-size: 13px;
                opacity: 0.8;
            }

            .id-value {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 15px;
            }

            /* right section */
            .id-right {
                position: absolute;
                right: 30px;
                top: 80px;
                text-align: center;
                z-index: 2;
            }

            .id-photo {
                width: 160px;
                height: 190px;
                border-radius: 12px;
                object-fit: cover;
                background: #2e9fa3;
                padding: 5px;
            }

            .id-phone {
                margin-top: 10px;
                font-weight: 600;
                letter-spacing: 2px;
                font-size: 14px;
            }
            </style>

            <div class="student-wrapper">

                <div class="student-id-card">

                    <!-- LEFT CONTENT -->
                    <div class="id-left">
                        <div class="id-title">STUDENT</div>
                        <div class="id-subtitle">IDENTITY CARD</div>

                        <div class="id-label">Studies at</div>
                        <div class="id-value">
                            {{ Auth::user()->school ?? 'INTERNATIONAL UNIVERSITY' }}
                        </div>

                        <div class="id-label">Name</div>
                        <div class="id-value">
                            {{ strtoupper(Auth::user()->full_name) }}
                        </div>

                        <div class="id-label">Age</div>
                        <div class="id-value">
                            {{ Auth::user()->age }} Years
                        </div>
                    </div>

                    <!-- RIGHT CONTENT -->
                    <div class="id-right">
                        <img src="{{ asset(Auth::user()->image ?? 'uploads/default.png') }}" class="id-photo"
                            alt="student photo">

                        <div class="id-phone">
                            {{ Auth::user()->phone_number }}
                        </div>
                    </div>

                </div>

            </div>

            @endif



        </div>



    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection