<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="id-wrapper">

    <div class="id-card teacher-card" id="card">

        <div class="card-content">

            <!-- LEFT SIDE -->
            <div class="id-left">

                <div class="id-header">
                    <div class="id-title">TEACHER ID</div>
                    <div class="id-subtitle">IDENTITY CARD</div>
                </div>

                <div class="info">

                    <div class="row">
                        <span>School</span>
                        <p>{{ Auth::user()->school ?? 'International University' }}</p>
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
                        <span>Department</span>
                        <p>{{ Auth::user()->department ?? 'Teaching Department' }}</p>
                    </div>

                    <div class="row">
                        <span>Subject</span>
                        <p>{{ Auth::user()->subject ?? 'General Studies' }}</p>
                    </div>

                </div>

            </div>


            <!-- RIGHT SIDE -->
            <div class="id-right">

                <img src="{{ asset(Auth::user()->image ?? 'uploads/default.png') }}" class="id-photo">

                <div class="teacher-id">
                    <i class="fa fa-id-badge"></i>
                    ID: {{ Auth::user()->teacher_id ?? 'TCH-001' }}
                </div>

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
        <i class="fa fa-download"></i> Download Teacher Card
    </button>
</div>


<style>

/* page wrapper */

.id-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:80vh;
    background:linear-gradient(135deg,#eef2f7,#f8f9fa);
}


/* card */

.id-card{
    width:720px;
    height:400px;
    border-radius:18px;
    padding:30px;
    position:relative;
    overflow:hidden;
    box-shadow:0 25px 45px rgba(0,0,0,0.18);
}


/* teacher background */

.teacher-card{
    background:linear-gradient(135deg,#4e54c8,#5f6cff,#6c63ff);
    color:#fff;
}


/* flex layout */

.card-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    height:100%;
}


/* left */

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
    opacity:.85;
}


/* rows */

.row span{
    font-size:12px;
    opacity:.85;
}

.row p{
    font-size:17px;
    font-weight:600;
    margin-bottom:14px;
}


/* right */

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
    border:6px solid rgba(255,255,255,.35);
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}


/* teacher id */

.teacher-id{
    margin-top:12px;
    font-size:15px;
    letter-spacing:1px;
}


/* phone */

.phone{
    margin-top:8px;
    font-size:14px;
}


/* download button */

.download-btn{
    background:#4e54c8;
    border:none;
    padding:12px 25px;
    border-radius:6px;
    color:#fff;
    font-weight:600;
    cursor:pointer;
}

.download-btn:hover{
    background:#3d43a5;
}

</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>

function downloadCard(){

    html2canvas(document.getElementById("card")).then(canvas => {

        const link = document.createElement('a');
        link.download = 'teacher-id-card.png';
        link.href = canvas.toDataURL();
        link.click();

    });

}

</script>