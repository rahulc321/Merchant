@extends('layouts.admin')
@section('title', 'AetherSmart - Training')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    background-color: #0f172a;
    color: #e2e8f0;
    font-family: Arial, sans-serif;
}

.header-card {
    background: linear-gradient(135deg, hsl(220, 25%, 12%) 0%, hsl(204, 54%, 25%) 50%, hsl(220, 30%, 20%) 100%) !important;
    border-radius: 10px;
    padding: 20px;
}

.progress {
    height: 8px;
}

.progress-bar {
    background-color: #38bdf8;
}

.module-card {
    background-color: #1e293b;
    border-radius: 10px;
    padding: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

}

.module-card:hover {

    box-shadow: rgb(55 84 113) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
    transform: translateY(-2px);
}

.status-btn {
    font-size: 0.85rem;
    border-radius: 6px;
    padding: 5px 12px;
    font-weight: 500;
}

.btn-completed {
    background-color: #22c55e;
    color: white;
}

.btn-review {
    background-color: #334155;
    color: white;
}

.btn-start {
    background-color: #0ea5e9;
    color: white;
}

.footer-card {
    background: linear-gradient(135deg, hsl(220, 25%, 12%) 0%, hsl(204, 54%, 25%) 50%, hsl(220, 30%, 20%) 100%);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

.module-icon-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background-color: #334155;
    padding: 6px 10px;
    border-radius: 8px;
}

.module-icon-badge svg {
    width: 20px;
    height: 20px;
    color: #38bdf8;
}

.module-check {
    color: #22c55e;
}

.module-footer {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.footer-icon {
    width: 48px;
    height: 48px;
    color: #38bdf8;
    margin-bottom: 10px;
}
</style>

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

.abc {
    font-weight: 700 !important;
    font-size: 1.875rem !important;
    line-height: 2.25rem !important;
    color: white !important;
}

/* .small, small {
    font-size: .875em;
    font-size: 1.125rem;
    line-height: 1.75rem;
}
p.mb-0.text-white-50 {
    font-size: 1.125rem;
    line-height: 1.75rem;
    font-weight: 300;
} */

.module-icon-badge {

    box-shadow: rgb(55 84 113) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
}
</style>
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

.fw-bold{
    color:white;
}

.bg-21 {

    box-shadow: rgb(55 84 113) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;
    background: linear-gradient(135deg, hsl(220, 25%, 12%) 0%, hsl(204, 54%, 25%) 50%, hsl(220, 30%, 20%) 100%);
}
</style>


<div class="main-content app-content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-xl-12">
                <div class="container-fluid my-4">

                    <!-- Header -->
                    <div class="header-card mb-4 p-3 rounded"
                        style="background: linear-gradient(90deg, #1a2c3d, #123040);">
                        <div class="d-flex align-items-center mb-3">
                            <!-- Icon with background -->
                            <div class="d-flex align-items-center justify-content-center me-3"
                                style="width: 42px; height: 42px; background-color: rgba(255,255,255,0.1); border-radius: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-wifi">
                                    <path d="M12 20h.01"></path>
                                    <path d="M2 8.82a15 15 0 0 1 20 0"></path>
                                    <path d="M5 12.859a10 10 0 0 1 14 0"></path>
                                    <path d="M8.5 16.429a5 5 0 0 1 7 0"></path>
                                </svg>
                            </div>
                            <div>
                                <?php
                                    $catName = DB::table('categories')->where('id',@$_REQUEST['category'])->first();
                                ?>
                                <h5 class="fw-bold mb-0 abc">{{@$catName->name}}</h5>
                                <p class="mb-0 text-white-50">Complete your certification journey</p>
                            </div>
                        </div>

                        @php
                        $totalModules = $trainings->count();
                        $completedModules = $trainings->where('is_completed', true)->count();
                        $pendingModules = $totalModules - $completedModules;

                        // Avoid division by zero
                        $completionPercent = $totalModules > 0
                        ? round(($completedModules / $totalModules) * 100)
                        : 0;
                        @endphp

                        <div class="p-3 rounded" style="background-color: rgba(255,255,255,0.1);">
                            <div class="d-flex justify-content-between mb-1 fw-bold">
                                <small>Overall Progress</small>
                                <small>{{ $completedModules }}/{{ $totalModules }} Modules</small>
                            </div>
                            <div class="progress"
                                style="height: 10px; border-radius: 50px; background-color: rgba(255,255,255,0.2);">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $completionPercent }}%; background: linear-gradient(90deg, #72e6ff, #4da8ff); border-radius: 50px;">
                                </div>
                            </div>
                            <small class="text-white-50">{{ $completionPercent }}% Complete | {{ $pendingModules }}
                                Pending</small>
                        </div>
                    </div>




                    <!-- Modules -->
                    <div class="row g-3">
                        <!-- Module 1 -->
                        @foreach($trainings as $key => $value)
                        <div class="col-md-4 col-sm-6">
                            <div class="module-card">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="module-icon-badge">
                                            <!-- Award Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                                </path>
                                                <circle cx="12" cy="8" r="6"></circle>
                                            </svg>
                                            <span>{{$key+1}}</span>
                                        </div>
                                        <span class="module-check">✔</span>
                                    </div>

                                    <h6 class="fw-bold">{{ $value->title }}</h6>
                                    <p class="small mb-2">{{ $value->description }}</p>
                                    <small>&nbsp; {{$value->contents->count()}} Slides</small>
                                </div>
                                <div class="module-footer">
                                    @if($value->is_completed == 1)
                                    <span class="btn btn-outline-success status-btn">Completed</span>
                                    @else
                                    <span class="btn btn-outline-warning">Pending</span>
                                    @endif


                                    @if($value->is_completed == 1)

                                    <a href="javascript:;" class="btn btn-outline-info view-training"
                                        data-bs-toggle="modal" data-training-id="{{ $value->id }}"
                                        data-bs-target="#trainingModal_{{ $value->id }}">Review ▷</a>

                                    @else
                                    <a href="javascript:;" class="btn btn-outline-info view-training"
                                        data-bs-toggle="modal" data-training-id="{{ $value->id }}"
                                        data-bs-target="#trainingModal_{{ $value->id }}">
                                        Start &#9654;
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Footer -->

                    <div class="footer-card mt-4">
                        <!-- SVG Award Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="footer-icon" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path
                                d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                            </path>
                            <circle cx="12" cy="8" r="6"></circle>
                        </svg>
                        <h6 class="fw-bold">aetherPro Certification</h6>
                        <p class="small mb-3">Complete all training modules to earn your official aetherPro
                            installer certification</p>

                        <small class="d-block mt-2">{{ $completedModules }} of {{ $totalModules }} Modules completed • {{ $completionPercent }}% progress</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@foreach($trainings as $training)
<!-- Modal for training ID {{ $training->id }} -->
<div class="modal fade" id="trainingModal_{{ $training->id }}" tabindex="-1"
    aria-labelledby="trainingModalLabel_{{ $training->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-21">
            <div class="modal-header">
                <h5 style="color:white" class="modal-title" id="trainingModalLabel_{{ $training->id }}">
                    {{ $training->title }} - Content
                </h5>
                <input type="hidden" name="isAns" class="isAns" value="{{$training->is_completed}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                &nbsp;&nbsp;
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