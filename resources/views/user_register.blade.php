<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- google font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php error_reporting(0); ?>
    <style>
    * {
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(to right, #071217, #16292f, #071820);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .auth-wrapper {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 16px;
        padding: 28px 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .auth-header h1 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #111827;
    }

    .auth-header p {
        font-size: 14px;
        color: #6b7280;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 6px;
        color: #374151;
    }

    .form-control {
        width: 100%;
        height: 46px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        font-size: 14px;
        outline: none;
    }

    .btn-primary {
        width: 100%;
        height: 46px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .d-none {
        display: none;
    }

    .error {
        font-size: 13px;
        color: #dc2626;
        margin-top: 6px;
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
                    <input type="email" name="email" class="form-control"  placeholder="Email">
                    <div class="error" data-error="email"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone_number" class="form-control" placeholder="Phone">
                    <div class="error" data-error="phone_number"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                    <div class="error" data-error="password"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="button" class="btn-primary" onclick="nextStep()">
                    Continue
                </button>
            </div>

            {{-- STEP 2 --}}
            <div class="step step-2 d-none">
                <div class="form-group">
                    <label class="form-label">Restaurant</label>
                    <select name="restaurant_id" id="restaurantSelect" class="form-control" onchange="fillAddress()">
                        <option value="">Select Restaurant</option>

                        @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" data-address='@json($restaurant->addresses)' data-amount='{{$restaurant->amount}}'>
                            {{ $restaurant->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="error" data-error="restaurant_id"></div>
                </div>

                <select name="address" id="addressInput" class="form-control"></select>
                <div class="error" data-error="address"></div>


                <div class="form-group">
                    <label class="form-label">Amount <i style="color:red" class="amount"></i></label>
                    <div class="amount" ></div>
                    <input type="number" name="amount" class="form-control" placeholder="Amount">
                    <div class="error" data-error="amount"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Cashier Verification Code</label>
                    <input type="text" name="cashier_code" class="form-control" placeholder="Cashier Verification Code">
                    <div class="error" data-error="cashier_code"></div>
                </div>

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

        fetch("{{ route('admin.registerStep') }}", {
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
        fetch("{{ route('admin.registerStep') }}", {
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
                return fetch("{{ route('admin.registerComplete') }}", {
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
    </script>

</body>

</html>