@extends('layouts.admin')
@section('title', 'AetherSmart - Training')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.carousel-control-prev,
.carousel-control-next {
    display: none !important;
}

.form-check {
    position: relative;
    display: flex;
    align-items: center;
    padding: 5px 24px;
    border: 1.5px solid #d1d5db;
    /* Tailwind gray-300 */
    border-radius: 12px;
    background-color: #fff;
    transition: border-color 0.3s, box-shadow 0.3s, background-color 0.3s;
    margin-bottom: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    cursor: pointer;
    user-select: none;
}

.form-check:hover {
    border-color: #3b82f6;
    /* Tailwind blue-500 */
    background-color: #f0f9ff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}

.form-check-input {
    position: relative;
    width: 18px;
    height: 18px;
    margin-right: 14px;
    accent-color: #3b82f6;
    /* modern blue */
    flex-shrink: 0;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.form-check-label {
    font-size: 16px;
    line-height: 1.5;
    color: #1f2937;
    /* Tailwind gray-800 */
    font-weight: 500;
    flex-grow: 1;
}

.form-check-input:checked+.form-check-label {
    color: #2563eb;
    /* blue-600 */
    font-weight: 600;
}

.form-check-input:focus-visible {
    outline: none;
    box-shadow: 0 0 0 2px #93c5fd;
    /* blue-300 focus ring */
}

/* Selected visual highlight */
.form-check.selected {
    border-color: #2563eb;
    background-color: #eff6ff;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
}
</style>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Training</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0 rounded">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">Training List</h5>
                        @if (Auth::user()->roles->contains('title', 'Admin'))
                        <a href="{{ route('admin.trainingCreate') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-2"></i>Create New Training
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-hover table-bordered text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        @if (Auth::user()->roles->contains('title', 'Admin'))
                                        <!-- <th>Role</th> -->
                                        @endif
                                        <th>Training Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainings as $key => $value)

                                    <?php
                                         //echo '<pre>';print_r($value->viewedByUser);
                                        $is_view = 0;
                                         if($value->viewedByUser){
                                            $is_view = 1;
                                         }
                                    ?>
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-medium text-dark">{{ $value->title }}</td>
                                        <td class="fw-medium text-dark">{{ $value->description }}</td>
                                        <!-- <td>
                                            <div class="video-container position-relative">
                                                <video class="video-player shadow-sm rounded <?php if($is_view == 1){ echo 'watch-g'; }else{ echo 'watch-r'; }  ?>" width="320" height="180"
                                                    controls id="videoPlayer_{{ $value->id }}"
                                                    video_time="{{ $value->video_time }}"
                                                    onplay="trackPlayTime('{{ $value->id }}')"
                                                    onended="markVideoAsWatched('{{ $value->id }}', '{{ Auth::id() }}')">
                                                    <source src="{{ asset($value->video_url) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                                <div class="mt-2">
                                                    <input type="text" id="playTime_{{ $value->id }}" readonly
                                                        class="form-control play-time text-center"
                                                        placeholder="Play Time">
                                                </div>
                                                <div id="animation_{{ $value->id }}" class="flower-animation">
                                                    🌸
                                                </div>
                                            </div>
                                        </td> -->
                                        @if (Auth::user()->roles->contains('title', 'Admin'))
                                        <!-- <td class="text-capitalize">{{ $value->role }}</td> -->
                                        @endif
                                        <td>
                                            <span
                                                class="badge {{ $value->is_completed == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                                {{ $value->is_completed == 1 ? 'Completed' : 'Pending' }}
                                            </span>
                                        </td>

                                        <td>
                                            @if (Auth::user()->roles->contains('title', 'Admin'))



                                            <div class="d-flex justify-content-center gap-2">

                                                <a class="btn btn-sm btn-info shadow-sm"
                                                    href="{{route('admin.addContent',[$value->id])}}">Add Content</a>

                                                <button class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="if(confirm('Are you sure you want to delete this?')) { document.getElementById('deleteFrm{{ $key }}').submit(); }">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                                <form id="deleteFrm{{ $key }}"
                                                    action="{{ route('admin.trainingDelete', $value->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>

                                            @else
                                            <a href="javascript:;" data-bs-toggle="modal" class="view-training"
                                                data-training-id="{{ $value->id }}"
                                                data-bs-target="#trainingModal_{{ $value->id }}">
                                                <span class="badge bg-outline-info">View Training</span>
                                            </a>

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

<style>
.table thead th {
    text-transform: uppercase;
    font-size: 14px;
    background: #343a40;
    color: #fff;
}

.confetti-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: 9999;
}

