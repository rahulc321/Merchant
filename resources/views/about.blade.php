@extends('layouts.website')

@section('title', 'About Our Company')

@section('content')

<main>

    <!-- HERO -->
    <section class="slider-area slider-area2">
        <div class="slider-active">
            <!-- Single Slider -->
            <div class="single-slider slider-height2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-11 col-md-12">
                            <div class="hero__caption hero__caption2">
                                <h1 data-animation="bounceIn" data-delay="0.2s">About us</h1>
                                <!-- breadcrumb Start-->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                                        <li class="breadcrumb-item"><a href="#">about</a></li>
                                    </ol>
                                </nav>
                                <!-- breadcrumb End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- WHO WE ARE -->
    <section style="padding:90px 0;">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h2 style="font-weight:800;margin-bottom:20px;">
                        Who We Are
                    </h2>

                    <p style="font-size:17px;color:#4b5563;">
                        We are a forward-thinking organization committed to delivering
                        excellence through innovation, reliability, and customer-focused
                        solutions.
                    </p>

                    <p style="font-size:17px;color:#4b5563;">
                        Since our beginning, our goal has been simple — create services
                        people can trust and experiences they can rely on. Today, we proudly
                        serve a growing community of customers and partners who believe in
                        quality as much as we do.
                    </p>
                </div>

                <div class="col-lg-6">
                    <img src="./assets_new/img/gallery/about3.png" class="img-fluid rounded shadow">
                </div>

            </div>
        </div>
    </section>



    <!-- STORY -->
    <section style="background:#f9fafb;padding:90px 0;">
        <div class="container text-center">

            <h2 style="font-weight:800;margin-bottom:25px;">
                Our Story
            </h2>

            <p style="max-width:800px;margin:auto;font-size:17px;color:#4b5563;">
                What started as a vision to redefine service standards has grown
                into a trusted brand recognized for its integrity and performance.
                Our journey has been driven by passion, strengthened by customer
                relationships, and guided by a commitment to continuous improvement.
            </p>

        </div>
    </section>



    <!-- MISSION VISION -->
    <section style="padding:90px 0;">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <div style="padding:40px;border-radius:14px;
                                box-shadow:0 10px 30px rgba(0,0,0,.05);">
                        <h3 style="font-weight:800;">Our Mission</h3>

                        <p style="color:#4b5563;">
                            To provide high-quality services that enhance everyday life
                            while maintaining the highest standards of professionalism,
                            transparency, and customer satisfaction.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div style="padding:40px;border-radius:14px;
                                box-shadow:0 10px 30px rgba(0,0,0,.05);">
                        <h3 style="font-weight:800;">Our Vision</h3>

                        <p style="color:#4b5563;">
                            To become a globally trusted brand known for excellence,
                            innovation, and long-term value creation.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- WHY CHOOSE US -->
    <section style="background:#f9fafb;padding:90px 0;">
        <div class="container text-center">

            <h2 style="font-weight:800;margin-bottom:50px;">
                What Sets Us Apart
            </h2>

            <div class="row">

                <div class="col-md-3">
                    <h4 style="font-weight:700;">Quality First</h4>
                    <p style="color:#6b7280;">
                        We never compromise on quality. Every service reflects
                        our dedication to excellence.
                    </p>
                </div>

                <div class="col-md-3">
                    <h4 style="font-weight:700;">Customer Commitment</h4>
                    <p style="color:#6b7280;">
                        Our customers are at the heart of everything we do.
                        Their trust drives our growth.
                    </p>
                </div>

                <div class="col-md-3">
                    <h4 style="font-weight:700;">Innovation Driven</h4>
                    <p style="color:#6b7280;">
                        We embrace modern solutions to deliver smarter and
                        more efficient experiences.
                    </p>
                </div>

                <div class="col-md-3">
                    <h4 style="font-weight:700;">Integrity</h4>
                    <p style="color:#6b7280;">
                        We believe lasting relationships are built on honesty,
                        accountability, and transparency.
                    </p>
                </div>

            </div>
        </div>
    </section>



    <!-- STATS -->
    <section style="padding:90px 0;">
        <div class="container text-center">

            <div class="row">

                <div class="col-md-3">
                    <h1 style="font-weight:900;">10K+</h1>
                    <p>Happy Customers</p>
                </div>

                <div class="col-md-3">
                    <h1 style="font-weight:900;">5K+</h1>
                    <p>Successful Deliveries</p>
                </div>

                <div class="col-md-3">
                    <h1 style="font-weight:900;">99%</h1>
                    <p>Customer Satisfaction</p>
                </div>

                <div class="col-md-3">
                    <h1 style="font-weight:900;">24/7</h1>
                    <p>Support</p>
                </div>

            </div>
        </div>
    </section>



    <!-- CTA -->
    <section style="
        background:linear-gradient(135deg,#111827,#1f2937);
        padding:100px 0;
        color:white;
        text-align:center;
    ">
        <div class="container">

            <h2 style="font-weight:800;">
                Join Thousands Who Trust Our Brand
            </h2>

            <p style="opacity:.9;">
                Experience the difference of a company built on quality,
                reliability, and customer success.
            </p>

            <a href="/register" class="btn btn-light btn-lg"
                style="margin-top:20px;border-radius:30px;padding:12px 30px;">
                Get Started
            </a>

        </div>
    </section>

</main>

@endsection