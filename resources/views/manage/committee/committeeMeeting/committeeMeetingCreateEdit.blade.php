@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="committee-meeting-form" method="post" action="{{@$method == 'Add' ? route('manage.committeeMeetingAdd') : route('manage.committeeMeetingUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$committeeMeeting->id}}" name="id"/>
            @endif
            <input type="hidden" value="{{$committeeId}}" name="committee_id"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="meeting_date" class="form-label">Meeting Date</label>
                            <input type="date" class="form-control" id="meeting_date" name="meeting_date" value="{{@$committeeMeeting ? @$committeeMeeting->meeting_date : old('meeting_date')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="agenda" class="form-label">Agenda</label>
                            <textarea type="text" class="form-control" id="agenda" name="agenda" aria-describedby="defaultFormControlHelp">{{@$committeeMeeting ? @$committeeMeeting->agenda : old('agenda')}}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="minutes" class="form-label">Minutes</label>
                            <input type="text" class="form-control" id="minutes" name="minutes" value="{{@$committeeMeeting ? @$committeeMeeting->minutes : old('minutes')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$committeeMeeting ? @$committeeMeeting->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.committeeView',['id' => $committeeId, 'currentTab' => 'navs-pills-committee-meetings'])}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        $("#committee-meeting-form").validate({
            rules: {
                meeting_date: {
                    required: true,
                },
                agenda: {
                    required: true,
                    minlength: 3,
                    maxlength: 500,
                },
                minutes: {
                    required: true,
                    digits: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                meeting_date: {
                    required: "The meeting date field is required",
                },
                agenda: {
                    required: "The agenda field is required",
                    minlength: "Agenda must be at least 3 characters long",
                    maxlength: "Agenda must be up to 500 characters long",
                },
                minutes: {
                    required: "The minutes field is required",
                    digits: "Please enter valid number",
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
        $("#status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