.confetti {
    position: absolute;
    border-radius: 50%;
    opacity: 0.9;
}

.confetti--animation-slow {
    animation: confetti-fall 6s linear infinite;
}

.confetti--animation-medium {
    animation: confetti-fall 4s linear infinite;
}

.confetti--animation-fast {
    animation: confetti-fall 2s linear infinite;
}

@keyframes confetti-fall {
    to {
        transform: translateY(100vh) rotateZ(360deg);
    }
}

.border {
    border: 1px solid rgba(255, 255, 255, 0.9) !important;
}
.tj {
    
    background: transparent !important;
   // border: none;
}
</style>

@foreach($trainings as $training)
<!-- Modal for training ID {{ $training->id }} -->
<div class="modal fade" id="trainingModal_{{ $training->id }}" tabindex="-1"
    aria-labelledby="trainingModalLabel_{{ $training->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-2">
            <div class="modal-header">
                <h5 style="color:white" class="modal-title" id="trainingModalLabel_{{ $training->id }}">
                    {{ $training->title }} - Content
                </h5>
                <input type="hidden" name="isAns" class="isAns" value="{{$training->is_completed}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> &nbsp;&nbsp;
                <button type="button" class="btn btn-sm btn-light me-2 toggle-modal-fullscreen tj"
                    data-modal="#trainingModal_{{ $training->id }}" title="Toggle Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>
                
            </div>
            <div class="modal-body">

                @if(count($training->contents))
                <div id="trainingSlider_{{ $training->id }}" class="carousel slide mb-4" data-bs-ride="false"
                    data-bs-interval="false">
                    <div class="carousel-inner">
                        @foreach($training->contents as $index => $content)
                        <div class="carousel-item @if($loop->first) active @endif">
                            <div class="text-center p-4 border1 rounded1 bg-dark1 shadow-sm">
                                <h5 class="mb-3 text-primary con">{{ $content->content }}</h5>

                                @if($content->type == 'image')
                                <img src="{{ asset($content->file) }}" class="img-fluid rounded"
                                    style="max-height:300px;" alt="Image">
                                @elseif($content->type == 'text')

                                <div class="mb-3">
                                    <!-- <label>Text Content</label> -->
                                    <div class="border p-3 rounded">
                                        {!! $content->text_content !!}
                                    </div>
                                </div>

                                @elseif($content->type == 'video')
                                <video controls class="rounded" style="max-height:300px;">
                                    <source src="{{ asset($content->file) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @elseif($content->type == 'mcq')
                                <div class="text-start mb-4">
                                    @if($content->mcqQuestions->isEmpty())
                                    <p class="text-danger">No questions found for this content.</p>
                                    @else
                                    @foreach($content->mcqQuestions as $question)

                                    <p><strong class="con">Q{{ $loop->iteration }}: {{ $question->question }}</strong>
                                    </p>
                                    @foreach($question->options as $option)
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input mcq-option"
                                            name="question_{{ $question->id }}" data-question-id="{{ $question->id }}"
                                            value="{{ $option }}" @if(@$question->user_selected_text == $option->option)
                                        checked @endif
                                        >
                                        <label class="form-check-label">{{ $option->option }}</label>
                                    </div>
                                    @endforeach
                                    @endforeach


                                    @endif
                                </div>
                                @endif

                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Custom Prev, Next and Finish buttons -->
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button class="btn btn-outline-secondary btn-sm custom-prev-btn"
                            data-target="#trainingSlider_{{ $training->id }}">
                            <i class="fas fa-chevron-left me-1"></i> Prev
                        </button>
                        <button class="btn btn-outline-secondary btn-sm custom-next-btn"
                            data-target="#trainingSlider_{{ $training->id }}">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </button>
                        <button class="btn btn-success btn-sm d-none finish-btn" data-training-id="{{ $training->id }}">
                            <i class="fas fa-check-circle me-1"></i> Finish
                        </button>


                    </div>
                    <div class="slide-count text-muted1 mt-2 text-center w-100">
                        Slide <span class="current-slide">1</span> of {{ count($training->contents) }}
                    </div>

                </div>
                @else
                <div class="alert alert-warning text-center">No content available for this training.</div>
                @endif

            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Hide default carousel arrows -->
