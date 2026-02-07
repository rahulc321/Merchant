@extends('layouts.website')
@section('title', 'LMS - Privacy Policy')
@section('content')

<!-- ================= HERO ================= -->

<section class="hero">
    <h1>Privacy Policy</h1>
    <p>Your privacy is important to us. Learn how we collect, use, and protect your data.</p>
</section>



<!-- ================= CONTENT ================= -->

<div class="container">
    <div class="policy-card">

        <p>
            At <strong>YourCompany</strong>, we are committed to safeguarding your personal information.
            This Privacy Policy explains how your data is collected, used, and protected when you use our services.
        </p>

        <h2>1. Information We Collect</h2>
        <p>We may collect the following information when you use our platform:</p>

        <ul>
            <li>Name, username, and contact details</li>
            <li>Email address and phone number</li>
            <li>Payment and billing information</li>
            <li>Login activity and device data</li>
            <li>Usage behavior for analytics</li>
        </ul>

        <h2>2. How We Use Your Information</h2>
        <ul>
            <li>To create and manage your account</li>
            <li>To securely process transactions</li>
            <li>To improve platform performance</li>
            <li>To send important notifications</li>
            <li>To prevent fraud and unauthorized access</li>
        </ul>

        <h2>3. Sharing of Information</h2>
        <p>
            We do not sell your personal data. Your information may only be shared with trusted
            service providers necessary to operate our business or when legally required.
        </p>

        <h2>4. Cookies & Tracking</h2>
        <p>
            Our website uses cookies to enhance user experience, remember preferences,
            and analyze website traffic.
        </p>

        <h2>5. Data Security</h2>
        <p>
            We implement industry-standard security measures including encryption,
            firewalls, and secure servers to protect your data.
            However, no online transmission is ever 100% secure.
        </p>

        <h2>6. Data Retention</h2>
        <p>
            We retain your information only as long as necessary to fulfill the purposes outlined in this policy,
            unless otherwise required by law.
        </p>

        <h2>7. Your Privacy Rights</h2>
        <ul>
            <li>Access your stored data</li>
            <li>Request correction of inaccurate data</li>
            <li>Request deletion of your data</li>
            <li>Withdraw consent anytime</li>
        </ul>

        <h2>8. Policy Updates</h2>
        <p>
            We may update this Privacy Policy periodically.
            Updates will be posted on this page with a revised date.
        </p>

        <h2>9. Contact Information</h2>
        <p>
            If you have any questions regarding this Privacy Policy, please contact us:
        </p>

        <p>
            📧 support@yourcompany.com <br>
            📍 Business Street, City, Country
        </p>

        <p style="margin-top:40px;font-weight:500;">
            Last Updated: <?php echo date('F d, Y'); ?>
        </p>

    </div>
</div>
@endsection