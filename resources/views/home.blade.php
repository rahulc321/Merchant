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

.referral-summary {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.referral-card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(4, 9, 20, 0.05);
}

.referral-card span {
    display: block;
    color: #6c757d;
    font-size: 13px;
    margin-bottom: 6px;
}

.referral-card strong {
    display: block;
    color: #111827;
    font-size: 24px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.referral-card-wide {
    grid-column: span 1;
}

.referral-link-text {
    font-size: 16px !important;
    line-height: 1.45;
}

.referral-copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 12px;
    border: 0;
    border-radius: 8px;
    padding: 9px 13px;
    color: #fff;
    background: #111827;
    font-weight: 700;
    cursor: pointer;
}

.referral-copy-btn:hover {
    background: #243041;
}

@media (max-width: 767px) {
    .referral-summary {
        grid-template-columns: 1fr;
    }
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
        
        @php
        $user = Auth::user();
        @endphp
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
            @elseif ($user->roles->contains('title','Student'))

            @include('partials.referral-summary', ['user' => $user])
            @include('partials.user-id-card', ['user' => $user])

            @elseif ($user->roles->contains('title','Teacher'))

            @include('partials.referral-summary', ['user' => $user])
            @include('partials.user-id-card', ['user' => $user])

            @elseif ($user->roles->contains('title','Youth'))

            @include('partials.referral-summary', ['user' => $user])
            @include('partials.user-id-card', ['user' => $user])

            @elseif (($user->type ?? '') === 'normal' || $user->roles->contains('title','Normal'))

            @include('partials.referral-summary', ['user' => $user])
            @include('partials.user-id-card', ['user' => $user])

            @else

            @include('partials.referral-summary', ['user' => $user])
            @include('partials.user-id-card', ['user' => $user])

            @endif



        </div>



    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection
