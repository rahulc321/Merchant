@extends('layouts.admin')
@section('title', isset($reward) ? 'Edit Spin Reward' : 'Create Spin Reward')

@section('content')

<!-- FONT AWESOME (icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
.spin-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
}

.card-body {
    padding: 30px;
}

.form-label {
    font-weight: 600;
}

.icon-box {
    width: 90px;
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: #f3f4f6;
    font-size: 32px;
}

.helper-text {
    font-size: 13px;
    color: #6b7280;
}
</style>


<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="/">Home</a>
                    </li>

                    <li class="breadcrumb-item active">
                        {{ request('key') == 'spin' ? 'Create Spin Category' : 'Create Spin Object' }}

                    </li>
                </ol>
            </nav>
        </div>


        <div class="row">
            <div class="col-xl-12">

                <div class="card spin-card">

                    <div class="card-header">
                        <div class="card-title">
                        {{ request('key') == 'spin' ? 'Create Spin Category' : 'Create Spin Object' }}
                        </div>
                    </div>


                    <form method="POST" action="{{ isset($reward)
        ? route('admin.spin.update', [$reward->id, 'key' => request('key')])
        : route('admin.spin.store', ['key' => request('key')]) }}">
                        @csrf

                        @if(isset($reward))
                        @method('PUT')
                        @endif


                        <div class="card-body">

                            <div class="row">

                                <!-- Reward Name -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                         Name <code>*</code>
                                    </label>

                                    <input type="text" name="name" class="form-control" required
                                        placeholder="Example: Win a Fridge"
                                        value="{{ old('name',$reward->name ?? '') }}">
                                </div>

                                @if($_REQUEST['key'] == 'object')
                                <!-- Reward Type -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Object Type <code>*</code>
                                    </label>

                                    <select name="type" class="form-control" required>

                                        <option value="cash"
                                            {{ old('type',$reward->type ?? '')=='cash'?'selected':'' }}>
                                            Cash
                                        </option>

                                        <option value="product"
                                            {{ old('type',$reward->type ?? '')=='product'?'selected':'' }}>
                                            Product
                                        </option>

                                        <option value="points"
                                            {{ old('type',$reward->type ?? '')=='points'?'selected':'' }}>
                                            Points
                                        </option>

                                    </select>
                                </div>





                                <!-- Icon Selection -->
                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Reward Icon <code>*</code>
                                    </label>

                                    <select name="icon" id="iconSelect" class="form-control" onchange="previewIcon()"
                                        required>

                                        <option value="fa-snowflake"
                                            {{ old('icon',$reward->icon ?? '')=='fa-snowflake'?'selected':'' }}>
                                            ❄️ Air Conditioner
                                        </option>

                                        <option value="fa-temperature-low"
                                            {{ old('icon',$reward->icon ?? '')=='fa-temperature-low'?'selected':'' }}>
                                            🧊 Fridge
                                        </option>

                                        <option value="fa-fan"
                                            {{ old('icon',$reward->icon ?? '')=='fa-fan'?'selected':'' }}>
                                            🌪 Cooler / Fan
                                        </option>

                                        <option value="fa-tv"
                                            {{ old('icon',$reward->icon ?? '')=='fa-tv'?'selected':'' }}>
                                            📺 Television
                                        </option>

                                        <option value="fa-car"
                                            {{ old('icon',$reward->icon ?? '')=='fa-car'?'selected':'' }}>
                                            🚗 Car
                                        </option>

                                        <option value="fa-motorcycle"
                                            {{ old('icon',$reward->icon ?? '')=='fa-motorcycle'?'selected':'' }}>
                                            🏍 Bike
                                        </option>

                                        <option value="fa-mobile-screen"
                                            {{ old('icon',$reward->icon ?? '')=='fa-mobile-screen'?'selected':'' }}>
                                            📱 Mobile
                                        </option>

                                        <option value="fa-gift"
                                            {{ old('icon',$reward->icon ?? '')=='fa-gift'?'selected':'' }}>
                                            🎁 Gift Box
                                        </option>

                                        <option value="fa-trophy"
                                            {{ old('icon',$reward->icon ?? '')=='fa-trophy'?'selected':'' }}>
                                            🏆 Trophy
                                        </option>

                                        <option value="fa-laptop"
                                            {{ old('icon',$reward->icon ?? '')=='fa-laptop'?'selected':'' }}>
                                            💻 Laptop
                                        </option>

                                        <option value="fa-watch-smart"
                                            {{ old('icon',$reward->icon ?? '')=='fa-watch-smart'?'selected':'' }}>
                                            ⌚ Smart Watch
                                        </option>
                                        <option value="fa-money-bill-wave"
                                            {{ old('icon',$reward->icon ?? '')=='fa-money-bill-wave'?'selected':'' }}>
                                            💵 Cash
                                        </option>

                                    </select>

                                </div>
                                @endif
                                <!-- Status -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">
                                        Status
                                    </label>

                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status',$reward->status ?? 1)==1?'selected':'' }}>
                                            Active
                                        </option>

                                        <option value="0" {{ old('status',$reward->status ?? '')==0?'selected':'' }}>
                                            Disabled
                                        </option>
                                    </select>
                                </div>



                            </div>

                        </div>


                        <div class="card-footer text-end">

                            <a href="{{ route('admin.spin.index') }}" class="btn btn-light">
                                Cancel
                            </a>

                            <button class="btn btn-primary">
                            {{ request('key') == 'spin' ? 'Create Spin Category' : 'Create Spin Object' }}
                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</div>


<script>
function previewIcon() {

    let icon = document.getElementById('iconSelect').value;

    document.getElementById('iconPreview').className =
        'fa-solid ' + icon;
}
</script>

@endsection