<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5, #0ea5e9);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
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
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79,70,229,0.15);
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
            transition: 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.95;
        }

        .auth-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: #6b7280;
        }

        .auth-footer a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 420px) {
            .auth-wrapper {
                padding: 24px 20px;
            }

            .auth-header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-header">
        <h1>Create Account</h1>
        <p>Register to continue</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-primary">
            Register
        </button>
    </form>

    <div class="auth-footer">
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </div>
</div>

</body>
</html>
