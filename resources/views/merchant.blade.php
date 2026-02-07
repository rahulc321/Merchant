@extends('layouts.website')
@section('title', 'Merchant Registration')

@section('content')

<style>
/* ===== Background ===== */
.merchant-bg {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

/* ===== Card ===== */
.merchant-card {
    background: #fff;
    border-radius: 18px;
    padding: 45px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
}

/* Heading */
.merchant-title {
    font-weight: 700;
    font-size: 32px;
}

/* Inputs */
.form-control {
    height: 52px;
    border-radius: 10px;
    border: 1px solid #e4e6ef;
    transition: .3s;
    font-size: 20px;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, .12);
}

/* Button */
.btn-merchant {
    height: 54px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    font-weight: 600;
    font-size: 18px;
    transition: .3s;
}

.btn-merchant:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, .4);
}

/* password toggle */
.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888;
}

/* login text */
.login-text a {
    color: #667eea;
    font-weight: 600;
}
</style>

<section class="slider-area slider-area2">
    <div class="slider-active">
        <!-- Single Slider -->
        <div class="single-slider slider-height2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-11 col-md-12">
                        <div class="hero__caption hero__caption2">
                            <h1 data-animation="bounceIn" data-delay="0.2s">Become a Merchant</h1>
                            <!-- breadcrumb Start-->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Become a Merchant</a></li>
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
<section class="merchant-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">

                <div class="merchant-card">

                    <div class="text-center mb-4">
                        <h2 class="merchant-title">Become a Merchant 🚀</h2>
                        <p class="text-muted">
                            Start selling today. Create your merchant account in seconds.
                        </p>
                    </div>


                    {{-- Errors --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <b>Please fix the following errors:</b>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif


                    

                    <form action="{{route('joinMerchant')}}" method="POST">
                        @csrf

                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    placeholder="John Doe" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                    placeholder="john@email.com" required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text">+255</span>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control"
                                        placeholder="712345678" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Amount</label>
                                <input type="number" name="amount" value="{{ old('amount') }}" class="form-control"
                                placeholder="1000" required>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3 position-relative">
                                <label>Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Minimum 6 characters" required>

                                <span class="password-toggle" onclick="togglePassword('password')">
                                    👁️
                                </span>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-4 position-relative">
                                <label>Confirm Password</label>
                                <input type="password" id="confirmPassword" name="password_confirmation"
                                    class="form-control" placeholder="Re-enter password" required>

                                <span class="password-toggle" onclick="togglePassword('confirmPassword')">
                                    👁️
                                </span>
                            </div>

                        </div>

                        <button class="btn-merchant w-100">
                            Register Now
                        </button>

                        <div class="text-center mt-4 login-text">
                            Already have an account?
                            <a href="/login">Login</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
function togglePassword(id) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>

@endsection