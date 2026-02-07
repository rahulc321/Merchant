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
                            {{ $totalMerchants ?? 128 }}
                        </div>
                    </div>
                </div>
            </div>

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
                            {{ $totalUsers ?? 4562 }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-3">
                    <div class="widget-content-wrapper">
                        <div>
                            <div class="widget-heading">
                                <i class="fas fa-rupee-sign me-2"></i>Monthly Revenue
                            </div>
                            <div class="widget-subheading">Current month sales</div>
                        </div>
                        <div class="widget-numbers">
                            ₹ {{ number_format($monthlyRevenue ?? 1245600) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-5">
                    <div class="widget-content-wrapper">
                        <div>
                            <div class="widget-heading">
                                <i class="fas fa-chart-line me-2"></i>Growth Rate
                            </div>
                            <div class="widget-subheading">Month over month</div>
                        </div>
                        <div class="widget-numbers">
                            +18%
                        </div>
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