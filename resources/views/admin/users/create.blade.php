@extends('layouts.admin')
@section('title', 'AetherSmart - Add User')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <!-- <h1 class="page-title fw-medium fs-18 mb-2">Data Tables</h1> -->
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        User
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-3">
                            <label class="form-label">Type<code>*</code></label>
                            <select class="form-control" name="type" id="type" required onchange="showFields()">
                                <option value="">Select</option>
                                <option value="end_user"
                                    <?php if($_REQUEST['type'] == 'end_user'){ echo 'selected'; } ?>>End User</option>
                                <option value="service_agent"
                                    <?php if($_REQUEST['type'] == 'service_agent'){ echo 'selected'; } ?>>Service Agents
                                </option>
                                <option value="potential_user"
                                    <?php if($_REQUEST['type'] == 'potential_user'){ echo 'selected'; } ?>>Potential
                                    User</option>
                                <option value="reseller"
                                    <?php if($_REQUEST['type'] == 'reseller'){ echo 'selected'; } ?>>Reseller</option>
                                <option value="retailer"
                                    <?php if($_REQUEST['type'] == 'retailer'){ echo 'selected'; } ?>>Retailer</option>
                                <option value="distributor"
                                    <?php if($_REQUEST['type'] == 'distributor'){ echo 'selected'; } ?>>Distributor
                                </option>

                                <option value="Installer"
                                    <?php if($_REQUEST['type'] == 'Installer'){ echo 'selected'; } ?>>Installer
                                </option>
                            </select>
                        </div>

                        <!-- Dynamic Fields Section -->
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
    end_user: `
            <div class="col-md-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Email)</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        <span class="email-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Phone Number)</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
        <span class="phone-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                 <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
             <div class="col-md-3">
                <label class="form-label">Country</label>
                 <input type="text" name="country" class="form-control" placeholder="Country">
            </div>


            <div class="col-md-3">
                <label class="form-label">State</label>
                
                 <select class="form-control" name="state" required >
                  <option value="">Select</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="TAS">TAS</option>
                  
               </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">City</label>
                 <input type="text" name="city" class="form-control" placeholder="City">
            </div>


            <div class="col-md-3">
                <label class="form-label">Zipcode</label>
                 <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
            </div>
 
            <div class="col-md-3">
                <label class="form-label">Product Model Owned</label>
                <input type="text" name="product_model" class="form-control" placeholder="Enter product model">
            </div>
            <div class="col-md-3">
                <label class="form-label">Installation Date</label>
                <input type="date" name="installation_date" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Warranty Status</label>
               <select class="form-control" name="warranty_status" id="type" required>
                  <option value="">Select</option>
                  <option value="1">abc</option>
                  <option value="2">abc2</option>
                  
               </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Service History</label>
                <input type="text" name="service_history" class="form-control" placeholder="Service History">
            </div>

             <div class="col-md-3">
                <label class="form-label">Last Contact Date</label>
                <input type="date" name="last_contact_date" class="form-control" placeholder="Last Contact Date">
            </div>

             <div class="col-md-6">
                <label class="form-label">Feedback</label>
                <textarea name="feedback" class="form-control" placeholder="Feedback"></textarea>
            </div>
        `,
    service_agent: `
            <div class="col-md-3">
                <label class="form-label">Agent Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter agent name" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-control" placeholder="Enter company" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Email)</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        <span class="email-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Phone Number)</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
        <span class="phone-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                 <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
             <div class="col-md-3">
                <label class="form-label">Country</label>
                 <input type="text" name="country" class="form-control" placeholder="Country">
            </div>


            <div class="col-md-3">
                <label class="form-label">State</label>
                 
                  <select class="form-control" name="state" required >
                  <option value="">Select</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="TAS">TAS</option>
                  </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">City</label>
                 <input type="text" name="city" class="form-control" placeholder="City">
            </div>


            <div class="col-md-3">
                <label class="form-label">Zipcode</label>
                 <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
            </div>
            <div class="col-md-3">
                <label class="form-label">Region/Coverage Area</label>
                <input type="text" name="region" class="form-control" placeholder="Enter region">
            </div>

            <div class="col-md-3">
                <label class="form-label">Specialization</label>
               <select class="form-control" name="specialization" required >
                  <option value="">Select</option>
                  <option value="Installation">Installation</option>
                  <option value="Maintenance">Maintenance</option>
                  
               </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Certifications</label>
                <input type="text" name="certifications" class="form-control" placeholder="Certifications">
            </div>

            <div class="col-md-3">
                <label class="form-label">Appointment Availability</label>
                <input type="text" name="appointment_availability" class="form-control" placeholder="Appointment Availability">
            </div> 
            <div class="col-md-3">
                <label class="form-label">History of Service Calls</label>
                <input type="text" name="history_service_calls" class="form-control" placeholder="History of Service Calls">
            </div>


            <div class="col-md-3">
                <label class="form-label">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Password">
            </div>

            <div class="col-md-6">
                <label class="form-label">Feedback</label>
                <textarea name="feedback" class="form-control" placeholder="Feedback"></textarea>
            </div>
        `,
    potential_user: `
            <div class="col-md-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Email)</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        <span class="email-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Phone Number)</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
        <span class="phone-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                 <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
             <div class="col-md-3">
                <label class="form-label">Country</label>
                 <input type="text" name="country" class="form-control" placeholder="Country">
            </div>


            <div class="col-md-3">
                <label class="form-label">State</label>
                 
                 <select class="form-control" name="state" required >
                  <option value="">Select</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="TAS">TAS</option>
                  </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">City</label>
                 <input type="text" name="city" class="form-control" placeholder="City">
            </div>


            <div class="col-md-3">
                <label class="form-label">Zipcode</label>
                 <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
            </div>


            <div class="col-md-3">
                <label class="form-label">Interest Level</label>
                <select name="interest_level" class="form-control">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Preferred Contact Method</label>
                 <input type="text" name="preferred_contact_method" class="form-control" placeholder="Preferred Contact Method">
            </div>

            <div class="col-md-3">
                <label class="form-label">Source of Lead</label>
                <select name="source_lead" class="form-control">
                    <option value="Website">Website</option>
                    <option value="Referral">Referral</option>
                     
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Feedback</label>
                <textarea name="feedback" class="form-control" placeholder="Feedback"></textarea>
            </div>
        `,
    reseller: `
             <div class="col-md-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Email)</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        <span class="email-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Phone Number)</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
        <span class="phone-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                 <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
             <div class="col-md-3">
                <label class="form-label">Country</label>
                 <input type="text" name="country" class="form-control" placeholder="Country">
            </div>


            <div class="col-md-3">
                <label class="form-label">State</label>
                  
                 <select class="form-control" name="state" required >
                  <option value="">Select</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="TAS">TAS</option>
                  </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">City</label>
                 <input type="text" name="city" class="form-control" placeholder="City">
            </div>


            <div class="col-md-3">
                <label class="form-label">Zipcode</label>
                 <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
            </div>
            <div class="col-md-3">
                <label class="form-label">Business Address</label>
                <input type="text"  name="business_address" class="form-control" placeholder="Enter business address">
            </div>

            <div class="col-md-3">
                <label class="form-label">Type of Business</label>
                <select name="type_of_business" class="form-control">
                    <option value="HVAC">HVAC</option>
                    <option value="Gener_Contractor">General Contractor</option>
                     
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Volume of Sales</label>
                 <input type="text" name="volume_of_sales" class="form-control" placeholder="Volume of Sales">
            </div>

            <div class="col-md-3">
                <label class="form-label">Payment Terms</label>
                 <input type="text" name="payment_terms" class="form-control" placeholder="Payment Terms">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sales Representative Assigned</label>
                 <input type="text" name="sales_representative_assigned" class="form-control" placeholder="Sales Representative Assigned">
            </div>
        `,
    retailer: `
            <div class="col-md-3">
                <label class="form-label">Retailer Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter retailer name" required>
            </div>


            <div class="col-md-3">
                <label class="form-label">Contact Person</label>
                <input type="text" name="contact_persion" class="form-control" placeholder="Contact Person" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Contact Information (Email)</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        <span class="email-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Phone Number)</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
        <span class="phone-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                 <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
             <div class="col-md-3">
                <label class="form-label">Country</label>
                 <input type="text" name="country" class="form-control" placeholder="Country">
            </div>


            <div class="col-md-3">
                <label class="form-label">State</label>
                 
                 <select class="form-control" name="state" required >
                  <option value="">Select</option>
                  <option value="VIC">VIC</option>
                  <option value="NSW">NSW</option>
                  <option value="QLD">QLD</option>
                  <option value="TAS">TAS</option>
                  </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">City</label>
                 <input type="text" name="city" class="form-control" placeholder="City">
            </div>


            <div class="col-md-3">
                <label class="form-label">Zipcode</label>
                 <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
            </div>


            <div class="col-md-3">
                <label class="form-label">Store Locations</label>
                <input type="text" name="store_locations" class="form-control" placeholder="Enter store locations">
            </div>

            <div class="col-md-3">
                <label class="form-label">Business Address</label>
                <input type="text"  name="business_address" class="form-control" placeholder="Enter business address">
            </div>

            <div class="col-md-3">
                <label class="form-label">Type of Products</label>
                <input type="text"  name="product_type" class="form-control" placeholder="Type of Products">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sales Volume</label>
                <input type="text"  name="volume_of_sales" class="form-control" placeholder="Sales Volume">
            </div>

            <div class="col-md-3">
                <label class="form-label">Order History</label>
                <input type="text"  name="order_history" class="form-control" placeholder="Order History">
            </div>

            <div class="col-md-3">
                <label class="form-label">Payment Terms</label>
                <input type="text"  name="payment_terms" class="form-control" placeholder="Payment Terms">
            </div>
        `,
    distributor: `
            <div class="col-md-3">
                <label class="form-label">Distributor Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter distributor name" required>
            </div>

          
        <fieldset class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Store Location</label>
                
                <select name="store_location" class="form-control store">
                <option value="">Select Store Location</option>
                <?php foreach ($stores as $store) { ?>
                     <option value="<?= $store->id ?>" 
                data-store='<?= json_encode($store, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
            <?= htmlspecialchars($store->store_location, ENT_QUOTES, 'UTF-8') ?>
        </option>
                <?php } ?>
        </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">Store State</label>
                <input type="text" name="store_state" class="form-control" placeholder="Store State">
            </div>

            <div class="col-md-3">
                <label class="form-label">Store Email</label>
                <input type="text" name="store_email" class="form-control" placeholder="Store Email">
            </div>

            <div class="col-md-3">
                <label class="form-label">Store Phone</label>
                <input type="text" name="store_phone" class="form-control" placeholder="Store Phone">
            </div>
        </fieldset>


        <fieldset class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Branch Manager Name</label>
                 
                <select name="bm_name" class="form-control bm">
                <option value="">Select</option>
                <?php foreach ($bms as $store) { ?>
                   <option value="<?= $store->id ?>" 
                data-store='<?= json_encode($store, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
            <?= htmlspecialchars($store->store_location, ENT_QUOTES, 'UTF-8') ?>
        </option>
                <?php } ?>
                </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">Branch Manager Email</label>
                <input type="text" name="bm_email" class="form-control" placeholder="Branch Manager Email">
            </div>

            <div class="col-md-3">
                <label class="form-label">Branch Manager Phone</label>
                <input type="text" name="bm_phone" class="form-control" placeholder="Branch Manager Phone">
            </div>

            <div class="col-md-3">
                <label class="form-label">Branch Manager Notes</label>
                <input type="text" name="bm_notes" class="form-control" placeholder="Branch Manager Notes">
            </div>
        </fieldset>

        <fieldset class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Territory Manager Name</label>
                <select name="tt_name" class="form-control tt">
                <option value="">Select</option>
                <?php foreach ($tts as $store) { ?>
                   <option value="<?= $store->id ?>" 
                data-store='<?= json_encode($store, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
            <?= htmlspecialchars($store->store_location, ENT_QUOTES, 'UTF-8') ?>
        </option>
                <?php } ?>
                </select>
            </div>

             <div class="col-md-3">
                <label class="form-label">Territory Manager Email</label>
                <input type="text" name="tt_email" class="form-control" placeholder="Territory Manager Email">
            </div>

            <div class="col-md-3">
                <label class="form-label">Territory Manager Phone</label>
                <input type="text" name="tt_phone" class="form-control" placeholder="Territory Manager Phone">
            </div>

            <div class="col-md-3">
                <label class="form-label">Territory Manager Notes</label>
                <input type="text" name="tt_notes" class="form-control" placeholder="Territory Manager Notes">
            </div>
        </fieldset>

        `,
        Installer: `
            <div class="col-md-3">
                <label class="form-label">Installer Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter installer name" required>
            </div>
 
            <div class="col-md-3">
                <label class="form-label">Contact Information (Email)</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
        <span class="email-error" style="color: red; display: none;"></span>
            </div>

             <div class="col-md-3">
                <label class="form-label">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Password" required minlength="8">
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Information (Phone Number)</label>
                <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" required>
        <span class="phone-error" style="color: red; display: none;"></span>
            </div>
            <div class="col-md-3">
                <label class="form-label">Address</label>
                 <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
            </div>
             <div class="col-md-3">
                <label class="form-label">Country</label>
                 <input type="text" name="country" class="form-control" placeholder="Country">
            </div>


            <div class="col-md-3">
                <label class="form-label">State</label>
                 
                 <select class="form-control" name="state" required >
                    <option value="">Select</option>
                 <?php foreach ($timezones as $timezone) { ?>
                  
                  <option value="<?=$timezone->state_name?>"><?=$timezone->state_name?></option>
                  <?php } ?>
                  </select>

                  
            </div>

             <div class="col-md-3">
                <label class="form-label">City</label>
                 <input type="text" name="city" class="form-control" placeholder="City">
            </div>


            <div class="col-md-3">
                <label class="form-label">Zipcode</label>
                 <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
            </div>`
};

