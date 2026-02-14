@extends('layouts.admin')
@section('title', 'Spin & Win')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* PAGE */

.spin-page {
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at top, #1f2a44, #0c1220);
}

.spin-container {
    text-align: center;
    color: white;
}

/* WHEEL */

.wheel-wrapper {
    position: relative;
    width: 420px;
    height: 420px;
}

.pointer {
    width: 0;
    height: 0;
    border-left: 26px solid transparent;
    border-right: 26px solid transparent;
    border-top: 55px solid #ff4757;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

/* NEW CASINO WHEEL */

.wheel {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    position: relative;
    transition: transform 6s cubic-bezier(.17, .67, .12, .99);
    border: 18px solid #111827;
    box-shadow:
        0 0 45px rgba(255, 255, 255, .15),
        inset 0 0 60px rgba(0, 0, 0, .9);
}

/* labels */

.label {
    position: absolute;
    left: 50%;
    top: 50%;
    transform-origin: center;
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* center button */

.spin-center {
    position: absolute;
    width: 120px;
    height: 120px;
    background: white;
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    color: #111;
    cursor: pointer;
    /* z-index: 20; */
}

/* popup */

.result {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .75);
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    transition: .4s;
}

.result.show {
    visibility: visible;
    opacity: 1;
}

.result-box {
    background: white;
    padding: 45px 65px;
    border-radius: 20px;
    text-align: center;
}

/* mobile */

@media(max-width:600px) {
    .wheel-wrapper {
        width: 280px;
        height: 280px;
    }

    .spin-center {
        width: 80px;
        height: 80px;
    }
}
</style>

@php

$total = count($spData);
$angle = 360 / max($total,1);

$colors = [
'#ff3b3b','#9b59b6','#00d2d3','#feca57',
'#54a0ff','#1dd1a1','#ff9ff3','#48dbfb'
];

/* build gradient */
$gradient = "";
foreach($spData as $i=>$reward){
$start = $i*$angle;
$end = ($i+1)*$angle;
$color = $colors[$i % count($colors)];
$gradient .= "$color {$start}deg {$end}deg,";
}
$gradient = rtrim($gradient,',');

@endphp


<div class="spin-page">
    <div class="spin-container">

        <h1>🎁 Spin & Win Mega Rewards</h1>

        <div class="wheel-wrapper">

            <div class="pointer"></div>

            <div class="wheel" id="wheel" style="background: conic-gradient({{$gradient}})">

                {{-- LABELS --}}
                @foreach($spData as $index=>$reward)

                @php
                $rotate = ($index*$angle)+($angle/2);
                @endphp

                <div class="label" style="
transform:
rotate({{$rotate}}deg)
translate(140px)
rotate(-{{$rotate}}deg);
">

                    <i class="fa {{$reward->icon}}"></i>
                    {{$reward->rewardName->name}}

                </div>

                @endforeach

            </div>

            <div class="spin-center" onclick="spinWheel()">SPIN</div>

        </div>
    </div>
</div>

<!-- POPUP -->

<div class="result" id="popup">
    <div class="result-box">
        <h2>🎉 Congratulations!</h2>
        <h3 id="prize"></h3>
        <button onclick="closePopup()">Close</button>
    </div>
</div>

<script>

let spinning = false;

const prizes = @json(
$spData->map(fn($i)=>[
    'name'=>$i->rewardName->name,
    'icon'=>$i->icon
])->values()
);

function spinWheel(){

    if (spinning) return;
    spinning = true;

    const wheel = document.getElementById('wheel');

    const total = prizes.length;
    const slice = 360 / total;

    // 🎯 random winner
    const winnerIndex = Math.floor(Math.random() * total);

    // 🎰 random casino rounds (5–8)
    const randomRounds = Math.floor(Math.random() * 4) + 5;
    const extraSpins = randomRounds * 360;

    // 🎯 perfect top pointer alignment
    const targetAngle = 360 - (winnerIndex * slice) - (slice / 2);

    const finalRotation = extraSpins + targetAngle;

    wheel.style.transform = `rotate(${finalRotation}deg)`;

    setTimeout(() => {

        const prizeData = prizes[winnerIndex];

        updateOrderPrice(prizeData)

        document.getElementById('prize').innerHTML =
            `<i class="fa ${prizes[winnerIndex].icon}"></i>
             ${prizes[winnerIndex].name}`;

        document.getElementById('popup').classList.add('show');
        

        spinning = false;

    }, 6000);
}

function closePopup(){
    document.getElementById('popup').classList.remove('show');
    window.location.href = "/admin/orders";
}

function updateOrderPrice(prizeData) {

return fetch("{{ route('admin.updateOrderPrice') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({
        prize_name: prizeData.name,
        prize_icon: prizeData.icon,
        order_id: "{{ request('oid') }}"
    })
})
.then(res => res.json());
}

</script>

@endsection