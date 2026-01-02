@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="{{@$method == 'Add' ? 'public-document-add-form' : 'public-document-update-form'}}" method="post" action="{{@$method == 'Add' ? route('manage.publicDocumentAdd') : route('manage.publicDocumentUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$publicDocument->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{@$publicDocument ? @$publicDocument->title : old('title')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$publicDocument ? @$publicDocument->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="document_upload_type" class="form-label">Document Upload Type</label>
                            <select id="document_upload_type" name="document_upload_type" class="form-control select2">
                                @php
                                    $selectedMediaUploadType = @$publicDocument ? @$publicDocument->document_upload_type : old('document_upload_type');
                                @endphp
                                <option value="">Select Document Upload Type</option>
                                <option {{$selectedMediaUploadType == 'file_upload' ? 'selected' : ''}} value="file_upload">File Upload</option>
                                <option {{$selectedMediaUploadType == 'url' ? 'selected' : ''}} value="url">URL</option>
                            </select>
                        </div>
                        <div class="col-12 mb-1 document_type_file_wrapper d-none">
                            <label for="document_type_file" class="form-label">Document File</label>
                            <div class="input-group">
                                <input type="file" class="form-control  group-input" id="document_type_file" name="document_type_file">
                            </div>
                        </div>
                        <div class="col-12 mb-1 document_type_url_wrapper d-none">
                            <label for="document_type_url" class="form-label">Document URL</label>
                            <input type="text" class="form-control" id="document_type_url" name="document_type_url" value="{{@$publicDocument ? @$publicDocument->document_url : old('document_type_url')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$publicDocument ? @$publicDocument->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.publicDocuments')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        showHideDocumentMediaFields($('#document_upload_type').val())

        $('#document_upload_type').change(function () {
            var selectedVal = $(this).val()
            showHideDocumentMediaFields(selectedVal)
        })

        function showHideDocumentMediaFields(selectedVal) {
            if (selectedVal == 'file_upload') {
                $('.document_type_file_wrapper').removeClass('d-none')
                $('.document_type_url_wrapper').addClass('d-none')
            }else if (selectedVal == 'url'){
                $('.document_type_file_wrapper').addClass('d-none')
                $('.document_type_url_wrapper').removeClass('d-none')
            }
        }

        $("#public-document-add-form").validate({
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
                document_upload_type: {
                    required: true,
                },
                document_type_file: {
                    required: true,
                    extension: "jpg|jpeg|png|pdf|doc|docx|xls|xlsx",
                },
                document_type_url: {
                    required: true,
                    url: true,
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
                document_upload_type: {
                    required: "The banner upload type field is required",
                },
                document_type_file: {
                    required: "The banner file field is required",
                    extension: "Invalid file format",
                },
                document_type_url: {
                    required: "The banner url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
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

        $("#public-document-update-form").validate({
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
                document_upload_type: {
                    required: true,
                },
                document_type_file: {
                    extension: "jpg|jpeg|png|pdf|doc|docx|xls|xlsx",
                },
                document_type_url: {
                    required: true,
                    url: true,
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
                document_upload_type: {
                    required: "The banner upload type field is required",
                },
                document_type_file: {
                    extension: "Invalid file format",
                },
                document_type_url: {
                    required: "The banner url field is required",
                    url: "Please enter a valid URL (e.g., https://example.com).",
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
        $("#document_upload_type, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
