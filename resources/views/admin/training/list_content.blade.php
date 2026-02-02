@extends('layouts.admin')
@section('title', 'AetherSmart - List Content')
@section('content')

<!-- ✅ Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/admin/training') }}">Training</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Content</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0 rounded">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            Training Collection Content - {{ $training->title }}
                        </h5>
                        @if (Auth::user()->roles->contains('title', 'Admin'))
                        <a href="{{ route('admin.addTrainingContent', [$training->id]) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-2"></i>Add Content
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-basic1" class="table table-hover table-bordered text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th></th> <!-- reorder handle -->
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($content as $key => $value)
                                    <?php $is_view = $value->viewedByUser ? 1 : 0; ?>
                                    <tr data-id="{{ $value->id }}">
                                        <td class="reorder-handle">☰</td> <!-- can use icon or emoji -->
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-medium text-dark">{{ $value->content }}</td>
                                        <td class="fw-medium text-dark">{{ $value->type }}</td>
                                        <td>
                                            @if (Auth::user()->roles->contains('title', 'Admin'))
                                            <div class="d-flex justify-content-center gap-2">
                                                <a class="btn btn-sm btn-info shadow-sm"
                                                    href="{{ route('admin.viewContant', [$value->id, $training->id]) }}">
                                                    View Content
                                                </a>
                                                <button class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="if(confirm('Are you sure you want to delete this?')) { document.getElementById('deleteFrm{{ $key }}').submit(); }">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                                <form id="deleteFrm{{ $key }}" action="{{ route('admin.collectionCondentDelete', $value->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                            @else
                                                @if ($is_view == 0)
                                                    <p style="color:red">Please watch full video!</p>
                                                @else
                                                    <p class="text-success">Video Watched</p>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JS includes AFTER content -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->


<script>
$(document).ready(function () {
    
    const table = $('#datatable-basic1').DataTable({
        rowReorder: {
            selector: '.reorder-handle'
        },
        responsive: true,
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        columnDefs: [
            { targets: 0, orderable: false, className: 'reorder-handle' }
        ]
    });

    table.on('row-reorder', function (e, diff, edit) {
        if (!diff.length) return;

        const order = diff.map(row => ({
            id: $(row.node).data('id'),
            position: row.newPosition
        }));

        $.ajax({
            url: "{{ route('admin.reorderTrainingContent') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { order },
            success: function (res) {
                if (res.success) {
                    //alert("Order updated.");
                    location.reload();
                }
            },
            error: function () {
                alert("Order update failed.");
            }
        });
    });
});
</script>

<style>
.table tbody tr {
    cursor: move;
}
.reorder-handle {
    cursor: move;
}
</style>

@endsection
