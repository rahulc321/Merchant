@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Task')
@section('content')
<style>

.cke_notification_warning {
    background: #c83939;
    border: 1px solid #902b2b;
    display: none;
}

</style>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Collection</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Edit Content for {{ $collection->title }}
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{route('admin.updateContent',$content->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" value="{{ old('title', $content->content) }}"
                                class="form-control" required >
                        </div>

                        <div class="mb-3">
                            <label>Content Type</label>
                            <select name="type" class="form-control" id="type-select" required readonly>
                                <option value="">-- Select --</option>
                                <option value="image" {{ $content->type == 'image' ? 'selected' : '' }}>Image</option>
                                <option value="video" {{ $content->type == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="mcq" {{ $content->type == 'mcq' ? 'selected' : '' }}>MCQ</option>
                                <option value="text" {{ $content->type == 'text' ? 'selected' : '' }}>Text</option>
                            </select>
                        </div>

                        <div class="mb-3" id="file-upload" style="display: none;">
                            <label>Upload File</label>
                            <input type="file" name="file" class="form-control">
                            @if ($content->type == 'image' || $content->type == 'video')
                            <div class="mt-2">
                                <small>Current file: <a href="{{ asset('/' . $content->file) }}"
                                        target="_blank">View</a></small>
                            </div>
                            @endif
                        </div>

                        @if ($content->type === 'mcq')
                        <div id="mcq-section">
                            <div class="mb-3">
                                <label>Question</label>
                                <input type="text" name="question" class="form-control"
                                    value="{{ $question->question ?? '' }}">
                            </div>

                            <label>Options</label>
                            @for ($i = 0; $i < 4; $i++) <div class="input-group mb-2">
                                <?php //dd($options[0]->is_correct); ?>
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="{{ $i }}" @if ($options[$i]->is_correct ==1) checked
                                    @endif>
                                </div>
                                <input type="text" name="options[]" class="form-control"
                                    value="{{ $options[$i]->option ?? '' }}" placeholder="Option {{ $i + 1 }}">
                        </div>
                        @endfor
                </div>
                @endif

                <div class="mb-3" id="text-section" style="display: none;">
                    <label>Text Content</label>
                    <textarea name="text_content" class="form-control" id="text-content-editor" rows="5">{{@$content->text_content}}</textarea>
                </div>

                <button class="btn btn-primary">Update Content</button>
                <a href="{{url('/admin/addContent')}}/{{$collection->id}}" class="btn btn-warning">Back</a>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // replace CKEditor only if the textarea exists
    const textEditor = document.getElementById('text-content-editor');
if (textEditor) {
    CKEDITOR.replace('text-content-editor', {
        allowedContent: true, // allow all HTML
        extraAllowedContent: '*(*);*{*}',
        contentsCss: [
            'https://cdn.ckeditor.com/4.22.1/full-all/contents.css',
            'data:text/css;charset=utf-8,' + encodeURIComponent(
                'body { background-color:#464646  !important; }'
            )
        ],

        toolbar: [
            { name: 'document', items: ['Source', '-', 'Preview', 'Print'] },
            { name: 'clipboard', items: ['Undo', 'Redo'] },
            { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
            { name: 'alignment', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Link', 'Unlink'] },
            { name: 'tools', items: ['Maximize'] }
        ],

        extraPlugins: 'colorbutton,font,justify,print,preview', // load extra features
        removeButtons: ''
    });
}


    function toggleSections() {
        const typeSelect = document.getElementById('type-select');
        if (!typeSelect) return;

        const type = typeSelect.value;

        const fileUpload = document.getElementById('file-upload');
        const mcqSection = document.getElementById('mcq-section');
        const textSection = document.getElementById('text-section');

        if (fileUpload) fileUpload.style.display = (type === 'image' || type === 'video') ? 'block' : 'none';
        if (mcqSection) mcqSection.style.display = (type === 'mcq') ? 'block' : 'none';
        if (textSection) textSection.style.display = (type === 'text') ? 'block' : 'none';
    }

    // bind the change event
    const typeSelect = document.getElementById('type-select');
    if (typeSelect) {
        typeSelect.addEventListener('change', toggleSections);
    }

    // initial toggle on page load
    toggleSections();
});
</script>
@endsection
 