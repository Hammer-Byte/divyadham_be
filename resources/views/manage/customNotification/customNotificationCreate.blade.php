@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="custom-notification-form" method="post" action="{{route('manage.customNotificationSend')}}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-3">
                            <label for="title" class="form-label">Notification Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="Enter notification title" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="message" class="form-label">Notification Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="6" placeholder="Enter notification message">{{old('message')}}</textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-3">
                            <label class="form-label">Send To <span class="text-danger">*</span></label>
                            <div class="mt-2">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="send_to" id="send_to_all" value="all_users" {{old('send_to') == 'all_users' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="send_to_all">
                                        <strong>All Users</strong>
                                        <small class="text-muted d-block">Send notification to all registered users</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="send_to" id="send_to_committee" value="committee_members" {{old('send_to') == 'committee_members' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="send_to_committee">
                                        <strong>Only Committee Members</strong>
                                        <small class="text-muted d-block">Send notification only to committee members</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle"></i>
                                <strong>Note:</strong> Notifications will be sent via push notification (FCM) to users with device tokens and saved in the database for all selected users.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.customNotification')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Send Notification</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        $("#custom-notification-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                message: {
                    required: true,
                    minlength: 3,
                    maxlength: 1000
                },
                send_to: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "The title field is required",
                    minlength: "Title must be at least 3 characters long",
                    maxlength: "Title must not exceed 255 characters"
                },
                message: {
                    required: "The message field is required",
                    minlength: "Message must be at least 3 characters long",
                    maxlength: "Message must not exceed 1000 characters"
                },
                send_to: {
                    required: "Please select who to send the notification to"
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
                if (element.attr("type") == "radio") {
                    error.insertAfter(element.closest('.form-check').parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                // Show confirmation before sending
                if (confirm('Are you sure you want to send this notification to all selected users?')) {
                    form.submit();
                }
            }
        });

        // Character counter for message
        $('#message').on('input', function() {
            var length = $(this).val().length;
            var maxLength = 1000;
            if (length > maxLength) {
                $(this).val($(this).val().substring(0, maxLength));
            }
        });
    });
</script>
@append

