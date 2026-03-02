@extends('layouts.website')

@section('title', 'Online Learning Platform')

@section('content')

<main>

    <!-- ================= Hero Section ================= -->
    <section class="slider-area">
        <div class="slider-active">
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7 col-lg-8 col-md-12">
                            <div class="hero__caption">
                                <h1 data-animation="fadeInLeft" data-delay="0.2s">
                                    Upgrade Your Skills<br>With Online Courses
                                </h1>
                                <p data-animation="fadeInLeft" data-delay="0.4s">
                                    Learn programming, design, business, marketing and more from expert instructors.
                                    Study anytime, anywhere at your own pace.
                                </p>
                                <a href="{{ url('/courses') }}" class="btn hero-btn" data-animation="fadeInLeft"
                                    data-delay="0.7s">
                                    Explore Courses
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= Features Section ================= -->
    <div class="services-area section-padding30">
        <div class="container">
            <div class="row justify-content-sm-center">

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services text-center mb-30">
                        <div class="features-caption">
                            <h3>500+ Online Courses</h3>
                            <p>Access high-quality courses across multiple categories.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services text-center mb-30">
                        <div class="features-caption">
                            <h3>Expert Instructors</h3>
                            <p>Learn from industry professionals with real-world experience.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services text-center mb-30">
                        <div class="features-caption">
                            <h3>Certificates</h3>
                            <p>Earn certificates after successful course completion.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= Popular Courses ================= -->
    <div class="courses-area section-padding40 fix">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Popular Vendors</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                $merchants = \App\User::whereHas('roles', function ($query) {
                    $query->where('title', 'merchant');
                })
                ->orderBy('id', 'DESC')
                ->get();

                ?>
                @foreach($merchants as $merchant)
                <!-- Course 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="properties pb-20">
                        <div class="properties__card">
                            <div class="properties__img overlay1">
                                <img src="{{ asset('uploads/'.$merchant->image) }}" alt="">
                            </div>
                            <div class="properties__caption">
                                <p>{{ucfirst($merchant->category)}}</p>
                                <h3>{{ $merchant->full_name }}</h3>
                                <!-- <p>Learn HTML, CSS, JavaScript, PHP & Laravel from scratch.</p> -->
                                <div class="properties__footer d-flex justify-content-between align-items-center">
                                    <div>
                                        <p style="color:green">Discount : {{ $merchant->discount }}%</p>
                                    </div>
                                     
                                </div>
                                <a href="{{route('details',[$merchant->id])}}" class="border-btn border-btn2 disabled" style="opacity:0.7; cursor:not-allowed;">
    <i class="fas fa-lock me-2"></i> Unlock Discount
</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

               

               

            </div>
        </div>
    </div>

    <!-- ================= Browse Categories ================= -->
    <div class="topic-area section-padding40">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Browse by Category</h2>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>💻 Programming</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>🎨 Graphic Design</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>📊 Business</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>📱 Mobile Development</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>🧠 AI & Machine Learning</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>🌐 Web Development</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>📸 Photography</h4>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <h4>🗣 Communication Skills</h4>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= Call To Action ================= -->
    <section class="about-area2 fix pb-padding">
        <div class="support-wrapper align-items-center">
            <div class="left-content2">
                <div class="section-tittle section-tittle2 mb-20">
                    <div class="front-text">
                        <h2>Start Learning Today!</h2>
                        <p>Join thousands of students upgrading their skills daily.</p>
                        <a href="{{ url('/register') }}" class="btn">Get Started</a>
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