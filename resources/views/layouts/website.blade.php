<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Privacy Policy</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f4f6fb;
}

/* ================= HEADER ================= */

.header{
    position:sticky;
    top:0;
    z-index:999;
    background:white;
    padding:18px 40px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 4px 20px rgba(0,0,0,.05);
}

/* keeps logo perfectly centered */
.logo{
    position:absolute;
    left:50%;
    transform:translateX(-50%);
}

.logo img{
    height:48px;
}

/* contact button */
.contact a{
    text-decoration:none;
    padding:10px 18px;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    border-radius:8px;
    font-weight:500;
    transition:.3s;
}

.contact a:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(0,0,0,.15);
}

/* ================= HERO ================= */

.hero{
    background: linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    padding:80px 40px;
    text-align:center;
}

.hero h1{
    font-size:44px;
    font-weight:700;
}

.hero p{
    margin-top:10px;
    opacity:.9;
}

/* ================= CONTENT ================= */

.container{
    max-width:1100px;
    margin:auto;
    padding:60px 20px;
}

.policy-card{
    background:white;
    padding:55px;
    border-radius:16px;
    box-shadow:0 10px 40px rgba(0,0,0,.06);
}

.policy-card h2{
    margin-top:30px;
    margin-bottom:10px;
    color:#222;
}

.policy-card p{
    color:#555;
    line-height:1.9;
}

.policy-card ul{
    padding-left:20px;
}

.policy-card li{
    margin-bottom:10px;
    color:#555;
}

/* ================= FOOTER ================= */

.footer{
    text-align:center;
    padding:35px;
    color:#777;
}

/* ================= MOBILE ================= */

@media(max-width:768px){

.header{
    padding:15px 20px;
}

.logo img{
    height:38px;
}

.contact a{
    padding:8px 14px;
    font-size:14px;
}

.hero{
    padding:60px 20px;
}

.hero h1{
    font-size:30px;
}

.policy-card{
    padding:25px;
}

}

</style>
</head>

<body>

<!-- ================= HEADER ================= -->

<div class="header">

    <!-- empty div keeps spacing balanced -->
    <div></div>

    <div class="logo">
        <img src="logo.png" alt="Logo">
    </div>

    <div class="contact">
        <a href="/contact">Contact Us</a>
    </div>

</div>


@yield('content')



<!-- ================= FOOTER ================= -->

<div class="footer">
    © <?php echo date('Y'); ?> LMS. All rights reserved.
</div>

</body>
</html>
