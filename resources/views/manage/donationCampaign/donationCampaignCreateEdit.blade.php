@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="{{@$method == 'Add' ? 'donation-add' : 'donation-edit'}}" method="post" action="{{@$method == 'Add' ? route('manage.donationCampaignAdd') : route('manage.donationCampaignUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$donationCampaign->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{@$donationCampaign ? @$donationCampaign->title : old('title')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$donationCampaign ? @$donationCampaign->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="donation_type" class="form-label">Donation Type</label>
                            <select id="donation_type" name="donation_type" class="form-control select2">
                                @php
                                    $selectedDonationType = @$donationCampaign ? @$donationCampaign->donation_type : old('donation_type');
                                @endphp
                                <option value="">Select Donation Type</option>
                                <option {{$selectedDonationType == 1 ? 'selected' : ''}} value="1">Fixed Donation</option>
                                <option {{$selectedDonationType == 2 ? 'selected' : ''}} value="2">Goal-Based Donation</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="goal_amount" class="form-label">Goal Amount</label>
                            <input type="text" class="form-control" id="goal_amount" name="goal_amount" value="{{@$donationCampaign ? @$donationCampaign->goal_amount : old('goal_amount')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 raise_amount_wrapper">
                            <label for="raise_amount" class="form-label">Raise Amount</label>
                            <input type="text" class="form-control" id="raise_amount" name="raise_amount" value="{{@$donationCampaign ? @$donationCampaign->raise_amount : old('raise_amount')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 start_date_wrapper">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{@$donationCampaign ? @$donationCampaign->start_date : old('start_date')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1 end_date_wrapper">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{@$donationCampaign ? @$donationCampaign->end_date : old('end_date')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="banner_upload_type" class="form-label">Banner Upload Type</label>
                            <select id="banner_upload_type" name="banner_upload_type" class="form-control select2">
                                @php
                                    $selectedMediaUploadType = @$donationCampaign ? @$donationCampaign->banner_upload_type : old('banner_upload_type');
                                @endphp
                                <option value="">Select Media Upload Type</option>
                                <option {{$selectedMediaUploadType == 'file_upload' ? 'selected' : ''}} value="file_upload">File Upload</option>
                                <option {{$selectedMediaUploadType == 'url' ? 'selected' : ''}} value="url">URL</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 media_type_file_wrapper d-none">
                            <label for="media_type_file" class="form-label">Banner File</label>
                            <div class="input-group">
                                <input type="file" class="form-control  group-input" id="media_type_file" name="media_type_file">
                            </div>
                        </div>
                        <div class="col-12 mb-1 media_type_url_wrapper d-none">
                            <label for="media_type_url" class="form-label">Banner URL</label>
                            <input type="text" class="form-control" id="media_type_url" name="media_type_url" value="{{@$donationCampaign ? @$donationCampaign->banner_image_url : old('media_type_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="organizers" class="form-label">Organizers</label>
                            <select id="organizers" name="organizers[]" class="form-control select2" multiple>
                                @php
                                    $selectedOrganizers = @$donationCampaign ? explode(',',@$donationCampaign->organizers) : [];
                                @endphp
                                <option value="">Select Organizers</option>
                                @foreach ($organizers as $key => $organizer)
                                    <option {{in_array($organizer->id, $selectedOrganizers) ? 'selected' : ''}} value="{{ $organizer->id }}">{{ @$organizer->getUser->first_name .' '. @$organizer->getUser->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$donationCampaign ? @$donationCampaign->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.donationCampaigns')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(window).on('load', function() {
        setTimeout(function () {
            $('#donation_type').trigger('change');
        }, 200);
    });

    $(document).ready(function() {
        showHideMediaFields($('#banner_upload_type').val())

        $('#banner_upload_type').change(function () {
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

        $('#donation_type').change(function () {
            var donationType = $('#donation_type').val()
            if (donationType == 1) {
                $('.raise_amount_wrapper').hide()
                $('.start_date_wrapper').hide()
                $('.end_date_wrapper').hide()
            }else if (donationType == 2){
                $('.raise_amount_wrapper').show()
                $('.start_date_wrapper').show()
                $('.end_date_wrapper').show()
            }
        })

        $("#donation-add").validate({
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
                goal_amount: {
                    decimalNumber: true,
                },
                raise_amount: {
                    decimalNumber: true,
                },
                banner_upload_type: {
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
                organizers: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "The title field is required",
                    minlength: "Title be at least 3 characters long"
                },
                description: {
                    required: "The description field is required",
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
                },
                banner_upload_type: {
                    required: "The banner upload type field is required",
                },
                media_type_file: {
                    required: "The banner file field is required",
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                media_type_url: {
                    required: "The banner url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                organizers: {
                    required: "The organizers field is required",
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


        $("#donation-edit").validate({
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
                donation_type: {
                    required: true,
                },
                goal_amount: {
                    decimalNumber: true,
                },
                raise_amount: {
                    decimalNumber: true,
                },
                banner_upload_type: {
                    required: true,
                },
                media_type_file: {
                    extension: "jpg|jpeg|png",
                },
                media_type_url: {
                    required: true,
                    url: true,
                },
                organizers: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "The title field is required",
                    minlength: "Title be at least 3 characters long"
                },
                description: {
                    required: "The description field is required",
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
                },
                donation_type: {
                    required: "The donation type field is required",
                },
                banner_upload_type: {
                    required: "The banner upload type field is required",
                },
                media_type_file: {
                    extension: "Only jpg, jpeg and png formats are allowed",
                },
                media_type_url: {
                    required: "The banner url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
                },
                organizers: {
                    required: "The organizers field is required",
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
        $("#organizers, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
