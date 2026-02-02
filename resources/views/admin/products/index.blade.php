@extends('layouts.admin')
@section('title', 'AetherSmart - Products')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">

                    @foreach ($allProducts as $product)
                    <div class="col-sm-3">
                        <div class="card custom-card shadow-lg"
                            style="background: linear-gradient(135deg, #f3f4f6, #ffffff); border-radius: 10px;">
                            <div class="card-header text-white text-center bg-primary"
                                style="border-radius: 10px 10px 0 0;">
                                <h5 class="mb-0">{{ $product['name'] }}</h5>
                            </div>
                            <div class="card-body text-center">
                                <!-- <img src="https://images.tuyacn.com/{{ $product['icon'] }}" alt="{{ $product['name'] }}"
                                    class="img-fluid rounded mb-2"
                                    style="height: 150px; width: 100%; object-fit: cover;"> -->

                                    <img src="{{url('/')}}/tank.png" alt="{{ $product['name'] }}"
                                    class="img-fluid rounded mb-2"
                                    style="object-fit: cover;">
                                <!-- <p class="text-muted">PID: {{ $product['product_id'] }}</p> -->
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection