<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="id-wrapper">

    <div class="id-card student-card" id="card">

        <div class="card-content">

            <!-- LEFT SIDE -->
            <div class="id-left">

                <div class="id-header">
                    @if(Auth::user()->institution_logo)
                    <img src="{{ asset(Auth::user()->institution_logo) }}" class="institution-logo">
                    @endif
                    <div class="id-title">STUDENT ID</div>
                    <div class="id-subtitle">IDENTITY CARD</div>
                </div>

                <div class="info">
                    <div class="row">
                        <span>Institution</span>
                        <p>{{ Auth::user()->institution_name ?? Auth::user()->school ?? 'International University' }}</p>
                    </div>

                    <div class="row">
                        <span>Name</span>
                        <p>{{ strtoupper(Auth::user()->full_name) }}</p>
                    </div>

                    <div class="row">
                        <span>Email</span>
                        <p>{{ Auth::user()->email }}</p>
                    </div>

                    <div class="row">
                        <span>Age</span>
                        <p>{{ Auth::user()->age ?? 'N/A' }} Years</p>
                    </div>
                </div>

            </div>


            <!-- RIGHT SIDE -->
            <div class="id-right">

                <img src="{{ asset(Auth::user()->image ?? 'uploads/default.png') }}" class="id-photo">

                <div class="phone">
                    <i class="fa fa-phone"></i>
                    {{ Auth::user()->phone_number }}
                </div>

            </div>

        </div>

    </div>

</div>


<!-- DOWNLOAD BUTTON -->
<div class="text-center mt-4">
    <button onclick="downloadCard()" class="download-btn">
        <i class="fa fa-download"></i> Download ID Card
    </button>
</div>


<style>

/* page wrapper */

.id-wrapper{
    
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#e8f6f3,#f2f4f4);
}


/* main card */

.id-card{
    width:720px;
    height:400px;
    border-radius:18px;
    padding:30px;
    position:relative;
    overflow:hidden;
    box-shadow:0 25px 45px rgba(0,0,0,0.18);
}

.institution-logo{
    max-width:70px;
    max-height:70px;
    object-fit:contain;
    margin-bottom:8px;
}


/* gradient background */

.student-card{
    background:linear-gradient(135deg,#1abc9c,#16a085,#0e6655);
    color:#fff;
}


/* card flex */

.card-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    height:100%;
}


/* left side */

.id-left{
    width:60%;
}

.id-title{
    font-size:34px;
    font-weight:800;
    letter-spacing:2px;
}

.id-subtitle{
    font-size:13px;
    letter-spacing:3px;
    margin-bottom:25px;
    opacity:.8;
}


.row span{
    font-size:12px;
    opacity:.8;
}

.row p{
    font-size:17px;
    font-weight:600;
    margin-bottom:16px;
}


/* right side */

.id-right{
    text-align:center;
    width:35%;
}


/* photo */

.id-photo{
    width:170px;
    height:200px;
    border-radius:12px;
    object-fit:cover;
    border:6px solid rgba(255,255,255,.4);
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}


/* phone */

.phone{
    margin-top:15px;
    font-size:15px;
    letter-spacing:1px;
}


/* download button */

.download-btn{
    background:#1abc9c;
    border:none;
    padding:12px 25px;
    border-radius:6px;
    color:#fff;
    font-weight:600;
    cursor:pointer;
}

.download-btn:hover{
    background:#16a085;
}

</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>

function downloadCard(){

    html2canvas(document.getElementById("card")).then(canvas => {

        const link = document.createElement('a');
        link.download = 'student-id-card.png';
        link.href = canvas.toDataURL();
        link.click();

    });

}

</script>
