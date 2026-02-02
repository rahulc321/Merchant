@extends('layouts.admin')

@section('title', 'AetherSmart - Category')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Category</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            @forelse($cats as $key=> $categories)
            @php
            $name = strtolower($categories->name);
            # default icon
            $icon = 'bi-folder';

            # condition for wifi/install
            if (str_contains($name, 'wifi') || str_contains($name, 'install')) {
            $icon = 'bi-wifi';
            }
            # condition for training
            elseif (str_contains($name, 'training')) {
            $icon = 'bi-mortarboard'; # training cap icon
            }
            @endphp
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <a href="{{ route('admin.training') }}?category={{ $categories->id }}" class="text-decoration-none">
                    <div class="custom-box h-100 position-relative d-flex flex-column bg-{{$key+1}}">
                        <div class="content-wrapper flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-flex align-items-center justify-content-center me-3"
                                    style="padding: 12px 16px; background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); border-radius: 12px;">
                                    <i class="bi {{ $icon }} text-white" style="font-size: 28px;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-white mb-0 c_color">{{ $categories->name }}</h5>
                                    <small class="text-white c_color">
                                        {{ $categories->description }}</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-white c_color">
                                    <?php
                                        $itemCount = DB::table('training')->where('cat_id',$categories->id)->count();
                                    ?>

                                    <span class="text-primary">•</span> {{ $itemCount ?? 0 }} items
                                </small>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>

                        <div class="bottom-line bottom-0 start-0 w-100"
                            style="height: 4px; background: linear-gradient(to right, #00c6ff, #0072ff); border-radius: 0 0 20px 20px;margin-bottom: -30px;">
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    No categories available.
                </div>
            </div>
            @endforelse
        </div>

    </div>
</div>

<style>
.custom-box {
    border-radius: 7px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
    padding: 20px 20px 40px 20px;
    transition: box-shadow 0.3s ease;
    position: relative;
}

.custom-box:hover {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.7);
}

.text-muted {
    color: #6c757d !important;
}

.h-100 {
    height: 120% !important;
}
</style>
@endsection