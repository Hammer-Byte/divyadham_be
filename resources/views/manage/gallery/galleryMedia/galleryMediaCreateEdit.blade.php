@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="{{@$method == 'Add' ? 'gallery-media-form-add' : 'gallery-media-form-edit'}}" method="post" action="{{@$method == 'Add' ? route('manage.galleryMediaAdd') : route('manage.galleryMediaUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$galleryMedia->id}}" name="id"/>
            @endif
            <input type="hidden" value="{{$galleryId}}" name="folder_id"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{@$galleryMedia ? @$galleryMedia->title : old('title')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$galleryMedia ? @$galleryMedia->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="media_upload_type" class="form-label">Media Upload Type</label>
                            <select id="media_upload_type" name="media_upload_type" class="form-control select2">
                                @php
                                    $selectedMediaUploadType = @$galleryMedia ? @$galleryMedia->media_upload_type : old('media_upload_type');
                                @endphp
                                <option value="">Select Media Upload Type</option>
                                <option {{$selectedMediaUploadType == 'file_upload' ? 'selected' : ''}} value="file_upload">File Upload</option>
                                <option {{$selectedMediaUploadType == 'url' ? 'selected' : ''}} value="url">URL</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 media_type_file_wrapper d-none">
                            <label for="media_type_file" class="form-label">Media File</label>
                            <div class="input-group">
                                <input type="file" class="form-control  group-input" id="media_type_file" name="media_type_file">
                            </div>
                        </div>
                        <div class="col-12 mb-1 media_type_url_wrapper d-none">
                            <label for="media_type_url" class="form-label">Media URL</label>
                            <input type="text" class="form-control" id="media_type_url" name="media_type_url" value="{{@$galleryMedia ? @$galleryMedia->media_url : old('media_type_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="media_type" class="form-label">Media Type</label>
                            <select id="media_type" name="media_type" class="form-control select2">
                                @php
                                    $selectedMediaType = @$galleryMedia ? @$galleryMedia->media_type : old('media_type');
                                @endphp
                                <option value="">Select Media Type</option>
                                <option {{$selectedMediaType == 'image' ? 'selected' : ''}} value="image">Image</option>
                                <option {{$selectedMediaType == 'video' ? 'selected' : ''}} value="video">Video</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="position" class="form-label">Position</label>
                            <select id="position" name="position" class="form-control select2">
                                @php
                                    $selectedPosition = @$galleryMedia ? @$galleryMedia->position : old('position');
                                @endphp
                                <option value="">Select Media Type</option>
                                @php
                                    if (isset($galleryMedia)) {
                                        $addCount = 1;
                                    }else{
                                        $addCount = 2;
                                    }
                                @endphp
                                @for($i=1; $i < $indexCount + $addCount ; $i++)
                                    <option {{$selectedPosition == $i ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$galleryMedia ? @$galleryMedia->status : old('status');
                                @endphp
                                <option value="">Select Status</option>
                                <option {{$selectedStatus == '1' ? 'selected' : ''}} value="1">Active</option>
                                <option {{$selectedStatus == '0' ? 'selected' : ''}} value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.galleryView',['id' => $galleryId, 'currentTab' => 'navs-pills-gallery-media'])}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        showHideMediaFields($('#media_upload_type').val())

        $('#media_upload_type').change(function () {
            var selectedVal = $(this).val()
            showHideMediaFields(selectedVal)
        })

        function showHideMediaFields(selectedVal) {
            if (selectedVal == 'file_upload') {
                $('.media_type_file_wrapper').removeClass('d-none')
                $('.media_type_url_wrapper').addClass('d-none')
            }else if (selectedVal == 'url'){
                $('.media_type_file_wrapper').addClass('d-none')
                $('.media_type_url_wrapper').removeClass('d-none')
            }
        }
        $("#gallery-media-form-add").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },
                description: {
                    required: true,
                    minlength: 3,
                    maxlength: 500,
                },
                media_upload_type: {
                    required: true,
                },
                media_type_file: {
                    required: true,
                    extension: "jpg|jpeg|png",
                },
                media_type_url: {
                    required: true,
                    url: true,
                },
                media_type: {
                    required: true,
                },
                position: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "The title field is required",
                    minlength: "Title must be at least 3 characters long"
                },
                description: {
                    required: "The description field is required",
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
                },
                media_upload_type: {
                    required: "The media upload type field is required",
                },
                media_type_file: {
                    required: "The media file field is required",
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                media_type_url: {
                    required: "The media url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                media_type: {
                    required: "The media type field is required",
                },
                position: {
                    required: "The position field is required",
                },
                status: {
                    required: "The status field is required",
                }
            },
            errorElement: "div",
            errorClass: "text-danger",
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("select2-hidden-accessible")) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.hasClass("group-input")){
                    error.insertAfter(element.closest('.input-group'))
                }else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        $("#gallery-media-form-edit").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },
                description: {
                    required: true,
                    minlength: 3,
                    maxlength: 500,
                },
                media_upload_type: {
                    required: true,
                },
                media_type_file: {
                    extension: "jpg|jpeg|png",
                },
                media_type_url: {
                    required: true,
                    url: true,
                },
                media_type: {
                    required: true,
                },
                position: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "The title field is required",
                    minlength: "Title must be at least 3 characters long"
                },
                description: {
                    required: "The description field is required",
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
                },
                media_upload_type: {
                    required: "The media upload type field is required",
                },
                media_type_file: {
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                media_type_url: {
                    required: "The media url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                media_type: {
                    required: "The media type field is required",
                },
                position: {
                    required: "The position field is required",
                },
                status: {
                    required: "The status field is required",
                }
            },
            errorElement: "div",
            errorClass: "text-danger",
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("select2-hidden-accessible")) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.hasClass("group-input")){
                    error.insertAfter(element.closest('.input-group'))
                }else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

        // Manually validate Select2 fields on change
        $("#media_upload_type, #media_type, #position, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