<style>
.carousel-control-prev,
.carousel-control-next {
    display: none !important;
}

.modal-content {
    color: var(--default-text-color);
    /* background-color: #0dcaf0; */
    border: 1px solid var(--default-border);
    border-radius: 0.3rem;
    /* background: url(../images/bg-modal.png) repeat, linear-gradient(to right, #003534, #a0a0a0); */
}

.slide-count.text-muted1.mt-2.text-center.w-100 {
    color: white;
}

.con {
    color: white !important;
}

.form-check {
    position: relative;
    display: flex;
    align-items: center;
    padding: 5px 24px;
    border: 1.5px solid #d1d5db;
    border-radius: 12px;
    background-color: #c1b7b7;
}
</style>
<style>
.modal-fullscreen-custom {
    position: fixed !important;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100vw;
    height: 100vh;
    margin: 0;
    z-index: 1060;
}

.modal-fullscreen-custom .modal-dialog {
    max-width: 100%;
    height: 100%;
    margin: 0;
}

.modal-fullscreen-custom .modal-content {
    height: 100%;
    overflow-y: auto;
}

.modal-fullscreen-custom .carousel-item img,
.modal-fullscreen-custom .carousel-item video {
    max-height: 60vh;
}
</style>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).on('click', '.toggle-modal-fullscreen', function() {
    var modalId = $(this).data('modal');
    var $modal = $(modalId);
    var $icon = $(this).find('i');

    $modal.toggleClass('modal-fullscreen-custom');

    if ($modal.hasClass('modal-fullscreen-custom')) {
        $icon.removeClass('fa-expand').addClass('fa-compress');
    } else {
        $icon.removeClass('fa-compress').addClass('fa-expand');
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".carousel").forEach(function(carousel) {
        const modalBody = carousel.closest('.modal-body');
        const currentSlideSpan = modalBody.querySelector('.current-slide');
        const slides = carousel.querySelectorAll(".carousel-item");

        const prevBtn = modalBody.querySelector(".custom-prev-btn");
        const nextBtn = modalBody.querySelector(".custom-next-btn");

        const updateSlideCount = () => {
            const activeIndex = Array.from(slides).findIndex(slide => slide.classList.contains(
                'active'));

            if (currentSlideSpan) {
                currentSlideSpan.textContent = activeIndex + 1;
            }

            // hide prev button on first slide
            if (prevBtn) {
                prevBtn.style.display = (activeIndex === 0) ? 'none' : '';
            }

            // hide next button on last slide
            if (nextBtn) {
                nextBtn.style.display = (activeIndex === slides.length - 1) ? 'none' : '';
            }
        };

        updateSlideCount(); // Initial update

        carousel.addEventListener('slid.bs.carousel', updateSlideCount);

        // Custom navigation buttons
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener("click", () => {
                bootstrap.Carousel.getInstance(carousel).prev();
            });
            nextBtn.addEventListener("click", () => {
                bootstrap.Carousel.getInstance(carousel).next();
            });
        }
    });
});
</script>

