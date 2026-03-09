@extends('layouts.website')

@section('title','User Registration')

@section('content')

<style>
.header-area .header-bottom {
    padding: 0px 130px;
    background: linear-gradient(to bottom, #c054ff 0%, #5274ff 100%);
}
</style>

<main>

    <section style="margin-top:200px;margin-bottom:230px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="card shadow p-4">

                        <h3 class="text-center mb-4">Register Account</h3>

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- ROLE SELECT -->
                        <div class="form-group mb-4">
                            <label>Select Role</label>
                            <select id="roleSelect" class="form-control">
                                <option value="">Select Role</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="youth">Youth</option>
                            </select>
                        </div>


                        <!-- ================= STUDENT FORM ================= -->

                        <form id="studentForm" method="POST" action="{{route('studentRegister')}}"
                            enctype="multipart/form-data" style="display:none;">
                            @csrf

                            <input type="hidden" name="role" value="student">

                            <h5 class="mb-3">Student Registration</h5>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>School</label>
                                    <input type="text" name="school" class="form-control" placeholder="School">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Age</label>
                                    <input type="number" name="age" id="ageInput" class="form-control"
                                        placeholder="Age">
                                </div>

                                <div class="col-md-6 mb-3" id="parentEmailGroup" style="display:none;">
                                    <label>Parent Email</label>
                                    <input type="email" name="parent_email" class="form-control"
                                        placeholder="Parent Email">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Profile Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary w-100">Register Student</button>

                        </form>



                        <!-- ================= TEACHER FORM ================= -->

                        <form id="teacherForm" method="POST" action="{{route('studentRegister')}}"
                            enctype="multipart/form-data" style="display:none;">
                            @csrf

                            <input type="hidden" name="role" value="teacher">

                            <h5 class="mb-3">Teacher Registration</h5>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Department</label>
                                    <input type="text" name="department" class="form-control" placeholder="Department">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Subject">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Profile Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                            </div>

                            <button type="submit" class="btn btn-success w-100">Register Teacher</button>

                        </form>



                        <!-- ================= YOUTH FORM ================= -->

                        <form id="youthForm" method="POST" action="{{route('studentRegister')}}"
                            enctype="multipart/form-data" style="display:none;">
                            @csrf

                            <input type="hidden" name="role" value="youth">

                            <h5 class="mb-3">Youth Registration</h5>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Organization</label>
                                    <input type="text" name="organization" class="form-control"
                                        placeholder="Organization">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Profile Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                            </div>

                            <button type="submit" class="btn btn-warning w-100">Register Youth</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

</main>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    $('#roleSelect').change(function() {

        $('#studentForm').hide();
        $('#teacherForm').hide();
        $('#youthForm').hide();

        if ($(this).val() == 'student') {
            $('#studentForm').show();
        }

        if ($(this).val() == 'teacher') {
            $('#teacherForm').show();
        }

        if ($(this).val() == 'youth') {
            $('#youthForm').show();
        }

    });

    $('#ageInput').on('keyup change', function() {

        var age = $(this).val();

        if (age < 14) {
            $('#parentEmailGroup').show();
        } else {
            $('#parentEmailGroup').hide();
        }

    });

});
</script>

@endsection