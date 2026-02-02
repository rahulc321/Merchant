<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
    <meta property="og:title" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
    <meta property="og:description" content="W3crm:Customer Relationship Management Admin Bootstrap 5 Template">
    <meta property="og:image" content="https://w3crm.dexignzone.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">
    
    <!-- PAGE TITLE HERE -->
    <title>W3CRM Customer Relationship Management</title>
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
 @yield('styles')
</head>


<body class="vh-100">
    <div class="page-wraper">
    @yield('content')
    @yield('scripts')
    </div>

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{ asset('vendor/global/global.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset('js/deznav-init.js')}}"></script>
 <script src="{{ asset('js/custom.js')}}"></script>


</body>
</html>