<script>
$(document).ready(function() {

    $('.isAns').each(function() {
        var isAns = $(this).val();
        if (isAns == 1) {
            // find the finish button in the same modal and hide it
            $(this).closest('.modal-content').find('.finish-btn').hide();
        }
    });

    const viewedSlidesMap = {};
    const mcqAnswers = {};

    $('.carousel').each(function() {
        const carouselId = $(this).attr('id');
        viewedSlidesMap[carouselId] = new Set();
        viewedSlidesMap[carouselId].add(0); // mark first slide as viewed

        const $firstSlide = $(this).find('.carousel-item').first();
        if ($firstSlide.find('.mcq-option').length > 0) {
            $(this).closest('.modal-body').find('.custom-next-btn').prop('disabled', true);
        }

        $(this).closest('.modal-body').find('.finish-btn').prop('disabled', true);
    });

    $('.carousel').on('slid.bs.carousel', function() {
        const $carousel = $(this);
        const carouselId = $carousel.attr('id');
        const currentIndex = $carousel.find('.carousel-item.active').index();
        viewedSlidesMap[carouselId].add(currentIndex);

        const totalSlides = $carousel.find('.carousel-item').length;
        const viewedCount = viewedSlidesMap[carouselId].size;

        const $finishBtn = $carousel.closest('.modal-body').find('.finish-btn[data-training-id]');
        const totalMcqQuestions = $carousel.find('.mcq-option')
            .map(function() {
                return $(this).data('question-id');
            }).get();
        const uniqueQuestionIds = [...new Set(totalMcqQuestions)];
        const allAnswered = uniqueQuestionIds.every(qid => mcqAnswers[qid] && mcqAnswers[qid].length >
            0);

        if (viewedCount === totalSlides) {
            $finishBtn.removeClass('d-none');
            if (allAnswered || uniqueQuestionIds.length === 0) {
                $finishBtn.prop('disabled', false);
            } else {
                $finishBtn.prop('disabled', true);
            }
        }

        // const $activeSlide = $carousel.find('.carousel-item.active');
        // const $nextBtn = $carousel.closest('.modal-body').find('.custom-next-btn');
        // if ($activeSlide.find('.mcq-option').length > 0) {
        //     $nextBtn.prop('disabled', true);
        // } else {
        //     $nextBtn.prop('disabled', false);
        // }

        const $activeSlide = $carousel.find('.carousel-item.active');
        const $nextBtn = $carousel.closest('.modal-body').find('.custom-next-btn');

        const questions = new Set();
        const answered = new Set();

        $activeSlide.find('.mcq-option:checked').each(function() {
            const qid = $(this).data('question-id');

            questions.add(qid);
            answered.add(qid);

            console.log("✔️ Answered QID:", qid, " -> ", mcqAnswers[qid]);
        });

        $activeSlide.find('.mcq-option').each(function() {
            const qid = $(this).data('question-id');

            questions.add(qid); // add all seen question IDs
        });

        //alert("Answered size: " + answered.size)

        if (questions.size === 0 || questions.size === answered.size) {
            $nextBtn.prop('disabled', false);
            // $('.finish-btn').hide();
        } else {
            $nextBtn.prop('disabled', true);
            $('.finish-btn').show();
        }

    });

    $(document).on('change', '.mcq-option', function() {
        const $activeSlide = $(this).closest('.carousel-item');
        const $nextBtn = $activeSlide.closest('.modal-body').find('.custom-next-btn');

        const questions = new Set();
        const answered = new Set();

        $activeSlide.find('.mcq-option').each(function() {
            const qid = $(this).data('question-id');
            questions.add(qid);

            if (!mcqAnswers[qid]) {
                mcqAnswers[qid] = [];
            }

            if ($(this).is(':checked')) {
                if (!mcqAnswers[qid].includes($(this).val())) {
                    mcqAnswers[qid].push($(this).val());
                }
            } else {
                mcqAnswers[qid] = mcqAnswers[qid].filter(val => val !== $(this).val());
            }

            if (mcqAnswers[qid].length > 0) {
                answered.add(qid);
            }
        });

        if (questions.size === answered.size) {
            $nextBtn.prop('disabled', false);
        } else {
            $nextBtn.prop('disabled', true);
        }

        $('.carousel').each(function() {
            const $carousel = $(this);
            const carouselId = $carousel.attr('id');
            const totalSlides = $carousel.find('.carousel-item').length;
            const viewedCount = viewedSlidesMap[carouselId].size;

            const mcqIds = $carousel.find('.mcq-option')
                .map(function() {
                    return $(this).data('question-id');
                }).get();
            const uniqueMcqs = [...new Set(mcqIds)];
            const allAnswered = uniqueMcqs.every(qid => mcqAnswers[qid] && mcqAnswers[qid]
                .length > 0);

            const $finishBtn = $carousel.closest('.modal-body').find(
                '.finish-btn[data-training-id]');
            if (viewedCount === totalSlides) {
                $finishBtn.removeClass('d-none');
                if (allAnswered || uniqueMcqs.length === 0) {
                    $finishBtn.prop('disabled', false);
                } else {
                    $finishBtn.prop('disabled', true);
                }
            }
        });
    });

    $('.custom-next-btn').on('click', function() {
        const target = $(this).data('target');
        $(target).carousel('next');
    });

    $('.custom-prev-btn').on('click', function() {
        const target = $(this).data('target');
        $(target).carousel('prev');
    });

    $('.finish-btn').on('click', function() {
        const $btn = $(this);
        const trainingId = $btn.data('training-id');
        const $carousel = $('#trainingSlider_' + trainingId);
        const totalSlides = $carousel.find('.carousel-item').length;
        const viewedCount = viewedSlidesMap[$carousel.attr('id')].size;

        if (viewedCount < totalSlides) {
            alert("Please view all content before finishing.");
            return;
        }

        $.ajax({
            url: '/admin/saveMcqAnswers',
            method: 'POST',
            data: {
                training_id: trainingId,
                mcq_answers: mcqAnswers,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                alert(
                    'Training completed! You will receive your certificate shortly. Please wait for some time.'
                );

                location.reload();
            },
            error: function() {
                alert('Something went wrong while submitting.');
            }
        });
    });
});
</script>





