@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="{{@$method == 'Add' ? 'event-add-form' : 'event-update-form'}}" method="post" action="{{@$method == 'Add' ? route('manage.eventAdd') : route('manage.eventUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$event->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{@$event ? @$event->title : old('title')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$event ? @$event->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="banner_upload_type" class="form-label">Banner Upload Type</label>
                            <select id="banner_upload_type" name="banner_upload_type" class="form-control select2">
                                @php
                                    $selectedMediaUploadType = @$event ? @$event->banner_upload_type : old('banner_upload_type');
                                @endphp
                                <option value="">Select Banner Upload Type</option>
                                <option {{$selectedMediaUploadType == 'file_upload' ? 'selected' : ''}} value="file_upload">File Upload</option>
                                <option {{$selectedMediaUploadType == 'url' ? 'selected' : ''}} value="url">URL</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 banner_type_file_wrapper d-none">
                            <label for="banner_type_file" class="form-label">Banner File</label>
                            <div class="input-group">
                                <input type="file" class="form-control  group-input" id="banner_type_file" name="banner_type_file">
                            </div>
                        </div>
                        <div class="col-12 mb-1 banner_type_url_wrapper d-none">
                            <label for="banner_type_url" class="form-label">Banner URL</label>
                            <input type="text" class="form-control" id="banner_type_url" name="banner_type_url" value="{{@$event ? @$event->banner_image_url : old('banner_type_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="event_image_upload_type" class="form-label">Event Image Upload Type</label>
                            <select id="event_image_upload_type" name="event_image_upload_type" class="form-control select2">
                                @php
                                    $selectedMediaUploadType = @$event ? @$event->event_image_upload_type : old('event_image_upload_type');
                                @endphp
                                <option value="">Select Event Image Upload Type</option>
                                <option {{$selectedMediaUploadType == 'file_upload' ? 'selected' : ''}} value="file_upload">File Upload</option>
                                <option {{$selectedMediaUploadType == 'url' ? 'selected' : ''}} value="url">URL</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 event_image_type_file_wrapper d-none">
                            <label for="event_image_type_file" class="form-label">Event Image File</label>
                            <div class="input-group">
                                <input type="file" class="form-control  group-input" id="event_image_type_file" name="event_image_type_file">
                            </div>
                        </div>
                        <div class="col-12 mb-1 event_image_type_url_wrapper d-none">
                            <label for="event_image_type_url" class="form-label">Event Image URL</label>
                            <input type="text" class="form-control" id="event_image_type_url" name="event_image_type_url" value="{{@$event ? @$event->event_image_url : old('event_image_type_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="organizers" class="form-label">Organizers</label>
                            <select id="organizers" name="organizers[]" class="form-control select2" multiple>
                                @php
                                    $selectedOrganizers = @$event ? explode(',',@$event->organizers) : [];
                                @endphp
                                <option value="">Select Organizers</option>
                                @foreach ($organizers as $key => $organizer)
                                    <option {{in_array($organizer->id, $selectedOrganizers) ? 'selected' : ''}} value="{{ $organizer->id }}">{{ @$organizer->getUser->first_name .' '. @$organizer->getUser->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{@$event ? @$event->start_date : old('start_date')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{@$event ? @$event->end_date : old('end_date')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{@$event ? @$event->location : old('location')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{@$event ? @$event->latitude : old('latitude')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{@$event ? @$event->longitude : old('longitude')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$event ? @$event->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.events')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        showHideBannerMediaFields($('#banner_upload_type').val())

        $('#banner_upload_type').change(function () {
            var selectedVal = $(this).val()
            showHideBannerMediaFields(selectedVal)
        })

        function showHideBannerMediaFields(selectedVal) {
            if (selectedVal == 'file_upload') {
                $('.banner_type_file_wrapper').removeClass('d-none')
                $('.banner_type_url_wrapper').addClass('d-none')
            }else if (selectedVal == 'url'){
                $('.banner_type_file_wrapper').addClass('d-none')
                $('.banner_type_url_wrapper').removeClass('d-none')
            }
        }

        showHideEventImageMediaFields($('#event_image_upload_type').val())

        $('#event_image_upload_type').change(function () {
            var selectedVal = $(this).val()
            showHideEventImageMediaFields(selectedVal)
        })

        function showHideEventImageMediaFields(selectedVal) {
            if (selectedVal == 'file_upload') {
                $('.event_image_type_file_wrapper').removeClass('d-none')
                $('.event_image_type_url_wrapper').addClass('d-none')
            }else if (selectedVal == 'url'){
                $('.event_image_type_file_wrapper').addClass('d-none')
                $('.event_image_type_url_wrapper').removeClass('d-none')
            }
        }

        $("#event-add-form").validate({
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
                banner_upload_type: {
                    required: true,
                },
                banner_type_file: {
                    required: true,
                    extension: "jpg|jpeg|png",
                },
                banner_type_url: {
                    required: true,
                    url: true,
                },
                event_image_upload_type: {
                    required: true,
                },
                event_image_type_file: {
                    required: true,
                    extension: "jpg|jpeg|png",
                },
                event_image_type_url: {
                    required: true,
                    url: true,
                },
                organizers: {
                    required: true,
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
                location: {
                    required: true,
                },
                latitude: {
                    required: true,
                },
                longitude: {
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
                banner_upload_type: {
                    required: "The banner upload type field is required",
                },
                banner_type_file: {
                    required: "The banner file field is required",
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                banner_type_url: {
                    required: "The banner url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                event_image_upload_type: {
                    required: "The event image upload type field is required",
                },
                event_image_type_file: {
                    required: "The banner event image file field is required",
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                event_image_type_url: {
                    required: "The event image url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                organizers: {
                    required: "The organizers field is required",
                },
                start_date: {
                    required: "The start date field is required",
                },
                end_date: {
                    required: "The end date field is required",
                },
                location: {
                    required: "The location date field is required",
                },
                latitude: {
                    required: "The latitude date field is required",
                },
                longitude: {
                    required: "The longitude date field is required",
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

        $("#event-update-form").validate({
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
                banner_upload_type: {
                    required: true,
                },
                banner_type_file: {
                    extension: "jpg|jpeg|png",
                },
                banner_type_url: {
                    required: true,
                    url: true,
                },
                event_image_upload_type: {
                    required: true,
                },
                event_image_type_file: {
                    extension: "jpg|jpeg|png",
                },
                event_image_type_url: {
                    required: true,
                    url: true,
                },
                organizers: {
                    required: true,
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
                location: {
                    required: true,
                },
                latitude: {
                    required: true,
                },
                longitude: {
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
                banner_upload_type: {
                    required: "The banner upload type field is required",
                },
                banner_type_file: {
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                banner_type_url: {
                    required: "The banner url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                event_image_upload_type: {
                    required: "The event image upload type field is required",
                },
                event_image_type_file: {
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                event_image_type_url: {
                    required: "The event image url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                organizers: {
                    required: "The organizers field is required",
                },
                start_date: {
                    required: "The start date field is required",
                },
                end_date: {
                    required: "The end date field is required",
                },
                location: {
                    required: "The location date field is required",
                },
                latitude: {
                    required: "The latitude date field is required",
                },
                longitude: {
                    required: "The longitude date field is required",
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
        $("#banner_upload_type, #event_image_upload_type, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
