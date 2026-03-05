@extends('layouts.website')

@section('title', 'Student Registration')

@section('content')

<main>

    <section class="student-register-section" style="margin-top:20px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    @if(session('success'))

                    <!-- Success Card -->
                    <div class="register-card text-center">
                        <div class="register-header">
                            <h3 class="text-success">🎉 Registration Successful!</h3>
                            <p class="mt-3">{{ session('success') }}</p>

                            <a href="{{ url('/') }}" class="btn-register mt-3 d-inline-block">
                                Go to Home
                            </a>
                        </div>
                    </div>

                    @else

                    <!-- Registration Form Card -->
                    <div class="register-card">
                        <div class="register-header text-center">
                            <h3>Student Registration</h3>
                            <p>Create your learning account</p>
                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin-bottom:0;">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{route('studentRegister')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <!-- Left Column -->
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                            required placeholder="Student Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                            required placeholder="Phone">
                                    </div>

                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" name="age" id="ageInput" value="{{ old('age') }}"
                                            class="form-control" required placeholder="Age">
                                    </div>

                                    <div class="form-group" id="parentEmailGroup" style="display:none;">
                                        <label>Parent Email</label>
                                        <input type="email" name="parent_email" id="parentEmailInput"
                                            value="{{ old('parent_email') }}" class="form-control"
                                            placeholder="Parent Email">
                                    </div>

                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label>Student Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                            required placeholder="Student Email">
                                    </div>

                                    <div class="form-group">
                                        <label>School Name</label>
                                        <input type="text" name="school" value="{{ old('school') }}"
                                            class="form-control" required placeholder="School Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Student Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" required>
                                    </div>

                                </div>

                            </div>

                            <div class="text-center mt-4">

                                <button type="submit" class="btn-register">
                                    Register Now
                                </button>

                                <p class="mt-3 login-text">
                                    Already have an account?
                                    <a href="{{ url('/login') }}" class="login-link" style="color:black">Login</a>
                                </p>

                            </div>

                        </form>
                    </div>

                    @endif

                </div>
            </div>
        </div>
    </section>

</main>

<style>
.header-area .header-bottom {
    padding: 0px 130px;
    background: linear-gradient(to bottom, #c054ff 0%, #5274ff 100%);
}

.student-register-section {
    padding: 100px 0;
    background: #f4f6fb;
}

.register-card {
    background: #fff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
}

.register-header h3 {
    font-weight: 700;
    color: #2c3e50;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
    font-size: 14px;
}

.form-control {
    height: 48px;
    border-radius: 8px;
}

.btn-register {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border: none;
    padding: 12px 40px;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    transition: 0.3s;
}

.btn-register:hover {
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
    transform: translateY(-2px);
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const ageInput = document.getElementById('ageInput');
    const parentGroup = document.getElementById('parentEmailGroup');
    const parentInput = document.getElementById('parentEmailInput');

    function toggleParentEmail() {

        let age = Number(ageInput.value);

        if (age && age < 15) {
            parentGroup.style.display = 'block';
            parentInput.required = true;
        } else {
            parentGroup.style.display = 'none';
            parentInput.required = false;
            parentInput.value = '';
        }
    }

    ageInput.addEventListener('keyup', toggleParentEmail);
    ageInput.addEventListener('change', toggleParentEmail);

    // run on page load
    toggleParentEmail();

});
</script>
@endsection


@section('scripts')
@parent


@if(session('success'))
<script>
setTimeout(function() {
    window.location.href = "{{ url('/') }}";
}, 5000);
</script>
@endif

@endsection