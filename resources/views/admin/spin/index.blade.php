@extends('layouts.admin')
@section('title', 'Spin Rewards')

@section('content')

<style>
.spin-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
}

.spin-header {
    padding: 20px;
    border-bottom: 1px solid #f2f2f2;
}

.add-btn {
    background: #6366f1;
    color: #fff;
    padding: 8px 18px;
    border-radius: 8px;
    font-weight: 600;
}

.add-btn:hover {
    background: #4f46e5;
    color: #fff;
}

.reward-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 13px;
}

.badge-cash {
    background: #dcfce7;
    color: #166534;
}

.badge-points {
    background: #e0e7ff;
    color: #3730a3;
}

.badge-coupon {
    background: #fee2e2;
    color: #991b1b;
}

.delete-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-weight: 600;
}

.delete-btn:hover {
    background: #fecaca;
}
</style>


<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Breadcrumb -->
        <div class="page-header-breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                @if(request('key')=='object')
                <li class="breadcrumb-item active">Spin Object</li>
                @else
                <li class="breadcrumb-item active">Spin Category</li>
                @endif
            </ol>
        </div>


        <div class="card spin-card">

            <!-- Header -->
            <div class="spin-header d-flex justify-content-between align-items-center">

                <div>
                    @if(request('key')=='object')
                    <h5 class="mb-0 fw-bold">Spin Object</h5>
                    @else
                    <h5 class="mb-0 fw-bold">Spin Category</h5>
                    @endif
                    <small class="text-muted">
                        Manage object shown on the spin wheel
                    </small>
                </div>

                <a href="{{ route('admin.spin.create') }}?key={{@$_REQUEST['key']}}" class="add-btn">
                    + Add
                </a>

            </div>


            <!-- Table -->
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                @if(request('key')=='object')
                                <th>Type</th>
                                @else
                                
                                @endif
                                <!-- <th>Value</th>
                            <th>Winning Chance (%)</th> -->
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($rewards as $key => $reward)

                            <tr>
                                <td>{{ $key+1 }}</td>

                                <td class="fw-semibold">
                                    {{ $reward->name }}
                                </td>

                               
                                @if(request('key')=='object')
                                <td>
                                    <span class="reward-badge
                                    @if($reward->type=='cash') badge-cash
                                    @elseif($reward->type=='points') badge-points
                                    @else badge-coupon
                                    @endif">
                                        {{ ucfirst($reward->type) }}
                                    </span>
                                </td>
                                @endif



                                <td>
                                    @if($reward->status)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        @if(request('key')=='spin')
                                        {{-- Add Object --}}
                                        <a href="{{ route('admin.listObject', $reward->id) }}?key={{request('key')}}"
                                            class="badge bg-info text-dark text-decoration-none">
                                            Add Object
                                        </a>

                                        <button class="btn btn-info btn-sm text-white"
                                            onclick="openAddressModal({{ $reward->id }})">
                                            Manage Address
                                        </button>
                                        @endif
                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('admin.deleteSpin',$reward->id) }}"
                                            onsubmit="return confirm('Delete this reward?')" class="m-0">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="badge bg-danger border-0">
                                                Delete
                                            </button>

                                        </form>

                                    </div>
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
<!-- Address Modal -->
<!-- ================= MODAL ================= -->

<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('admin.assignAddress') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Assign Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <!-- ✅ PASS SPIN ID -->
                    <input type="hidden" name="spin_id" id="spin_id">


                    <label class="fw-semibold mb-2">
                        Select Address
                    </label>

                    <select id="address_id" name="address_ids[]" class="form-select" multiple required>

                        @foreach($merchants as $merchant)

                        @if($merchant->addresses->count())

                        <optgroup label="{{ $merchant->full_name }}">

                            @foreach($merchant->addresses as $address)

                            <option value="{{ $address->id }}">
                                {{ $address->address }},
                                {{ $address->city }},
                                {{ $address->state }}
                            </option>

                            @endforeach

                        </optgroup>

                        @endif

                        @endforeach

                    </select>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



<!-- ✅ JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
let modal = new bootstrap.Modal(
    document.getElementById('addressModal')
);


// ✅ OPEN MODAL + PASS ID
function openAddressModal(spinId) {

    document.getElementById('spin_id').value = spinId;

    let select = $('#address_id');

    // 🔥 Clear old selection first
    select.val(null).trigger('change');

    // 🔥 Initialize select2 once
    if (!select.hasClass("select2-hidden-accessible")) {
        select.select2({
            dropdownParent: $('#addressModal'),
            width: '100%',
            placeholder: 'Search Address'
        });
    }

    // 🔥 Fetch already assigned addresses
    $.ajax({
        url: '/admin/getSpinAddresses/' + spinId,
        type: 'GET',
        success: function(response) {

            // response = [2,5,7]

            // set selected values
            select.val(response).trigger('change');
        }
    });

    // show modal
    let modal = new bootstrap.Modal(
        document.getElementById('addressModal')
    );

    modal.show();
}
</script>

@endsection