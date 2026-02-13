@extends('layouts.admin')
@section('title', 'Spin & Win')

@section('content')

<style>

/* ================= PAGE ================= */

.spin-page{
    min-height:90vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: radial-gradient(circle at top,#1f2a44,#0c1220);
}

/* ================= CONTAINER ================= */

.spin-container{
    text-align:center;
    color:white;
}

.spin-container h1{
    margin-bottom:40px;
    font-weight:800;
}

/* ================= WHEEL ================= */

.wheel-wrapper{
    position:relative;
    width:420px;
    height:420px;
    margin:auto;
}

/* pointer */

.pointer{
    width:0;
    height:0;
    border-left:26px solid transparent;
    border-right:26px solid transparent;
    border-top:55px solid #ff4757;
    position:absolute;
    left:50%;
    transform:translateX(-50%);
    z-index:10;
}

/* wheel */

.wheel{
    width:100%;
    height:100%;
    border-radius:50%;
    overflow:hidden;
    position:relative;
    border:18px solid #111827;
    box-shadow:
        0 0 45px rgba(255,255,255,.15),
        inset 0 0 60px rgba(0,0,0,.9);

    /* IMPORTANT FOR SPIN */
    transform:rotate(0deg);
    transition: transform 6s cubic-bezier(.17,.67,.12,.99);
}

/* segments */

.segment{
    position:absolute;
    width:50%;
    height:50%;
    top:50%;
    left:50%;
    transform-origin:0% 0%;
    display:flex;
    align-items:center;
    justify-content:center;
    padding-left:60px;
    font-size:18px;
    font-weight:700;
}

/* colors */

.seg1{ background:#ff3b3b; transform:rotate(0deg) skewY(-30deg);}
.seg2{ background:#9b59b6; transform:rotate(60deg) skewY(-30deg);}
.seg3{ background:#00d2d3; transform:rotate(120deg) skewY(-30deg);}
.seg4{ background:#feca57; transform:rotate(180deg) skewY(-30deg);}
.seg5{ background:#54a0ff; transform:rotate(240deg) skewY(-30deg);}
.seg6{ background:#1dd1a1; transform:rotate(300deg) skewY(-30deg);}

.segment span{
    transform:skewY(30deg) rotate(30deg);
    width:160px;
}

/* center spin button */

.spin-center{
    position:absolute;
    width:120px;
    height:120px;
    background:white;
    border-radius:50%;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:900;
    color:#111;
    cursor:pointer;
    z-index:20;
    box-shadow:0 0 25px rgba(255,255,255,.9);
    transition:.3s;
}

.spin-center:hover{
    transform:translate(-50%,-50%) scale(1.08);
}

/* popup */

.result{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.75);
    display:flex;
    align-items:center;
    justify-content:center;
    visibility:hidden;
    opacity:0;
    transition:.4s;
    z-index:999;
}

.result.show{
    visibility:visible;
    opacity:1;
}

.result-box{
    background:white;
    padding:45px 65px;
    border-radius:20px;
    text-align:center;
}

.close-btn{
    margin-top:25px;
    padding:12px 30px;
    border:none;
    background:#111827;
    color:white;
    border-radius:30px;
    cursor:pointer;
}

/* confetti */

.confetti{
    position:fixed;
    width:12px;
    height:12px;
    top:-10px;
    animation:fall linear forwards;
}

@keyframes fall{
    to{
        transform:translateY(110vh) rotate(720deg);
        opacity:0;
    }
}

/* mobile */

@media(max-width:600px){
    .wheel-wrapper{
        width:280px;
        height:280px;
    }

    .spin-center{
        width:85px;
        height:85px;
        font-size:14px;
    }
}

</style>

<div class="spin-page">

 
<div class="spin-container">

    <h1>🎁 Spin & Win Mega Rewards</h1>

    <div class="wheel-wrapper">

        <div class="pointer"></div>

        <div class="wheel" id="wheel">

            <div class="segment seg1"><span>🎧 Headphones</span></div>
            <div class="segment seg2"><span>📱 iPhone</span></div>
            <div class="segment seg3"><span>💳 Gift Card</span></div>
            <div class="segment seg4"><span>⌚ Smart Watch</span></div>
            <div class="segment seg5"><span>🎮 PlayStation</span></div>
            <div class="segment seg6"><span>💻 Laptop</span></div>

        </div>

        <div class="spin-center" onclick="spinWheel()">SPIN</div>

    </div>

</div>
```

</div>

<!-- RESULT POPUP -->

<div class="result" id="resultPopup">
    <div class="result-box">
        <h2>🎉 Congratulations!</h2>
        <h3 id="prizeText"></h3>
        <button class="close-btn" onclick="closePopup()">Awesome!</button>
    </div>
</div>

<script>

/* FIXED PROFESSIONAL SPIN LOGIC */

let spinning = false;
let currentRotation = 0;

const prizes = [
"🎧 Headphones",
"📱 iPhone",
"💳 Gift Card",
"⌚ Smart Watch",
"🎮 PlayStation",
"💻 Laptop"
];

function spinWheel(){

    if(spinning) return;

    spinning = true;

    const wheel = document.getElementById("wheel");

    const segmentAngle = 360 / prizes.length;

    const winnerIndex = Math.floor(Math.random() * prizes.length);

    /* rotate MANY TIMES for realistic casino effect */
    const extraSpins = 6;

    const finalRotation =
        currentRotation +
        (extraSpins * 360) +
        (360 - (winnerIndex * segmentAngle)) -
        (segmentAngle / 2);

    currentRotation = finalRotation;

    wheel.style.transform = `rotate(${finalRotation}deg)`;

    setTimeout(()=>{

        document.getElementById("prizeText").innerHTML = prizes[winnerIndex];

        document.getElementById("resultPopup").classList.add("show");

        createConfetti();

        spinning = false;

    },6000);
}

function closePopup(){
    document.getElementById("resultPopup").classList.remove("show");
}

/* CONFETTI */

function createConfetti(){

    for(let i=0;i<150;i++){

        let conf = document.createElement("div");

        conf.className = "confetti";

        conf.style.left = Math.random()*100+"vw";

        conf.style.background = `hsl(${Math.random()*360},100%,50%)`;

        conf.style.animationDuration = (Math.random()*3+2)+"s";

        document.body.appendChild(conf);

        setTimeout(()=>conf.remove(),5000);
    }
}

</script>

@endsection
