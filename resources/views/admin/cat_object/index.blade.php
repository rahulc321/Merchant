@extends('layouts.admin')
@section('title', 'Spin Rewards')

@section('content')

<style>

.spin-card{
    border:none;
    border-radius:16px;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
}

.spin-header{
    padding:20px;
    border-bottom:1px solid #f2f2f2;
}

.add-btn{
    background:#6366f1;
    color:#fff;
    padding:8px 18px;
    border-radius:8px;
    font-weight:600;
}

.add-btn:hover{
    background:#4f46e5;
    color:#fff;
}

.reward-badge{
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
    font-size:13px;
}

.badge-cash{
    background:#dcfce7;
    color:#166534;
}

.badge-points{
    background:#e0e7ff;
    color:#3730a3;
}

.badge-coupon{
    background:#fee2e2;
    color:#991b1b;
}

.delete-btn{
    background:#fee2e2;
    color:#dc2626;
    border:none;
    padding:6px 14px;
    border-radius:6px;
    font-weight:600;
}

.delete-btn:hover{
    background:#fecaca;
}

</style>


<div class="main-content app-content">
<div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="page-header-breadcrumb mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Spin Rewards</li>
        </ol>
    </div>


    <div class="card spin-card">

        <!-- Header -->
        <div class="spin-header d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-0 fw-bold">Spin Rewards - {{@$rewardsName->name}}</h5>
                <small class="text-muted">
                    Manage rewards shown on the spin wheel
                </small>
            </div>

            <a href="{{ route('admin.addObject',[$rewardsName->id]) }}" class="add-btn">
                + Add Reward
            </a>

        </div>


        <!-- Table -->
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Reward Name</th>
                            <th>Reward Type</th>
                            <th>Value</th>
                            <th>Winning Chance (%)</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rewards as $key1 => $reward)

                        <tr>
                            <td>{{$key1+1}}</td>

                            <td class="fw-semibold">
                            {{ $reward->category->name ?? 'N/A' }}
                            </td>

                            <td class="fw-semibold">
                            {{ $reward->rewardName->name ?? '-' }}
                            </td>

                            <td>
                                <span class="reward-badge
                                    @if($reward->type=='cash') badge-cash
                                    @elseif($reward->type=='points') badge-points
                                    @else badge-coupon
                                    @endif">
                                    {{ ucfirst($reward->type) }}
                                </span>
                            </td>

                            <td>
                                @if($reward->type=='cash')
                                     {{ $reward->value }}
                                @else
                                    {{ $reward->value }}
                                @endif
                            </td>

                            <td>
                                {{ $reward->chance }}%
                            </td>

                            <td>
                                @if($reward->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>

                            <td>

                                <form method="POST"
                                      action="{{ route('admin.deleteSpinObject',$reward->id) }}"
                                      onsubmit="return confirm('Delete this reward?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="delete-btn">
                                        Delete
                                    </button>

                                </form>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No rewards added yet
                            </td>
                        </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
</div>

@endsection
