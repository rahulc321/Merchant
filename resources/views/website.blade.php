@extends('layouts.website')

@section('title', 'BlueTrain & tripesa Rewards')

@section('content')
@php
    $registerUrl = url('/user/register');
    $qrCode = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" . urlencode($registerUrl);
@endphp

<style>
    :root {
        --bt-navy: #061f3d;
        --bt-blue: #007cae;
        --bt-cyan: #29c5df;
        --bt-orange: #ff7a1a;
        --bt-gold: #f7b63d;
        --bt-sea: #e5f9ff;
        --bt-ink: #092442;
        --bt-muted: #526b84;
    }

    body {
        color: var(--bt-ink);
    }

    .header-area.header-transparent {
        background: rgba(6, 31, 61, .92);
        backdrop-filter: blur(14px);
    }

    .rewards-page {
        overflow: hidden;
        background: #f3fbff;
        font-family: "Nunito", "Segoe UI", Arial, sans-serif;
    }

    .rewards-section {
        padding: 92px 0;
        position: relative;
    }

    .section-label {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: var(--bt-blue);
        font-size: 13px;
        font-weight: 900;
        letter-spacing: 1.4px;
        margin-bottom: 14px;
        text-transform: uppercase;
    }

    .section-label:before {
        content: "";
        width: 34px;
        height: 3px;
        border-radius: 99px;
        background: linear-gradient(90deg, var(--bt-orange), var(--bt-cyan));
    }

    .rewards-title {
        color: var(--bt-navy);
        font-size: clamp(32px, 4vw, 54px);
        font-weight: 950;
        line-height: 1.03;
        letter-spacing: 0;
        margin-bottom: 20px;
    }

    .rewards-copy {
        color: var(--bt-muted);
        font-size: 18px;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .hero-rewards {
        min-height: 96vh;
        padding: 150px 0 76px;
        display: flex;
        align-items: center;
        background:
            linear-gradient(180deg, rgba(243, 251, 255, .18), #f3fbff 96%),
            radial-gradient(circle at 74% 28%, rgba(41, 197, 223, .55), transparent 30%),
            radial-gradient(circle at 18% 24%, rgba(0, 124, 174, .16), transparent 28%),
            linear-gradient(135deg, #eefbff 0%, #d8f6ff 46%, #f8fdff 100%);
    }

    .hero-rewards:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(118deg, rgba(255,255,255,.82) 0 34%, transparent 34% 100%),
            repeating-linear-gradient(0deg, transparent 0 37px, rgba(0, 124, 174, .055) 38px);
        pointer-events: none;
    }

    .hero-rewards .container {
        position: relative;
        z-index: 2;
    }

    .brand-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .brand-pill {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 10px 16px;
        border: 1px solid rgba(0, 124, 174, .18);
        border-radius: 8px;
        background: rgba(255,255,255,.78);
        box-shadow: 0 16px 32px rgba(8, 33, 63, .08);
        color: var(--bt-navy);
        font-weight: 950;
        font-size: 18px;
    }

    .brand-icon {
        width: 34px;
        height: 34px;
        display: inline-grid;
        place-items: center;
        border-radius: 8px;
        color: #fff;
        background: linear-gradient(135deg, var(--bt-blue), var(--bt-cyan));
    }

    .hero-rewards h1 {
        color: var(--bt-navy);
        font-size: clamp(40px, 6vw, 78px);
        font-weight: 950;
        line-height: .98;
        letter-spacing: 0;
        margin-bottom: 22px;
    }

    .hero-rewards h1 span {
        color: var(--bt-blue);
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        margin-top: 34px;
    }

    .reward-btn,
    .reward-btn:hover {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 56px;
        padding: 0 26px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--bt-orange), #ff9e22);
        color: #fff;
        font-weight: 900;
        box-shadow: 0 18px 36px rgba(255, 122, 26, .34);
        text-decoration: none;
    }

    .outline-btn,
    .outline-btn:hover {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 56px;
        padding: 0 24px;
        border-radius: 8px;
        border: 1px solid rgba(0, 124, 174, .28);
        background: rgba(255,255,255,.72);
        color: var(--bt-navy);
        font-weight: 900;
        text-decoration: none;
    }

    .hero-showcase {
        position: relative;
        min-height: 590px;
    }

    .poster-frame {
        position: absolute;
        top: 0;
        right: 0;
        width: min(410px, 82vw);
        padding: 14px;
        border-radius: 8px;
        background: rgba(255,255,255,.74);
        box-shadow: 0 28px 70px rgba(8, 33, 63, .18);
        transform: rotate(2deg);
    }

    .poster-frame img {
        width: 100%;
        display: block;
        border-radius: 6px;
    }

    .phone-wallet {
        position: absolute;
        left: 2%;
        bottom: 58px;
        width: 260px;
        padding: 18px 16px 24px;
        border-radius: 36px;
        background: linear-gradient(160deg, #06172d, #0b3d67 58%, #063051);
        border: 8px solid #111827;
        box-shadow: 0 28px 54px rgba(8, 33, 63, .28);
        color: #fff;
        z-index: 3;
    }

    .phone-wallet:before {
        content: "";
        display: block;
        width: 90px;
        height: 15px;
        margin: 0 auto 30px;
        border-radius: 0 0 14px 14px;
        background: #111827;
    }

    .wallet-glow {
        border: 1px solid rgba(88, 216, 238, .56);
        border-radius: 8px;
        padding: 26px 16px;
        text-align: center;
        box-shadow: inset 0 0 35px rgba(88, 216, 238, .24), 0 0 34px rgba(88, 216, 238, .24);
    }

    .wallet-glow i {
        color: var(--bt-gold);
        font-size: 34px;
        display: block;
        margin-bottom: 16px;
    }

    .wallet-glow strong {
        display: block;
        font-size: 28px;
        line-height: 1.05;
    }

    .route-ribbon {
        position: absolute;
        left: 8%;
        right: 4%;
        bottom: 14px;
        min-height: 92px;
        border-radius: 8px;
        background: linear-gradient(90deg, rgba(0, 124, 174, .18), rgba(41, 197, 223, .2), rgba(255, 122, 26, .13));
        border: 1px solid rgba(0, 124, 174, .18);
    }

    .route-ribbon:before,
    .route-ribbon:after {
        content: "";
        position: absolute;
        top: 43px;
        left: 26px;
        right: 26px;
        height: 4px;
        border-radius: 99px;
        background: linear-gradient(90deg, var(--bt-blue), var(--bt-cyan), var(--bt-orange));
    }

    .route-ribbon:after {
        top: 55px;
        opacity: .4;
    }

    .transport-chip {
        position: absolute;
        z-index: 4;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 8px;
        background: #fff;
        color: var(--bt-navy);
        font-weight: 900;
        box-shadow: 0 14px 30px rgba(8, 33, 63, .14);
    }

    .transport-chip i {
        color: var(--bt-blue);
        font-size: 22px;
    }

    .train-chip {
        left: 18%;
        bottom: 90px;
    }

    .ferry-chip {
        right: 8%;
        bottom: 70px;
    }

    .stat-card {
        height: 100%;
        padding: 30px 24px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 18px 42px rgba(8, 33, 63, .08);
        border: 1px solid rgba(0, 124, 174, .12);
    }

    .stat-card i {
        width: 58px;
        height: 58px;
        display: inline-grid;
        place-items: center;
        margin-bottom: 18px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(88, 216, 238, .18), rgba(255, 122, 26, .16));
        color: var(--bt-blue);
        font-size: 25px;
    }

    .stat-card h3 {
        color: var(--bt-navy);
        font-size: 36px;
        font-weight: 950;
        margin-bottom: 8px;
    }

    .stat-card h4,
    .route-card h4,
    .step-card h4,
    .partner-card h4 {
        color: var(--bt-navy);
        font-weight: 900;
        margin-bottom: 10px;
    }

    .stat-card p,
    .route-card p,
    .step-card p,
    .partner-card p {
        color: var(--bt-muted);
        line-height: 1.65;
        margin-bottom: 0;
    }

    .journey-band {
        background:
            linear-gradient(180deg, rgba(8, 33, 63, .86), rgba(8, 33, 63, .82)),
            url("{{ asset('uploads/bluetrain-tripesa-rewards.jpeg') }}") center/cover;
        color: #fff;
    }

    .journey-band .rewards-title,
    .journey-band .rewards-copy,
    .journey-band .section-label {
        color: #fff;
    }

    .journey-band .section-label:before {
        background: var(--bt-orange);
    }

    .route-card {
        height: 100%;
        padding: 30px;
        border-radius: 8px;
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(255,255,255,.28);
        box-shadow: 0 20px 44px rgba(0, 0, 0, .16);
    }

    .route-card i {
        color: var(--bt-orange);
        font-size: 38px;
        margin-bottom: 20px;
    }

    .wallet-section {
        background:
            radial-gradient(circle at 13% 20%, rgba(255, 184, 69, .18), transparent 23%),
            linear-gradient(180deg, #f7fdff, #eefbff);
    }

    .wallet-panel {
        position: relative;
        min-height: 430px;
        border-radius: 8px;
        background: linear-gradient(135deg, #061f3d, #006f9d 58%, #0a95bd);
        box-shadow: 0 26px 60px rgba(8, 33, 63, .22);
        overflow: hidden;
    }

    .wallet-panel:before {
        content: "";
        position: absolute;
        inset: 42px 38px;
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 8px;
    }

    .reward-line {
        position: absolute;
        left: 7%;
        right: 7%;
        height: 3px;
        border-radius: 99px;
        background: linear-gradient(90deg, transparent, var(--bt-cyan), var(--bt-gold), transparent);
        box-shadow: 0 0 22px rgba(88, 216, 238, .72);
    }

    .line-one { top: 27%; }
    .line-two { top: 47%; }
    .line-three { top: 67%; }

    .floating-reward {
        position: absolute;
        width: 88px;
        height: 88px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: rgba(255,255,255,.96);
        color: var(--bt-orange);
        font-size: 32px;
        box-shadow: 0 18px 34px rgba(0,0,0,.16);
    }

    .floating-reward:nth-child(4) { left: 15%; top: 18%; }
    .floating-reward:nth-child(5) { right: 16%; top: 36%; color: var(--bt-blue); }
    .floating-reward:nth-child(6) { left: 36%; bottom: 16%; color: var(--bt-gold); }

    .feature-list {
        display: grid;
        gap: 18px;
        margin-top: 28px;
    }

    .feature-list li {
        list-style: none;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        color: var(--bt-muted);
        font-size: 16px;
        line-height: 1.6;
    }

    .feature-list i {
        flex: 0 0 30px;
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: rgba(0, 124, 174, .1);
        color: var(--bt-blue);
        margin-top: 2px;
    }

    .steps-wrap {
        position: relative;
    }

    .steps-wrap:before {
        content: "";
        position: absolute;
        left: 10%;
        right: 10%;
        top: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--bt-blue), var(--bt-cyan), var(--bt-orange));
        opacity: .32;
    }

    .step-card {
        position: relative;
        height: 100%;
        padding: 30px 24px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 16px 38px rgba(8, 33, 63, .08);
        border: 1px solid rgba(13, 136, 191, .1);
    }

    .step-number {
        width: 52px;
        height: 52px;
        display: grid;
        place-items: center;
        margin-bottom: 22px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--bt-blue), var(--bt-cyan));
        color: #fff;
        font-weight: 950;
        font-size: 20px;
        box-shadow: 0 12px 26px rgba(0, 124, 174, .28);
    }

    .partners-section {
        background: #fff;
    }

    .partner-card {
        height: 100%;
        overflow: hidden;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 16px 38px rgba(8, 33, 63, .08);
        border: 1px solid rgba(0, 124, 174, .12);
    }

    .partner-photo {
        min-height: 180px;
        display: flex;
        align-items: flex-end;
        padding: 20px;
        color: #fff;
        background:
            linear-gradient(180deg, transparent, rgba(8, 33, 63, .78)),
            var(--partner-bg);
        background-size: cover;
        background-position: center;
    }

    .partner-photo span {
        display: inline-flex;
        padding: 8px 12px;
        border-radius: 8px;
        background: var(--bt-orange);
        font-weight: 900;
        font-size: 15px;
    }

    .partner-card-body {
        padding: 26px;
    }

    .cta-panel {
        padding: 44px;
        border-radius: 8px;
        color: #fff;
        background:
            radial-gradient(circle at 80% 10%, rgba(255,255,255,.18), transparent 22%),
            linear-gradient(135deg, var(--bt-navy), #075f8c 58%, var(--bt-blue));
        box-shadow: 0 28px 64px rgba(8, 33, 63, .24);
    }

    .cta-panel h2 {
        color: #fff;
        font-size: clamp(30px, 4vw, 48px);
        font-weight: 950;
        margin-bottom: 14px;
    }

    .cta-panel p {
        color: rgba(255,255,255,.82);
        font-size: 18px;
        line-height: 1.7;
        margin-bottom: 0;
    }

    .qr-card {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border-radius: 8px;
        background: #fff;
        color: var(--bt-navy);
        font-weight: 900;
        box-shadow: 0 18px 34px rgba(0,0,0,.16);
    }

    .qr-card img {
        width: 140px;
        height: 140px;
    }

    @media (max-width: 991px) {
        .hero-rewards {
            min-height: auto;
            padding-top: 130px;
        }

        .hero-showcase {
            margin-top: 44px;
            min-height: 620px;
        }

        .poster-frame {
            left: 50%;
            right: auto;
            transform: translateX(-50%) rotate(1deg);
        }

        .phone-wallet {
            left: 0;
        }

        .steps-wrap:before {
            display: none;
        }
    }

    @media (max-width: 575px) {
        .rewards-section {
            padding: 70px 0;
        }

        .hero-rewards {
            padding-top: 118px;
        }

        .hero-actions a {
            width: 100%;
            justify-content: center;
        }

        .hero-showcase {
            min-height: 560px;
        }

        .phone-wallet {
            width: 220px;
            bottom: 48px;
        }

        .poster-frame {
            width: 86vw;
        }

        .transport-chip {
            font-size: 13px;
            padding: 10px 12px;
        }

        .train-chip {
            left: 4%;
        }

        .ferry-chip {
            right: 0;
        }

        .cta-panel {
            padding: 30px 22px;
        }
    }
</style>

<main class="rewards-page">
    <section class="hero-rewards rewards-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="brand-row">
                        <span class="brand-pill"><span class="brand-icon"><i class="fas fa-train"></i></span> BLUETRAIN</span>
                        <span class="brand-pill"><span class="brand-icon"><i class="fas fa-wallet"></i></span> tripesa Rewards</span>
                    </div>
                    <h1>Travel smart, <span>earn rewards.</span></h1>
                    <p class="rewards-copy">
                        Exclusive rewards for TAIFA and ZAN FAST FERRY travelers. Book train and ferry trips,
                        collect cashback, unlock partner discounts, and track every benefit in your digital wallet.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ url('/user/register') }}" class="reward-btn"><i class="fas fa-bolt"></i> Register & Access Rewards</a>
                        <a href="#how-it-works" class="outline-btn"><i class="fas fa-route"></i> See How It Works</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-showcase">
                        <div class="poster-frame">
                            <img src="{{ asset('uploads/bluetrain-tripesa-rewards.jpeg') }}" alt="BlueTrain and tripesa Rewards campaign">
                        </div>
                        <div class="phone-wallet">
                            <div class="wallet-glow">
                                <i class="fas fa-bolt"></i>
                                <strong>Digital<br>Wallet</strong>
                            </div>
                        </div>
                        <div class="route-ribbon"></div>
                        <span class="transport-chip train-chip"><i class="fas fa-train"></i> Train bookings</span>
                        <span class="transport-chip ferry-chip"><i class="fas fa-ship"></i> Ferry bookings</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rewards-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="section-label">Rewards Snapshot</span>
                    <h2 class="rewards-title">One rewards journey across rail, ferry, wallet, and shopping.</h2>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-coins"></i>
                        <h3>1%</h3>
                        <h4>Cashback on bookings</h4>
                        <p>Earn cashback on eligible BlueTrain and ferry bookings, then keep track inside your rewards wallet.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-tags"></i>
                        <h3>20%</h3>
                        <h4>Partner retail offers</h4>
                        <p>Access up to 20% off at selected partners including LC Waikiki, Defacto, and more campaign retailers.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="stat-card">
                        <i class="fas fa-mobile-alt"></i>
                        <h3>24/7</h3>
                        <h4>Digital wallet access</h4>
                        <p>Instantly check rewards, offer status, and travel-linked benefits from your phone wherever you are.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="journey-band rewards-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <span class="section-label">Connected Travel</span>
                    <h2 class="rewards-title">Built for travelers moving between city, coast, and island.</h2>
                    <p class="rewards-copy">
                        The campaign connects train and ferry travelers with a single rewards experience, designed for
                        smoother bookings and more value after every trip.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="route-card">
                                <i class="fas fa-train"></i>
                                <h4>BlueTrain Benefits</h4>
                                <p>Book your rail journey, earn rewards, and keep travel savings visible from one simple account.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="route-card">
                                <i class="fas fa-ship"></i>
                                <h4>ZAN Fast Ferry Benefits</h4>
                                <p>Use the same rewards logic for ferry travelers with instant wallet visibility and campaign offers.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="route-card">
                                <i class="fas fa-map-marked-alt"></i>
                                <h4>TAIFA Traveler Access</h4>
                                <p>Designed for frequent travelers who need rewards that work across routes and travel modes.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="route-card">
                                <i class="fas fa-gift"></i>
                                <h4>Retail Perks</h4>
                                <p>Turn completed travel activity into partner discounts, shopping rewards, and cashback value.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wallet-section rewards-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="wallet-panel">
                        <span class="reward-line line-one"></span>
                        <span class="reward-line line-two"></span>
                        <span class="reward-line line-three"></span>
                        <span class="floating-reward"><i class="fas fa-sync-alt"></i></span>
                        <span class="floating-reward"><i class="fas fa-percent"></i></span>
                        <span class="floating-reward"><i class="fas fa-shopping-cart"></i></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="section-label">Digital Wallet</span>
                    <h2 class="rewards-title">A fast wallet experience for every reward you earn.</h2>
                    <p class="rewards-copy">
                        Travelers should never wonder where their reward went. The wallet experience makes cashback,
                        discounts, and partner access clear from the first booking.
                    </p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Track cashback from train and ferry bookings in one account.</li>
                        <li><i class="fas fa-check"></i> View eligible partner offers before shopping.</li>
                        <li><i class="fas fa-check"></i> Keep rewards accessible from mobile, tablet, or desktop.</li>
                        <li><i class="fas fa-check"></i> Register once through LMS Merchants and start earning.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="rewards-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="section-label">Simple Flow</span>
                    <h2 class="rewards-title">Register, travel, earn, and redeem with less friction.</h2>
                </div>
            </div>
            <div class="steps-wrap row mt-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4>Create Account</h4>
                        <p>Register at LMS Merchants and activate your rewards wallet in a few clicks.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4>Book Travel</h4>
                        <p>Use eligible BlueTrain or ZAN Fast Ferry bookings to qualify for campaign rewards.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4>Earn Cashback</h4>
                        <p>Collect 1% cashback on travel bookings and monitor it through your wallet.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4>Use Offers</h4>
                        <p>Redeem partner retailer discounts and keep earning as the campaign grows.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="partners-section rewards-section">
        <div class="container">
            <div class="row align-items-end mb-5">
                <div class="col-lg-7">
                    <span class="section-label">Partner Value</span>
                    <h2 class="rewards-title mb-lg-0">More reasons to choose every trip.</h2>
                </div>
                <div class="col-lg-5">
                    <p class="rewards-copy">The rewards page brings partner savings forward with lifestyle-led visuals and direct benefit language.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="partner-card">
                        <div class="partner-photo" style="--partner-bg:url('{{ asset('assets_new/img/gallery/topic1.png') }}')">
                            <span>Retail Deals</span>
                        </div>
                        <div class="partner-card-body">
                            <h4>Shop smarter after travel</h4>
                            <p>Use your campaign status to unlock savings from fashion and lifestyle partner retailers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="partner-card">
                        <div class="partner-photo" style="--partner-bg:url('{{ asset('assets_new/img/gallery/featured4.png') }}')">
                            <span>Cashback</span>
                        </div>
                        <div class="partner-card-body">
                            <h4>Rewards that keep moving</h4>
                            <p>Every eligible booking creates measurable cashback value directly linked to your account.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="partner-card">
                        <div class="partner-photo" style="--partner-bg:url('{{ asset('assets_new/img/gallery/screen.png') }}')">
                            <span>Wallet Access</span>
                        </div>
                        <div class="partner-card-body">
                            <h4>Check status anywhere</h4>
                            <p>Open your digital wallet from mobile and quickly review rewards, offers, and redemption details.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rewards-section pt-0">
        <div class="container">
            <div class="cta-panel">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h2>Ready to travel smart and earn rewards?</h2>
                        <p>Register now at lmsmerchants.co.tz, scan the QR code, or create your wallet from the LMS Merchants portal.</p>
                        <div class="hero-actions">
                            <a href="{{ url('/user/register') }}" class="reward-btn"><i class="fas fa-user-plus"></i> Register Now</a>
                            <a href="{{ url('/user/login') }}" class="outline-btn"><i class="fas fa-sign-in-alt"></i> User Login</a>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-right text-center">
                        <a class="qr-card" href="{{ url('/user/register') }}">
                            <img src="{{ $qrCode }}" alt="Register QR code">
                            Scan to register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
@parent
@endsection
