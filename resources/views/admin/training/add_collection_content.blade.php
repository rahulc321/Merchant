@extends('layouts.admin')
@section('title', 'AetherSmart - Create Task')
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
                        <li class="breadcrumb-item active" aria-current="page">Create Collection</li>
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
                        Create Collection to {{ $collection->title }}
                    </div>
                </div>
                <div class="card-body">


                    <form action="{{ route('admin.contentsStore', $collection->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label>Step</label>
                            <input type="number" name="step" class="form-control" value="1" required>
                        </div> -->

                        <div class="mb-3">
                            <label>Content Type</label>
                            <select name="type" class="form-control" id="type-select" required>
                                <option value="">-- Select --</option>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="mcq">MCQ</option>
                                <option value="text">Text</option>
                            </select>
                        </div>

                        <div class="mb-3" id="file-upload" style="display: none;">
                            <label>Upload File</label>
                            <input type="file" name="file" class="form-control">
                        </div>

                        <div id="mcq-section" style="display: none;">
                            <div class="mb-3">
                                <label>Question</label>
                                <input type="text" name="question" class="form-control">
                            </div>

                            <label>Options</label>
                            @for ($i = 0; $i < 4; $i++) <div class="input-group mb-2">
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="{{ $i }}">
                                </div>
                                <input type="text" name="options[]" class="form-control"
                                    placeholder="Option {{ $i + 1 }}">
                        </div>
                        @endfor
                </div>

                <div class="mb-3" id="text-section" style="display: none;">
                    <label>Text Content</label>
                    <textarea name="text_content" class="form-control" id="text-content-editor" rows="5"></textarea>
                </div>

                <button class="btn btn-primary">Add Content</button>
                <a href="{{url('/admin/addContent')}}/{{$collection->id}}" class="btn btn-warning">Back</a>
                </form>


            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<script>
document.getElementById('type-select').addEventListener('change', function() {
    const type = this.value;

    document.getElementById('file-upload').style.display = (type === 'video' || type === 'image') ? 'block' :
        'none';
    document.getElementById('mcq-section').style.display = (type === 'mcq') ? 'block' : 'none';
    document.getElementById('text-section').style.display = (type === 'text') ? 'block' : 'none';

    // initialize CKEditor only once
    if (type == 'text' && !CKEDITOR.instances['text-content-editor']) {
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
});
</script>


@endsection