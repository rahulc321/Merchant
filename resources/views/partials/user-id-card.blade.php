@php
    $user = $user ?? Auth::user();
    $type = strtolower($user->type ?? optional($user->roles->first())->title ?? 'normal');

    if ($user->roles->contains('title', 'Student')) {
        $type = 'student';
    } elseif ($user->roles->contains('title', 'Teacher')) {
        $type = 'teacher';
    } elseif ($user->roles->contains('title', 'Youth')) {
        $type = 'youth';
    } elseif ($type === 'end_user') {
        $type = 'normal';
    }

    $config = [
        'student' => [
            'class' => 'id-card-student',
            'title' => 'STUDENT ID',
            'subtitle' => 'LEARNING CARD',
            'id' => 'STD-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'primaryLabel' => 'Institution',
            'primaryValue' => $user->institution_name ?? $user->school ?? 'LMS Learning Management',
        ],
        'teacher' => [
            'class' => 'id-card-teacher',
            'title' => 'TEACHER ID',
            'subtitle' => 'FACULTY CARD',
            'id' => 'TCH-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'primaryLabel' => 'Institution',
            'primaryValue' => $user->institution_name ?? $user->school ?? 'LMS Learning Management',
        ],
        'youth' => [
            'class' => 'id-card-youth',
            'title' => 'YOUTH ID',
            'subtitle' => 'MEMBER CARD',
            'id' => 'YTH-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'primaryLabel' => 'Organization',
            'primaryValue' => $user->organization ?? 'LMS Learning Management',
        ],
        'normal' => [
            'class' => 'id-card-normal',
            'title' => 'USER ID',
            'subtitle' => 'MEMBER CARD',
            'id' => 'USR-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            'primaryLabel' => 'Organization',
            'primaryValue' => $user->organization ?? 'LMS Learning Management',
        ],
    ];

    $card = $config[$type] ?? $config['normal'];
    $dob = $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d M Y') : 'N/A';
    $photo = $user->image ? asset($user->image) : asset('uploads/default.png');
@endphp

