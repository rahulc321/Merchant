@extends('layouts.website')

@section('title', 'Discover Restaurants Near You')

@section('content')

<main>

    <!-- Hero Section -->
    <section class="slider-area">
        <div class="slider-active">
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-7 col-md-12">
                            <div class="hero__caption">
                                <h1 data-animation="fadeInLeft" data-delay="0.2s">
                                    Discover the Best Food<br>Near You
                                </h1>
                                <p data-animation="fadeInLeft" data-delay="0.4s">
                                    Order from top restaurants like KFC, Cafe Coffee Day, Domino’s and more.
                                    Fast delivery, great taste, best deals.
                                </p>
                                <a href="#" class="btn hero-btn" data-animation="fadeInLeft" data-delay="0.7s">
                                    Order Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <div class="services-area">
        <div class="container">
            <div class="row justify-content-sm-center">

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services mb-30">
                        <div class="features-icon">
                            <img src="./assets_new/img/icon/icon1.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <h3>1000+ Restaurants</h3>
                            <p>Choose from popular food chains and local restaurants.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services mb-30">
                        <div class="features-icon">
                            <img src="./assets_new/img/icon/icon2.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <h3>Fast Delivery</h3>
                            <p>Hot and fresh food delivered right to your doorstep.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services mb-30">
                        <div class="features-icon">
                            <img src="./assets_new/img/icon/icon3.svg" alt="">
                        </div>
                        <div class="features-caption">
                            <h3>Best Deals</h3>
                            <p>Exclusive discounts and combo offers every day.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Popular Restaurants -->
    <div class="courses-area section-padding40 fix">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Popular Restaurants</h2>
                    </div>
                </div>
            </div>

            <div class="courses-actives">

                <!-- Restaurant Card -->
                <div class="properties pb-20">
                    <div class="properties__card">
                        <div class="properties__img overlay1">
                            <img src="./assets_new/img/gallery/featured1.png" alt="">
                        </div>
                        <div class="properties__caption">
                            <p>Fast Food</p>
                            <h3>KFC</h3>
                            <p>Crispy fried chicken, burgers and combo meals loved by millions.</p>
                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                <div>
                                    <p><span>⭐ 4.5</span> (2k+ ratings)</p>
                                </div>
                                <div class="price">
                                    <span>30-40 min</span>
                                </div>
                            </div>
                            <a href="#" class="border-btn border-btn2">View Menu</a>
                        </div>
                    </div>
                </div>

                <div class="properties pb-20">
                    <div class="properties__card">
                        <div class="properties__img overlay1">
                            <img src="./assets_new/img/gallery/featured2.png" alt="">
                        </div>
                        <div class="properties__caption">
                            <p>Cafe</p>
                            <h3>Cafe Coffee Day</h3>
                            <p>Freshly brewed coffee, snacks and desserts.</p>
                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                <div>
                                    <p><span>⭐ 4.4</span> (1.5k+ ratings)</p>
                                </div>
                                <div class="price">
                                    <span>25-35 min</span>
                                </div>
                            </div>
                            <a href="#" class="border-btn border-btn2">View Menu</a>
                        </div>
                    </div>
                </div>

                <div class="properties pb-20">
                    <div class="properties__card">
                        <div class="properties__img overlay1">
                            <img src="./assets_new/img/gallery/featured3.png" alt="">
                        </div>
                        <div class="properties__caption">
                            <p>Pizza</p>
                            <h3>Domino’s Pizza</h3>
                            <p>Delicious pizzas, sides and desserts delivered fast.</p>
                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                <div>
                                    <p><span>⭐ 4.6</span> (3k+ ratings)</p>
                                </div>
                                <div class="price">
                                    <span>20-30 min</span>
                                </div>
                            </div>
                            <a href="#" class="border-btn border-btn2">View Menu</a>
                        </div>
                    </div>
                </div>

                <div class="properties pb-20">
                    <div class="properties__card">
                        <div class="properties__img overlay1">
                            <img src="./assets_new/img/gallery/featured2.png" alt="">
                        </div>
                        <div class="properties__caption">
                            <p>Burgers</p>
                            <h3>Burger King</h3>
                            <p>Flame-grilled burgers with bold flavors.</p>
                            <div class="properties__footer d-flex justify-content-between align-items-center">
                                <div>
                                    <p><span>⭐ 4.3</span> (1.8k+ ratings)</p>
                                </div>
                                <div class="price">
                                    <span>30-40 min</span>
                                </div>
                            </div>
                            <a href="#" class="border-btn border-btn2">View Menu</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Browse Categories -->
    <div class="topic-area section-padding40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Browse by Food Category</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🍔 Burgers</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🍕 Pizza</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>☕ Coffee</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🍗 Chicken</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🥗 Healthy</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🧁 Desserts</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🥡 Chinese</h4></div>
                <div class="col-lg-3 col-md-4 col-sm-6"><h4>🌮 Street Food</h4></div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <section class="about-area2 fix pb-padding">
        <div class="support-wrapper align-items-center">
            <div class="left-content2">
                <div class="section-tittle section-tittle2 mb-20">
                    <div class="front-text">
                        <h2>Hungry? Order Your Favorite Food Now!</h2>
                        <p>Explore restaurants near you and get delicious food delivered fast.</p>
                        <a href="#" class="btn">Order Now</a>
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
