@extends('layouts.website')

@section('title', 'User Dashboard')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
.header-area .header-bottom {
    padding: 0 130px;
    background: linear-gradient(to bottom, #c054ff 0%, #5274ff 100%);
}

.user-dashboard {
    min-height: 100vh;
    padding: 170px 16px 70px;
    background:
        linear-gradient(135deg, rgba(245, 248, 255, .96), rgba(255, 255, 255, .96)),
        url("{{ asset('assets_new/img/gallery/section_bg02.png') }}");
    background-size: cover;
}

.dashboard-shell {
    width: min(1120px, 100%);
    margin: 0 auto;
}

.dashboard-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.dashboard-topbar h1 {
    margin: 0 0 6px;
    color: #111827;
    font-size: clamp(26px, 3vw, 38px);
    font-weight: 800;
}

.dashboard-topbar p {
    margin: 0;
    color: #667085;
}

.dashboard-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.dashboard-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 15px;
    border-radius: 10px;
    font-weight: 800;
    text-decoration: none;
}

.dashboard-btn-primary {
    color: #fff;
    background: #111827;
}

.dashboard-btn-light {
    color: #111827;
    background: #fff;
    box-shadow: 0 12px 28px rgba(17, 24, 39, .08);
}

.dashboard-strip {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 24px;
}

.dashboard-alert {
    background: #e8fff4;
    color: #067647;
    border: 1px solid #b7f7d7;
    border-radius: 8px;
    padding: 13px 16px;
    margin-bottom: 18px;
    font-weight: 700;
}

.dashboard-metric {
    background: #fff;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 12px 28px rgba(17, 24, 39, .07);
}

.dashboard-metric span {
    display: block;
    color: #667085;
    font-size: 13px;
    margin-bottom: 5px;
}

.dashboard-metric strong {
    display: block;
    color: #111827;
    font-size: 18px;
    overflow-wrap: anywhere;
}

.dashboard-card-stage {
    padding: 28px;
    border-radius: 18px;
    background: rgba(255,255,255,.76);
    box-shadow: 0 20px 50px rgba(15, 23, 42, .08);
}

@media (max-width: 991px) {
    .header-area .header-bottom {
        padding: 0 20px;
    }
}

@media (max-width: 760px) {
    .user-dashboard {
        padding-top: 135px;
    }

    .dashboard-topbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .dashboard-strip {
        grid-template-columns: 1fr;
    }

    .dashboard-card-stage {
        padding: 12px;
        border-radius: 12px;
    }
}
</style>

<main class="user-dashboard">
    <div class="dashboard-shell">
        <div class="dashboard-topbar">
            <div>
                <h1>Hi, {{ $user->full_name }}</h1>
                <p>Your dashboard and ID card are ready.</p>
            </div>
            <div class="dashboard-actions">
                <a class="dashboard-btn dashboard-btn-light" href="{{ route('admin.plans.browse') }}">
                    <i class="fa fa-layer-group"></i> Plans
                </a>
                <a class="dashboard-btn dashboard-btn-primary" href="{{ url('/logout') }}"
                    onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">
                    <i class="fa fa-right-from-bracket"></i> Logout
                </a>
                <form id="user-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="dashboard-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="dashboard-strip">
            <div class="dashboard-metric">
                <span>User Type</span>
                <strong>{{ ucfirst($user->type ?? optional($user->roles->first())->title ?? 'Normal') }}</strong>
            </div>
            <div class="dashboard-metric">
                <span>Subscription</span>
                <strong>
                    {{ $activeSubscription ? optional($activeSubscription->plan)->title : ($latestSubscription ? ucfirst($latestSubscription->status) : 'No active plan') }}
                </strong>
            </div>
            <div class="dashboard-metric">
                <span>Plan Expiry</span>
                <strong>{{ $activeSubscription && $activeSubscription->expires_at ? \Carbon\Carbon::parse($activeSubscription->expires_at)->format('d M Y') : 'N/A' }}</strong>
            </div>
        </div>

        <div class="dashboard-card-stage">
            @include('partials.user-id-card', ['user' => $user])
        </div>
    </div>
</main>
@endsection