<div class="glossy-id-wrap">
    <div class="glossy-id-card {{ $card['class'] }}" id="userIdCard">
        <div class="id-shine"></div>

        <div class="id-card-left">
            <div class="id-card-heading">
                @if(in_array($type, ['student', 'teacher']) && $user->institution_logo)
                    <img src="{{ asset($user->institution_logo) }}" class="id-card-logo" alt="Institution logo">
                @endif
                <div>
                    <h2>{{ $card['title'] }}</h2>
                    <span>{{ $card['subtitle'] }}</span>
                </div>
            </div>

            <div class="id-card-fields">
                <div class="id-card-field id-card-field-wide">
                    <small>{{ $card['primaryLabel'] }}</small>
                    <strong>{{ strtoupper($card['primaryValue']) }}</strong>
                </div>

                <div class="id-card-field">
                    <small>Name</small>
                    <strong>{{ strtoupper($user->full_name ?? 'N/A') }}</strong>
                </div>

                <div class="id-card-field">
                    <small>Email</small>
                    <strong>{{ $user->email ?? 'N/A' }}</strong>
                </div>

                <div class="id-card-field">
                    <small>DOB</small>
                    <strong>{{ $dob }}</strong>
                </div>

                <div class="id-card-field">
                    <small>Member Since</small>
                    <strong>{{ optional($user->created_at)->format('Y') ?? date('Y') }}</strong>
                </div>

                @if($type === 'teacher')
                    <div class="id-card-field">
                        <small>Department</small>
                        <strong>{{ $user->department ?? 'N/A' }}</strong>
                    </div>
                    <div class="id-card-field">
                        <small>Subject</small>
                        <strong>{{ $user->subject ?? 'N/A' }}</strong>
                    </div>
                @endif

                @if($type === 'student' && $user->parent_email)
                    <div class="id-card-field id-card-field-wide">
                        <small>Parent Email</small>
                        <strong>{{ $user->parent_email }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="id-card-right">
            <div class="id-photo-frame">
                <img src="{{ $photo }}" class="id-card-photo" alt="Profile photo">
            </div>

            <div class="id-card-code">
                <div><i class="fa fa-id-card"></i> ID: {{ $card['id'] }}</div>
                <div><i class="fa fa-phone"></i> {{ $user->phone_number ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="id-card-actions">
        <button type="button" class="id-download-btn" onclick="downloadUserIdCard()">
            <i class="fa fa-download"></i> Download ID Card
        </button>
    </div>
</div>

@once
<style>
.glossy-id-wrap {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 18px;
}

.glossy-id-card {
    width: min(100%, 960px);
    aspect-ratio: 16 / 9;
    border-radius: 28px;
    padding: clamp(24px, 4vw, 42px);
    display: grid;
    grid-template-columns: minmax(0, 1.55fr) minmax(220px, .75fr);
    gap: 26px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 26px 70px rgba(18, 24, 38, .24);
    isolation: isolate;
}

.id-card-student {
    background: linear-gradient(135deg, #078f7f 0%, #15b8a6 48%, #75d9c7 100%);
}

.id-card-teacher {
    background: linear-gradient(135deg, #283593 0%, #5264d9 48%, #94a3ff 100%);
}

.id-card-youth {
    background: linear-gradient(135deg, #ff7a18 0%, #ffac33 48%, #ffd36a 100%);
}

.id-card-normal {
    background: linear-gradient(135deg, #20242d 0%, #536171 50%, #e25d52 100%);
}

.id-shine {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(115deg, rgba(255,255,255,.34), rgba(255,255,255,0) 38%),
        radial-gradient(circle at 78% 8%, rgba(255,255,255,.34), rgba(255,255,255,0) 28%);
    opacity: .68;
    z-index: -1;
}

.id-card-left,
.id-card-right {
    min-width: 0;
}

.id-card-heading {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: clamp(22px, 3vw, 36px);
}

.id-card-logo {
    width: 70px;
    height: 70px;
    object-fit: contain;
    border-radius: 14px;
    padding: 7px;
    background: rgba(255,255,255,.88);
}

.id-card-heading h2 {
    margin: 0;
    font-size: clamp(34px, 5vw, 58px);
    line-height: .98;
    font-weight: 800;
    letter-spacing: 0;
}

.id-card-heading span {
    display: block;
    margin-top: 12px;
    font-size: clamp(14px, 2vw, 21px);
    font-weight: 700;
    letter-spacing: 8px;
}

.id-card-fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px 24px;
}

.id-card-field {
    min-width: 0;
}

.id-card-field-wide {
    grid-column: 1 / -1;
}

.id-card-field small {
    display: block;
    font-size: clamp(13px, 1.5vw, 17px);
    line-height: 1.2;
    color: rgba(255,255,255,.86);
    margin-bottom: 7px;
}

.id-card-field strong {
    display: block;
    font-size: clamp(16px, 2.3vw, 25px);
    line-height: 1.14;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.id-card-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 24px;
}

.id-photo-frame {
    width: min(100%, 228px);
    aspect-ratio: 1 / 1.18;
    border-radius: 18px;
    padding: 9px;
    background: rgba(255,255,255,.34);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.38), 0 16px 34px rgba(0,0,0,.16);
}

.id-card-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 13px;
    display: block;
}

.id-card-code {
    display: grid;
    gap: 11px;
    width: 100%;
    font-size: clamp(16px, 2.2vw, 24px);
    font-weight: 700;
}

.id-card-code div {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
}

.id-card-actions {
    display: flex;
    justify-content: center;
}

.id-download-btn {
    border: 0;
    border-radius: 10px;
    padding: 13px 20px;
    color: #fff;
    background: #111827;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 14px 24px rgba(17, 24, 39, .16);
}

@media (max-width: 760px) {
    .glossy-id-card {
        aspect-ratio: auto;
        min-height: 0;
        grid-template-columns: 1fr;
        padding: 24px;
        border-radius: 20px;
    }

    .id-card-heading span {
        letter-spacing: 4px;
    }

    .id-card-fields {
        grid-template-columns: 1fr;
    }

    .id-card-right {
        align-items: flex-start;
    }

    .id-photo-frame {
        width: 170px;
    }

    .id-card-code div {
        justify-content: flex-start;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadUserIdCard() {
    var card = document.getElementById('userIdCard');
    if (!card || typeof html2canvas === 'undefined') {
        return;
    }

    html2canvas(card, { scale: 2, useCORS: true }).then(function(canvas) {
        var link = document.createElement('a');
        link.download = 'user-id-card.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
}
</script>
@endonce
