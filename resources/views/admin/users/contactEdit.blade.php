@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Contact')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Contact</li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Contact</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contactUpdate',[$user->id]) }}" method="POST" enctype="multipart/form-data" class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-3">
                            <label class="form-label">Type<code>*</code></label>
                            <select class="form-control" name="type" id="type" required onchange="showFields()">
                                <option value="">Select</option>
                                <option value="store">Store</option>
                                <option value="bm">Branch Manager</option>
                                <option value="tt">Territory Manager</option>
                            </select>
                        </div>

                        <div id="dynamic-fields" class="row g-3"></div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const fieldsData = {
    store: `
        <div class="col-md-3">
            <label class="form-label">Store Location</label>
            <input type="text" name="store_location" class="form-control" placeholder="Store Location">
        </div>
        <div class="col-md-3">
            <label class="form-label">Store State</label>
            <input type="text" name="store_state" class="form-control" placeholder="Store State">
        </div>
        <div class="col-md-3">
            <label class="form-label">Store Email</label>
            <input type="email" name="email" class="form-control" placeholder="Store Email">
             <span class="email-error" style="color: red; display: none;"></span>
        </div>
        <div class="col-md-3">
            <label class="form-label">Store Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Store Phone">
            <input type="hidden" name="type" value="store">
            <span class="phone-error" style="color: red; display: none;"></span>
        </div>`
    ,
    bm: `
        <div class="col-md-3">
            <label class="form-label">Branch Manager Name</label>
            <input type="text" name="name" class="form-control" placeholder="Branch Manager Name">
        </div>
        <div class="col-md-3">
            <label class="form-label">Branch Manager Email</label>
            <input type="email" name="email" class="form-control" placeholder="Branch Manager Email">
             <span class="email-error" style="color: red; display: none;"></span>
            </div>
        <div class="col-md-3">
            <label class="form-label">Branch Manager Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Branch Manager Phone">
            <input type="hidden" name="type" value="bm">
            <span class="phone-error" style="color: red; display: none;"></span>
        </div>
        <div class="col-md-3">
            <label class="form-label">Branch Manager Notes</label>
            <input type="text" name="notes" class="form-control" placeholder="Branch Manager Notes">
        </div>`
    ,
    tt: `
        <div class="col-md-3">
            <label class="form-label">Territory Manager Name</label>
            <input type="text" name="name" class="form-control" placeholder="Territory Manager Name">
        </div>
        <div class="col-md-3">
            <label class="form-label">Territory Manager Email</label>
            <input type="email" name="email" class="form-control" placeholder="Territory Manager Email">
        </div>
        <div class="col-md-3">
            <label class="form-label">Territory Manager Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="Territory Manager Phone">
            <input type="hidden" name="type" value="tt">
        </div>
        <div class="col-md-3">
            <label class="form-label">Territory Manager Notes</label>
            <input type="text" name="notes" class="form-control" placeholder="Territory Manager Notes">
        </div>`
};

function showFields() {
    const type = document.getElementById('type').value;
    document.getElementById('dynamic-fields').innerHTML = fieldsData[type] || '';
}

$(document).ready(function() {
    const user = @json($user ?? []);
     
    if (user.type) {
        $('#type').val(user.type).trigger('change');
    }
    
    setTimeout(() => {
        $.each(user, function(key, value) {

            console.log(key);

            $('[name="' + key + '"]').val(value);

            if(key =='store_location'){
                $('[name="name"]').val(value);
            }

            if(key =='notes'){
                $('[name="notes"]').val(value);
            }
             
        });
    }, 100);
});
</script>
@endsection
