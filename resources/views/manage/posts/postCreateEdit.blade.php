@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="{{@$method == 'Add' ? 'post-add' : 'post-edit'}}" method="post" action="{{@$method == 'Add' ? route('manage.postAdd') : route('manage.postUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$post->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="type" class="form-label">Post Type</label>
                            <select id="type" name="type" class="form-control select2">
                                @php
                                    $selectedType = @$post ? @$post->type : old('type');
                                @endphp
                                <option value="">Select Post Type</option>
                                @foreach (config('common.post_types') as $key=>$value)
                                    <option {{$selectedType == $key ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-1 content_wrapper">
                            <label for="content" class="form-label">Content</label>
                            <textarea type="text" class="form-control" id="content" name="content" aria-describedby="defaultFormControlHelp">{{@$post ? @$post->content : old('content')}}</textarea>
                        </div>
                        <div class="col-12 mb-1 link_title_wrapper">
                            <label for="link_title" class="form-label">Link Title</label>
                            <input type="text" class="form-control" id="link_title" name="link_title" value="{{@$post ? @$post->link_title : old('link_title')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 link_description_wrapper">
                            <label for="link_description" class="form-label">Link Description</label>
                            <textarea type="text" class="form-control" id="link_description" name="link_description" aria-describedby="defaultFormControlHelp">{{@$post ? @$post->link_description : old('link_description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1 link_url_wrapper">
                            <label for="link_url" class="form-label">URL</label>
                            <input type="text" class="form-control" id="link_url" name="link_url" value="{{@$post ? @$post->link_url : old('link_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 link_image_url_wrapper">
                            <label for="link_image_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="link_image_url" name="link_image_url" value="{{@$post ? @$post->link_image_url : old('link_image_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 media_upload_type_wrapper">
                            <label for="media_upload_type" class="form-label">Media Upload Type</label>
                            <select id="media_upload_type" name="media_upload_type" class="form-control select2">
                                @php
                                    $selectedMediaUploadType = @$post ? @$post->media_upload_type : old('media_upload_type');
                                @endphp
                                <option value="">Select Media Upload Type</option>
                                <option {{$selectedMediaUploadType == 'file_upload' ? 'selected' : ''}} value="file_upload">File Upload</option>
                                <option {{$selectedMediaUploadType == 'url' ? 'selected' : ''}} value="url">URL</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 media_type_file_wrapper">
                            <label for="media_type_file" class="form-label">Media File</label>
                            <div class="input-group">
                                <input type="file" class="form-control group-input" id="media_type_file" name="media_type_file[]" multiple>
                            </div>
                        </div>
                        <div class="col-12 mb-1 media_type_url_wrapper">
                            <label for="media_type_url" class="form-label">Media URL</label>
                            <input type="text" class="form-control" id="media_type_url" name="media_type_url" value="{{@$post && @$post->media_upload_type == 'url' ? @$post->media_url : old('media_type_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 media_type_wrapper">
                            <label for="media_type" class="form-label">Media Type</label>
                            <select id="media_type" name="media_type" class="form-control select2">
                                @php
                                    $selectedMediaType = @$post ? @$post->media_type : old('media_type');
                                @endphp
                                <option value="">Select Media Type</option>
                                <option {{$selectedMediaType == 'image' ? 'selected' : ''}} value="image">Image</option>
                                <option {{$selectedMediaType == 'video' ? 'selected' : ''}} value="video">Video</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 donation_id_wrapper">
                            <label for="donation_id" class="form-label">Donation</label>
                            <select id="donation_id" name="donation_id" class="form-control select2">
                                @php
                                    $selectedType = @$post ? @$post->donation_id : old('donation_id');
                                @endphp
                                <option value="0">Select Donation</option>
                                @foreach ($donations as $donation)
                                    <option {{$selectedType == $donation->id ? 'selected' : ''}} value="{{$donation->id}}">{{$donation->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$post ? @$post->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.posts')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(window).on('load', function() {
    });

    $(document).ready(function() {

        setTimeout(function () {
            showHideTypeFields($('#type').val())
        }, 200);

        $('#type').change(function () {
            var selectedVal = $(this).val()
            showHideTypeFields(selectedVal)
        })

        function showHideTypeFields(selectedVal) {
            if (selectedVal == 'text') {
                $('.content_wrapper').removeClass('d-none')
                $('.link_title_wrapper').addClass('d-none')
                $('.link_description_wrapper').addClass('d-none')
                $('.link_url_wrapper').addClass('d-none')
                $('.link_image_url_wrapper').addClass('d-none')
                $('.media_upload_type_wrapper').addClass('d-none')
                $('.media_type_file_wrapper').addClass('d-none')
                $('.media_type_url_wrapper').addClass('d-none')
                $('.media_type_wrapper').addClass('d-none')
                $('.donation_id_wrapper').addClass('d-none')
                $('#media_upload_type').val('').trigger('change')
            }else if (selectedVal == 'link'){
                $('.content_wrapper').addClass('d-none')
                $('.link_title_wrapper').removeClass('d-none')
                $('.link_description_wrapper').removeClass('d-none')
                $('.link_url_wrapper').removeClass('d-none')
                $('.link_image_url_wrapper').removeClass('d-none')
                $('.media_upload_type_wrapper').addClass('d-none')
                $('.media_type_file_wrapper').addClass('d-none')
                $('.media_type_url_wrapper').addClass('d-none')
                $('.media_type_wrapper').addClass('d-none')
                $('.donation_id_wrapper').addClass('d-none')
                $('#media_upload_type').val('').trigger('change')
            }else if (selectedVal == 'media'){
                $('.content_wrapper').addClass('d-none')
                $('.link_title_wrapper').addClass('d-none')
                $('.link_description_wrapper').addClass('d-none')
                $('.link_url_wrapper').addClass('d-none')
                $('.link_image_url_wrapper').addClass('d-none')
                $('.media_upload_type_wrapper').removeClass('d-none')
                $('.media_type_file_wrapper').addClass('d-none')
                $('.media_type_url_wrapper').addClass('d-none')
                $('.media_type_wrapper').removeClass('d-none')
                $('.donation_id_wrapper').addClass('d-none')
                showHideMediaFields($('#media_upload_type').val())
            }else if (selectedVal == 'donation'){
                $('.content_wrapper').addClass('d-none')
                $('.link_title_wrapper').addClass('d-none')
                $('.link_description_wrapper').addClass('d-none')
                $('.link_url_wrapper').addClass('d-none')
                $('.link_image_url_wrapper').addClass('d-none')
                $('.media_upload_type_wrapper').addClass('d-none')
                $('.media_type_file_wrapper').addClass('d-none')
                $('.media_type_url_wrapper').addClass('d-none')
                $('.media_type_wrapper').addClass('d-none')
                $('.donation_id_wrapper').removeClass('d-none')
                $('#media_upload_type').val('').trigger('change')
            }else{
                $('.content_wrapper').addClass('d-none')
                $('.link_title_wrapper').addClass('d-none')
                $('.link_description_wrapper').addClass('d-none')
                $('.link_url_wrapper').addClass('d-none')
                $('.link_image_url_wrapper').addClass('d-none')
                $('.media_upload_type_wrapper').addClass('d-none')
                $('.media_type_file_wrapper').addClass('d-none')
                $('.media_type_url_wrapper').addClass('d-none')
                $('.media_type_wrapper').addClass('d-none')
                $('.donation_id_wrapper').addClass('d-none')
            }

        }

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
        $("#post-add").validate({
            rules: {
                type: {
                    required: true,
                },
                content: {
                    required: true,
                },
                link_title: {
                    required: true,
                },
                link_description: {
                    required: true,
                },
                link_url: {
                    required: true,
                },
                link_image_url: {
                    required: true,
                },
                media_upload_type: {
                    required: true,
                },
                "media_type_file[]": {
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
                donation_id: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                type: {
                    required: "The post type field is required",
                },
                content: {
                    required: "The content field is required",
                },
                link_title: {
                    required: "The link title field is required",
                },
                link_description: {
                    required: "The link description field is required",
                },
                link_url: {
                    required: "The url field is required",
                },
                link_image_url: {
                    required: "The image url field is required",
                },media_upload_type: {
                    required: "The media upload type field is required",
                },
                "media_type_file[]": {
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
                donation_id: {
                    required: "The donation field is required",
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

        $("#post-edit").validate({
            rules: {
                type: {
                    required: true,
                },
                content: {
                    required: true,
                },
                link_title: {
                    required: true,
                },
                link_description: {
                    required: true,
                },
                link_url: {
                    required: true,
                },
                link_image_url: {
                    required: true,
                },
                media_upload_type: {
                    required: true,
                },
                "media_type_file[]": {
                    extension: "jpg|jpeg|png",
                },
                media_type_url: {
                    required: true,
                    url: true,
                },
                media_type: {
                    required: true,
                },
                donation_id: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                type: {
                    required: "The post type field is required",
                },
                content: {
                    required: "The content field is required",
                },
                link_title: {
                    required: "The link title field is required",
                },
                link_description: {
                    required: "The link description field is required",
                },
                link_url: {
                    required: "The url field is required",
                },
                link_image_url: {
                    required: "The image url field is required",
                },media_upload_type: {
                    required: "The media upload type field is required",
                },
                "media_type_file[]": {
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                media_type_url: {
                    required: "The media url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                media_type: {
                    required: "The media type field is required",
                },
                donation_id: {
                    required: "The donation field is required",
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
        $("#media_upload_type, #type, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