function showFields() {
    const type = document.getElementById('type').value;
    const dynamicFields = document.getElementById('dynamic-fields');
    dynamicFields.innerHTML = fieldsData[type] || '';
}

document.addEventListener("DOMContentLoaded", function() {
        var typeSelect = document.getElementById("type");
        if (typeSelect.value !== "") {
            typeSelect.dispatchEvent(new Event("change"));
        }
    });

document.addEventListener('change', function(event) {
    if (event.target.classList.contains('store')) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        const storeData = selectedOption.getAttribute('data-store');
        if (storeData) {
            try {
                const parsedData = JSON.parse(storeData);
                
                document.querySelector('input[name="store_state"]').value = parsedData.store_state || ''; 
                document.querySelector('input[name="store_email"]').value = parsedData.email || ''; 
                document.querySelector('input[name="store_phone"]').value = parsedData.phone || ''; 
                
            } catch (e) {
                console.error("Error parsing store data: ", e.message);
            }
        }
    }
});


document.addEventListener('change', function(event) {
    if (event.target.classList.contains('bm')) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        const storeData = selectedOption.getAttribute('data-store');
        if (storeData) {
            try {
                const parsedData = JSON.parse(storeData);
                
                document.querySelector('input[name="bm_email"]').value = parsedData.email || ''; 
                document.querySelector('input[name="bm_phone"]').value = parsedData.phone || ''; 
                document.querySelector('input[name="bm_notes"]').value = parsedData.notes || ''; 
                
            } catch (e) {
                console.error("Error parsing store data: ", e.message);
            }
        }
    }
});

document.addEventListener('change', function(event) {
    if (event.target.classList.contains('tt')) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        const storeData = selectedOption.getAttribute('data-store');
        if (storeData) {
            try {
                const parsedData = JSON.parse(storeData);
                
                document.querySelector('input[name="tt_email"]').value = parsedData.email || ''; 
                document.querySelector('input[name="tt_phone"]').value = parsedData.phone || ''; 
                document.querySelector('input[name="tt_notes"]').value = parsedData.notes || ''; 
                
            } catch (e) {
                console.error("Error parsing store data: ", e.message);
            }
        }
    }
});
</script>

<script>
$(document).ready(function() {
    // Handle Select All checkbox change
    $('#select-all').on('change', function() {
        const isChecked = $(this).is(':checked');

        $('#permissions1 option').prop('selected', isChecked);
        $('#permissions1').trigger('change'); // Trigger change to update any plugins
    });

    // Update Select All checkbox based on individual selections
    $('#permissions1').on('change', function() {
        const allSelected = $('#permissions1 option').length === $('#permissions1 option:selected')
            .length;
        $('#select-all').prop('checked', allSelected);
    });
});
</script>
@endsection