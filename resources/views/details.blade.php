@extends('layouts.website')

@section('title', 'LMS - Details')

@section('content')

<main>

    ```
    <!-- Slider Area -->
    <section class="slider-area slider-area2">
        <div class="slider-active">
            <div class="single-slider slider-height2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-11 col-md-12">

                            <div class="hero__caption hero__caption2">

                                <h1 data-animation="bounceIn" data-delay="0.2s">
                                    Details
                                </h1>

                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="/">Home</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            Details
                                        </li>
                                    </ol>
                                </nav>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Merchant Details Section -->
    <section class="contact-section">
        <div class="container">

            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <!-- Success Message + Coupon -->
            @if(session('coupon_code'))
            <div
                style="border:2px dashed #28a745;padding:25px;text-align:center;margin-bottom:30px;background:#f9fff9;border-radius:10px">

                <h3 style="color:#28a745">🎉 Coupon Unlocked Successfully!</h3>

                <h2 style="letter-spacing:4px;margin-top:10px">
                    {{ session('coupon_code') }}
                </h2>

                <p style="margin-top:10px">
                    Use this coupon at <strong>{{ $details->full_name }}</strong>
                </p>

            </div>
            @endif


            <div class="row">

                <!-- Merchant Image -->
                <div class="col-lg-5">

                    <img src="{{ asset('uploads/'.$details->image) }}" style="width:100%;border-radius:10px">

                </div>


                <!-- Merchant Details -->
                <div class="col-lg-7">

                    <h2 class="contact-title">
                        {{ $details->full_name }}
                    </h2>


                    <p>
                        <strong>Category :</strong>
                        {{ ucfirst($details->category) }}
                    </p>


                    <p>
                        <strong>Discount :</strong>
                        <span style="color:green;font-weight:bold">
                            {{ $details->discount }}%
                        </span>
                    </p>


                    <p>
                        <strong>Email :</strong>
                        {{ $details->email }}
                    </p>


                    <p>
                        <strong>Phone :</strong>
                        {{ $details->phone_number }}
                    </p>


                    <p>
                        <strong>City :</strong>
                        {{ $details->city }}
                    </p>


                    <p>
                        <strong>Address :</strong>
                        {{ $details->address }}
                    </p>


                    <p>
                        <strong>Description :</strong>
                    </p>

                    <p>
                        {{ $details->description }}
                    </p>


                    <br>


                    <!-- Unlock Coupon Button -->
                    @if(!session('coupon_code'))

                    <form action="{{ route('unlockCoupon',$details->id) }}" method="POST">
                        @csrf

                        <button class="btn btn-success btn-lg">

                            🔓 Unlock {{ $details->discount }}% Coupon

                        </button>

                    </form>

                    @endif


                </div>

            </div>

        </div>
    </section>
    ```

</main>

@endsection