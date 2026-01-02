@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="gallery-add-edit-form" method="post" action="{{@$method == 'Add' ? route('manage.galleryAdd') : route('manage.galleryUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$gallery->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Folder Name</label>
                            <input type="text" class="form-control" id="folder_name" name="folder_name" value="{{@$gallery ? @$gallery->folder_name : old('folder_name')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$gallery ? @$gallery->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$gallery ? @$gallery->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.gallery')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {

        $("#gallery-add-edit-form").validate({
            rules: {
                folder_name: {
                    required: true,
                    minlength: 3
                },
                description: {
                    required: true,
                    minlength: 3,
                    maxlength: 500,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                folder_name: {
                    required: "The folder name field is required",
                    minlength: "Folder name must be at least 3 characters long"
                },
                description: {
                    required: "The description field is required",
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
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
