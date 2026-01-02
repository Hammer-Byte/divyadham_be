@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="page-add-edit" method="post" action="{{@$method == 'Add' ? route('manage.pageAdd') : route('manage.pageUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$page->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{@$page ? @$page->title : old('title')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$page ? @$page->status : old('status');
                                @endphp
                                <option value="">Select Status</option>
                                <option {{$selectedStatus == '1' ? 'selected' : ''}} value="1">Active</option>
                                <option {{$selectedStatus == '0' ? 'selected' : ''}} value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="content" class="form-label">Content</label>
                            <textarea type="text" class="form-control" id="content" name="content" aria-describedby="defaultFormControlHelp">{{@$page ? @$page->content : old('content')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.pages')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script src="{{ asset('admin/assets/js/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {

        tinymce.init({
            selector: '#content',
            height: 400,
            menubar: false,
            plugins: 'link table code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | link code',
        });

        $("#page-add-edit").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3
                },
                content: {
                    required: true,
                    minlength: 3,
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
                content: {
                    required: "The content field is required",
                    minlength: "Description must be at least 3 characters long",
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