<script>
function startConfetti() {
    const Confettiful = function() {
        this.containerEl = null;
        this.confettiColors = ['#EF2964', '#00C09D', '#2D87B0', '#48485E', '#EFFF1D'];
        this.confettiAnimations = ['slow', 'medium', 'fast'];

        this._setupElements();
        this._renderConfetti();
    };

    Confettiful.prototype._setupElements = function() {
        this.containerEl = document.createElement('div');
        this.containerEl.classList.add('confetti-container');
        document.body.appendChild(this.containerEl);
    };

    Confettiful.prototype._renderConfetti = function() {
        this.confettiInterval = setInterval(() => {
            const confettiEl = document.createElement('div');
            const size = (Math.random() * 7 + 3) + 'px';
            const color = this.confettiColors[Math.floor(Math.random() * this.confettiColors.length)];
            const left = (Math.random() * window.innerWidth) + 'px';
            const animation = this.confettiAnimations[Math.floor(Math.random() * this.confettiAnimations
                .length)];

            confettiEl.classList.add('confetti', `confetti--animation-${animation}`);
            confettiEl.style.cssText = `
                    left: ${left};
                    width: ${size};
                    height: ${size};
                    background-color: ${color};
                    top: 0;
                    position: fixed;
                `;

            this.containerEl.appendChild(confettiEl);
            setTimeout(() => confettiEl.remove(), 3000);
        }, 9);

        setTimeout(() => {
            clearInterval(this.confettiInterval);
            setTimeout(() => this.containerEl?.remove(), 1000);
        }, 9000);
    };

    new Confettiful();
}

// 🟢 Example: run it on page load
// document.addEventListener("DOMContentLoaded", function () {
//     var count = 1; // replace with your logic
//     if (count === 1 || count === 2 || count === 3) {
//         startConfetti();
//     }
// });
</script>

@if(session('confetti'))
<script>
startConfetti();
</script>

@php
session()->forget('confetti');
@endphp
@endif



@endsection