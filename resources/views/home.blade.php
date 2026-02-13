@extends('layouts.admin')

@section('title', 'LMS Merchant - Dashboard')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
html, body {
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
.bg-1 { background: linear-gradient(45deg, #1a2a6c, #1f3c88); color:#fff; }
.bg-2 { background: linear-gradient(45deg, #11998e, #38ef7d); color:#fff; }
.bg-3 { background: linear-gradient(45deg, #4e54c8, #8f94fb); color:#fff; }
.bg-4 { background: linear-gradient(45deg, #fc4a1a, #f7b733); color:#fff; }
.bg-5 { background: linear-gradient(45deg, #232526, #414345); color:#fff; }

/* QR box */
.qr-box{
    text-align:center;
}

.qr-box img{
    border-radius:12px;
    padding:10px;
    background:#fff;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
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

            <!-- ✅ QR REGISTER CARD -->
            <!-- QR REGISTER CARD -->
<div class="col-xl-3 col-md-6">
    <div class="card bg-5 qr-box">

        <div class="widget-heading mb-2">
            <i class="fas fa-qrcode me-2"></i>Register QR
        </div>

        @php
            $registerUrl = url('/user/register');
            $qrCode = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($registerUrl);
        @endphp

        <!-- Click image → open in new tab -->
        <a href="{{ $qrCode }}" target="_blank">
            <img src="{{ $qrCode }}" alt="Register QR" style="cursor:pointer;">
        </a>

        <!-- Download Button -->
        <div class="mt-3">
            <a href="{{ $qrCode }}" 
               download="register-qr.png" 
               class="btn btn-light btn-sm" target="_blank">
                <i class="fas fa-download me-1"></i> Download QR
            </a>
        </div>

        <div class="widget-subheading mt-2">
            Scan to Register
        </div>

    </div>
</div>


        </div>

        <!-- ===== BUSINESS OVERVIEW ===== -->
        <div class="row mt-4">

            <div class="col-xl-8">
                <div class="card">
                    <h5 class="mb-2">Business Overview</h5>
                    <p class="text-muted mb-1">
                        Your platform continues to grow steadily with increasing merchant participation
                        and consistent user engagement across all services.
                    </p>
                    <p class="text-muted mb-0">
                        Monthly revenue performance remains strong, supported by repeat customers
                        and expanding merchant offerings.
                    </p>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <h5 class="mb-2">Key Highlights</h5>
                    <ul class="text-muted mb-0">
                        <li>Merchant onboarding improved this month</li>
                        <li>User retention rate increased</li>
                        <li>Overall platform performance is stable</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection
