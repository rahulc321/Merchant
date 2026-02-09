<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- google font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    *{
        box-sizing:border-box;
        font-family:'Inter',sans-serif;
        -webkit-tap-highlight-color:transparent;
    }

    html,body{
        margin:0;
        min-height:100%;
    }

    body{
        background:linear-gradient(to right,#071217,#16292f,#071820);
        display:flex;
        align-items:center;
        justify-content:center;
        padding:12px;
    }

    .auth-wrapper{
        width:100%;
        max-width:420px;
        background:#fff;
        border-radius:16px;
        padding:26px 22px;
        box-shadow:0 20px 60px rgba(0,0,0,.15);
    }

    @media(max-width:480px){
        body{
            padding:0;
            align-items:flex-start;
        }

        .auth-wrapper{
            max-width:100%;
            min-height:100vh;
            border-radius:0;
            padding:22px 16px;
        }
    }

    .auth-header{
        text-align:center;
        margin-bottom:22px;
    }

    .auth-header h1{
        font-size:24px;
        font-weight:700;
        margin-bottom:6px;
        color:#111827;
    }

    .form-group{
        margin-bottom:14px;
    }

    .form-label{
        display:block;
        font-size:13px;
        font-weight:600;
        margin-bottom:6px;
        color:#374151;
    }

    .form-control{
        width:100%;
        height:48px;
        padding:0 14px;
        border-radius:10px;
        border:1px solid #e5e7eb;
        font-size:16px;
        outline:none;
    }

    .btn-primary{
        width:100%;
        height:52px;
        border-radius:14px;
        border:none;
        background:linear-gradient(135deg,#4f46e5,#6366f1);
        color:#fff;
        font-size:16px;
        font-weight:600;
        cursor:pointer;
        margin-top:10px;
        transition:.25s;
    }

    .btn-primary:hover{
        transform:translateY(-1px);
        box-shadow:0 10px 20px rgba(99,102,241,.25);
    }

    .btn-primary:active{
        transform:scale(.98);
    }

    .error{
        font-size:13px;
        color:#dc2626;
        margin-top:6px;
    }

    .auth-alt{
        text-align:center;
        margin-top:18px;
        font-size:14px;
        color:#6b7280;
    }

    .auth-alt a{
        color:#4f46e5;
        font-weight:600;
        text-decoration:none;
        margin-left:4px;
    }

    .auth-alt a:hover{
        text-decoration:underline;
    }

    .alert{
        padding:10px;
        border-radius:8px;
        margin-bottom:14px;
        font-size:14px;
    }

    .alert-danger{
        background:#fee2e2;
        color:#b91c1c;
    }
    </style>
</head>

<body>

<div class="auth-wrapper">

    <div class="auth-header">
        <h1>Welcome Back</h1>
        <p>Login to continue</p>
    </div>

    {{-- session error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('customLoginUser') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Phone</label>
            <input 
                type="text"
                name="phone_number"
                class="form-control"
                value="{{ old('phone_number') }}"
                placeholder="Enter phone_number"
            >
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input 
                type="password"
                name="password"
                class="form-control"
                placeholder="Enter password"
            >
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn-primary">
            Login
        </button>

        <div class="auth-alt">
            Don’t have an account?
            <a href="{{ url('/user/register') }}">Create Account</a>
        </div>

    </form>
</div>

</body>
</html>
