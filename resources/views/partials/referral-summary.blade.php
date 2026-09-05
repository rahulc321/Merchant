@php
    $referralCode = $referralCode ?? $user->referral_code ?? null;
    $referralPoints = $referralPoints ?? $user->referral_points ?? 0;
    $referralLink = $referralLink ?? ($referralCode ? route('register', ['ref' => $referralCode]) : null);
@endphp

<div class="referral-summary">
    <div class="referral-card">
        <span>Your Referral Code</span>
        <strong>{{ $referralCode ?? 'N/A' }}</strong>
        @if($referralCode)
            <button type="button" class="referral-copy-btn" data-copy-text="{{ $referralCode }}">
                <i class="fa fa-copy"></i> Copy Code
            </button>
        @endif
    </div>
    <div class="referral-card referral-card-wide">
        <span>Your Referral Link</span>
        <strong class="referral-link-text">{{ $referralLink ?? 'N/A' }}</strong>
        @if($referralLink)
            <button type="button" class="referral-copy-btn" data-copy-text="{{ $referralLink }}">
                <i class="fa fa-link"></i> Copy Link
            </button>
        @endif
    </div>
    <div class="referral-card">
        <span>Referral Points</span>
        <strong>{{ (int) $referralPoints }}</strong>
    </div>
</div>

@once
    <script>
        document.addEventListener('click', function(event) {
            var button = event.target.closest('.referral-copy-btn');

            if (!button) {
                return;
            }

            var text = button.getAttribute('data-copy-text');
            var originalText = button.innerHTML;

            function markCopied() {
                button.innerHTML = '<i class="fa fa-check"></i> Copied';
                setTimeout(function() {
                    button.innerHTML = originalText;
                }, 1400);
            }

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(markCopied);
                return;
            }

            var input = document.createElement('input');
            input.value = text;
            input.style.position = 'fixed';
            input.style.opacity = '0';
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            markCopied();
        });
    </script>
@endonce
