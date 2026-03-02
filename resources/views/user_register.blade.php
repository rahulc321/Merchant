@extends('layouts.website')

@section('title', 'Student Registration')

@section('content')

<main>

    <section class="student-register-section" style="margin-top:20px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

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
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @endif
                        <form method="POST" action="{{route('studentRegister')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input type="text" name="name" class="form-control" required placeholder="Student Name"> 
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required  >
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" required placeholder="Phone">
                                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="number" name="age" id="ageInput" class="form-control" required placeholder="Age">
                                        @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group d-none" id="parentEmailGroup">
                                        <label>Parent Email</label>
                                        <input type="email" name="parent_email" id="parentEmailInput"
                                            class="form-control" placeholder="Parent Email">
                                        @error('parent_email') <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Student Email</label>
                                        <input type="email" name="email" class="form-control" required placeholder="Student Email">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                   

                                    <div class="form-group">
                                        <label>School Name</label>
                                        <input type="text" name="school" class="form-control" required placeholder="School Name">
                                        @error('school') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Student Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" required>
                                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn-register">
                                    Register Now
                                </button>
                            </div>

                        </form>
                    </div>

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

@endsection


@section('scripts')
@parent
<script>
document.getElementById('ageInput').addEventListener('input', function() {

    let age = parseInt(this.value);
    let parentGroup = document.getElementById('parentEmailGroup');
    let parentInput = document.getElementById('parentEmailInput');

    if (age < 14 && age > 0) {
        parentGroup.classList.remove('d-none');
        parentInput.setAttribute('required', 'required');
    } else {
        parentGroup.classList.add('d-none');
        parentInput.removeAttribute('required');
        parentInput.value = '';
    }
});
</script>
@endsection