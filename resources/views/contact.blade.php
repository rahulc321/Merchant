@extends('layouts.website')
@section('title', 'LMS - Contact Us')
@section('content')

<style>

/* ================= HERO ================= */

.contact-hero{
    background: linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:80px 40px;
    text-align:center;
}

.contact-hero h1{
    font-size:44px;
    font-weight:700;
}

/* ================= LAYOUT ================= */

.contact-container{
    max-width:1200px;
    margin:auto;
    padding:70px 20px;
}

.contact-wrapper{
    display:flex;
    gap:40px;
    align-items:stretch;
}

/* LEFT SIDE */

.contact-info{
    flex:1;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:50px;
    border-radius:16px;
}

.contact-info h2{
    margin-bottom:20px;
}

.info-box{
    margin-bottom:25px;
}

.info-box strong{
    display:block;
    margin-bottom:6px;
    font-size:18px;
}

/* RIGHT SIDE */

.contact-card{
    flex:1.3;
    background:white;
    padding:50px;
    border-radius:16px;
    box-shadow:0 10px 40px rgba(0,0,0,.06);
}

/* FORM */

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:500;
}

.form-control{
    width:100%;
    padding:14px;
    border-radius:8px;
    border:1px solid #ddd;
    transition:.3s;
}

.form-control:focus{
    outline:none;
    border-color:#667eea;
    box-shadow:0 0 0 3px rgba(102,126,234,.15);
}

textarea.form-control{
    min-height:130px;
}

/* BUTTON */

.submit-btn{
    border:none;
    padding:14px 28px;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    border-radius:8px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.submit-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(0,0,0,.15);
}

/* ALERTS */

.alert-success{
    background:#e6fffa;
    color:#065f46;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}

.alert-error{
    background:#ffe6e6;
    color:#7f1d1d;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
}

/* MOBILE */

@media(max-width:900px){

.contact-wrapper{
    flex-direction:column;
}

.contact-info,
.contact-card{
    padding:30px;
}

.contact-hero h1{
    font-size:32px;
}

}

</style>


<!-- HERO -->

<div class="contact-hero">
    <h1>Contact Us</h1>
    <p>We are here to help you. Reach out anytime.</p>
</div>



<div class="contact-container">

    <div class="contact-wrapper">

        <!-- LEFT SIDE ADDRESS -->

        <div class="contact-info">
            <h2>Get in Touch</h2>

            <div class="info-box">
                <strong>📍 Address</strong>
                123 Learning Street,<br>
                Education City,<br>
                India
            </div>

            <div class="info-box">
                <strong>📞 Phone</strong>
                +91 98765 43210
            </div>

            <div class="info-box">
                <strong>📧 Email</strong>
                support@lms.com
            </div>

            <div class="info-box">
                <strong>🕒 Working Hours</strong>
                Mon - Fri : 9 AM - 6 PM
            </div>
        </div>



        <!-- RIGHT SIDE FORM -->

        <div class="contact-card">

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('contactSubmit') }}">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text"
                           name="subject"
                           class="form-control"
                           value="{{ old('subject') }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message"
                              class="form-control"
                              required>{{ old('message') }}</textarea>
                </div>

                <button class="submit-btn">
                    Send Message
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
