<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- google font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <?php error_reporting(0); ?>
    <style>
    * {
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
        -webkit-tap-highlight-color: transparent;
    }

    html,
    body {
        margin: 0;
        min-height: 100%;
    }

    body {
        background: linear-gradient(to right, #071217, #16292f, #071820);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
    }

    /* container */
    .auth-wrapper {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 16px;
        padding: 26px 22px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    /* 📱 mobile optimization */
    @media (max-width: 480px) {

        body {
            padding: 0;
            align-items: flex-start;
        }

        .auth-wrapper {
            max-width: 100%;
            min-height: 100vh;
            border-radius: 0;
            padding: 22px 16px;
        }

        .auth-header h1 {
            font-size: 20px;
        }

        .auth-header p {
            font-size: 13px;
        }
    }

    /* header */
    .auth-header {
        text-align: center;
        margin-bottom: 22px;
    }

    .auth-header h1 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #111827;
    }

    /* form */
    .form-group {
        margin-bottom: 14px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #374151;
    }

    /* inputs */
    .form-control {
        width: 100%;
        height: 48px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        font-size: 16px;
        /* prevents zoom on iPhone */
        outline: none;
    }

    /* fix select on iOS */
    select.form-control {
        appearance: none;
        background-color: #fff;
    }

    /* button */
    .btn-primary {
        width: 100%;
        height: 50px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 8px;
    }

    /* hidden */
    .d-none {
        display: none;
    }

    .error {
        font-size: 13px;
        color: #dc2626;
        margin-top: 6px;
    }

    /* amount text wrap fix */
    .amount {
        font-size: 14px;
        word-break: break-word;
    }

    .btn-primary {
        width: 100%;
        height: 52px;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
        transition: all .25s ease;
    }

    /* hover (desktop) */
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, .25);
    }

    /* tap effect (mobile) */
    .btn-primary:active {
        transform: scale(.98);
    }

    /* login text */
    .auth-alt {
        text-align: center;
        margin-top: 18px;
        font-size: 14px;
        color: #6b7280;
    }

    .auth-alt a {
        color: #4f46e5;
        font-weight: 600;
        text-decoration: none;
        margin-left: 4px;
    }

    .auth-alt a:hover {
        text-decoration: underline;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }

    .password-wrapper .toggle-password:hover {
        color: #000;
    }

    .phone-input {
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }

    .country-code {
        padding: 10px 14px;
        background: #f1f3f5;
        border-right: 1px solid #ced4da;
        font-weight: 500;
        color: #495057;
    }

    .phone-field {
        border: none !important;
        box-shadow: none !important;
    }

    .phone-field:focus {
        outline: none;
    }

    .form-control[type="file"] {
        height: auto;
        padding: 12px 14px;
        line-height: 1.3;
    }
    </style>
</head>

