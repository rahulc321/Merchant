<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            box-sizing:border-box;
            font-family:'Inter',sans-serif;
        }

        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(to right,#071217,#16292f,#071820);
            padding:20px;
        }

        .thank-wrapper{
            background:#fff;
            max-width:500px;
            width:100%;
            padding:40px 30px;
            border-radius:18px;
            text-align:center;
            box-shadow:0 20px 60px rgba(0,0,0,.15);
        }

        .checkmark{
            width:90px;
            height:90px;
            border-radius:50%;
            background:#22c55e;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 20px;
            font-size:42px;
            color:#fff;
            font-weight:bold;
        }

        h1{
            margin:10px 0;
            font-size:26px;
            color:#111827;
        }

        p{
            color:#6b7280;
            font-size:15px;
            margin-bottom:25px;
        }

        .btn{
            display:inline-block;
            padding:12px 22px;
            border-radius:10px;
            background:linear-gradient(135deg,#4f46e5,#6366f1);
            color:#fff;
            text-decoration:none;
            font-weight:600;
            transition:.3s;
        }

        .btn:hover{
            transform:translateY(-2px);
        }
    </style>
</head>
<body>

<div class="thank-wrapper">

    <div class="checkmark">
        ✓
    </div>

    <h1>Thank You!</h1>

    <p>
        Your registration and order have been successfully submitted.
        Our team will process it shortly.
    </p>

    <a href="" class="btn">
        Go to Dashboard
    </a>

</div>

</body>
</html>