<body>

    <div class="auth-wrapper">
        <div class="auth-header">
            <h1>Create Account</h1>
            <p>2-step secure registration</p>
        </div>

        <form id="registerForm">
            @csrf

            {{-- STEP 1 --}}
            <div class="step step-1">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Full Name">
                    <div class="error" data-error="name"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="error" data-error="email"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control">
                    <div class="error" data-error="dob"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" class="form-control" accept="image/*">
                    <div class="error" data-error="profile_picture"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>

                    <div class="phone-input">
                        <span class="country-code">+255</span>

                        <input type="text" name="phone_number" class="form-control phone-field"
                            placeholder="Enter phone number" inputmode="numeric">
                    </div>

                    <div class="error" data-error="phone_number"></div>
                </div>


                <div class="form-group">
                    <label class="form-label">Password</label>

                    <div class="password-wrapper">
                        <input type="password" name="password" class="form-control password-field">
                        <i class="bi bi-eye toggle-password"></i>
                    </div>

                    <div class="error" data-error="password"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>

                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" class="form-control password-field">
                        <i class="bi bi-eye toggle-password"></i>
                    </div>
                </div>


                <button type="button" class="btn-primary" onclick="nextStep()">
                    Continue
                </button>
                <div class="auth-alt">
                    Already have an account?
                    <a href="{{ url('/user/login') }}">Sign in</a>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="step step-2 d-none">
                <div class="form-group">
                    <label class="form-label">Restaurant</label>
                    <select name="restaurant_id" id="restaurantSelect" class="form-control" onchange="fillAddress()">
                        <option value="">Select Restaurant</option>

                        @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" data-address='@json($restaurant->addresses)'
                            data-amount='{{$restaurant->amount}}'>
                            {{ $restaurant->full_name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="error" data-error="restaurant_id"></div>
                </div>

                <select name="address" id="addressInput" class="form-control"></select>
                <div class="error" data-error="address"></div>


                <div class="form-group">
                    <label class="form-label">Amount <i style="color:red" class="amount"></i></label>
                    <div class="amount"></div>
                    <input type="number" name="amount" class="form-control" placeholder="Amount">
                    <div class="error" data-error="amount"></div>
                </div>

                <!-- <div class="form-group">
                    <label class="form-label">Cashier Verification Code</label>
                    <input type="text" name="cashier_code" class="form-control" placeholder="Cashier Verification Code">
                    <div class="error" data-error="cashier_code"></div>
                </div> -->
                
                <input type="hidden" id="address_id" name="address_id">
                <button type="button" class="btn-primary" onclick="submitForm()">
                    Register
                </button>


            </div>
        </form>
    </div>

    <script>
    function fillAddress() {
        let select = document.getElementById('restaurantSelect');
        let addressSelect = document.getElementById('addressInput');
        const amountBox = document.querySelector('.amount');

        addressSelect.innerHTML = '<option value="">Select Address</option>';


        let addresses = select.options[select.selectedIndex].getAttribute('data-address');

        const amount = select.options[select.selectedIndex].getAttribute('data-amount');

        amountBox.innerHTML = `
            <i style="margin-bottom:6px;font-size:14px;color:#2563eb;">
                Merchant Amount: <strong>${amount}</strong>
            </i>
        `;

        if (!addresses) return;

        addresses = JSON.parse(addresses);

        addresses.forEach(addr => {
            let option = document.createElement('option');

            option.value = `${addr.address}, ${addr.city}, ${addr.state} ${addr.pincode}`;

            option.text = `${addr.address}, ${addr.city}, ${addr.state} ${addr.pincode}`;

            option.dataset.city = addr.city || '';
            option.dataset.state = addr.state || '';
            option.dataset.pincode = addr.pincode || '';
            option.dataset.addressId = addr.id || '';

            addressSelect.appendChild(option);
        });
    }


    function clearErrors() {
        document.querySelectorAll('.error').forEach(el => el.innerText = '');
    }

    function showErrors(errors) {
        Object.keys(errors).forEach(key => {
            let el = document.querySelector('[data-error="' + key + '"]');
            if (el) el.innerText = errors[key][0];
        });
    }

    function nextStep() {

        clearErrors();
        let form = document.getElementById('registerForm');
        let data = new FormData(form);
        data.append('step', 1);

        fetch("{{ route('registerStep') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: data
            })
            .then(res => {
                if (!res.ok) throw res;
                return res.json();
            })
            .then(() => {
                document.querySelector('.step-1').classList.add('d-none');
                document.querySelector('.step-2').classList.remove('d-none');
            })
            .catch(async err => {
                let response = await err.json();
                showErrors(response.errors);
            });
    }

    function submitForm() {
        clearErrors();

        let form = document.getElementById('registerForm');
        let data = new FormData(form);
        data.append('step', 2);

        // 1️⃣ SAVE STEP-2 IN SESSION
        fetch("{{ route('registerStep') }}", {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: data
            })
            .then(res => {
                if (!res.ok) throw res;
                return res.json();
            })
            .then(() => {
                // 2️⃣ COMPLETE REGISTRATION
                return fetch("{{ route('registerComplete') }}", {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
            })
            .then(res => res.json())
            .then(res => {
                if (res.status) {
                    window.location.href = res.redirect;
                } else {
                    alert(res.message);
                }
            })
            .catch(async err => {
                let response = await err.json();
                showErrors(response.errors);
            });
    }

    document.querySelectorAll('.toggle-password').forEach(function(icon) {

        icon.addEventListener('click', function() {

            const input = this.previousElementSibling;

            if (input.type === "password") {
                input.type = "text";
                this.classList.remove('bi-eye');
                this.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                this.classList.remove('bi-eye-slash');
                this.classList.add('bi-eye');
            }

        });

    });

    document.getElementById('addressInput').addEventListener('change', function() {

        let selectedOption = this.options[this.selectedIndex];
        //alert()
        document.getElementById('address_id').value =
            selectedOption.dataset.addressId || '';

    });
    </script>

</body>

</html>
