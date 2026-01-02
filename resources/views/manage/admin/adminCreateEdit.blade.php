@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="{{@$method == 'Add' ? 'admin-add' : 'admin-edit'}}" method="post" action="{{@$method == 'Add' ? route('manage.adminAdd') : route('manage.adminUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$admin->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{@$admin ? @$admin->name : old('name')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{@$admin ? @$admin->email : old('email')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        @if(@$method == 'Add')
                            <div class="col-12 mb-1 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    <input type="password" class="form-control group-input" id="password" name="password" placeholder="············" old="{{old('password')}}" aria-describedby="basic-default-password2" />
                                </div>
                            </div>
                        @endif
                        <div class="col-12 mb-1">
                            <label for="admin_type" class="form-label">Admin Type</label>
                            <select id="admin_type" name="admin_type" class="form-control select2">
                                @php
                                    $selectedAdminType = @$admin ? @$admin->admin_type : old('admin_type');
                                @endphp
                                <option value="">Select Status</option>
                                <option {{$selectedAdminType == "super_admin" ? 'selected' : ''}} value="super_admin">Super Admin</option>
                                <option {{$selectedAdminType == "admin" ? 'selected' : ''}} value="admin">Admin</option>
                                <option {{$selectedAdminType == "sub_admin" ? 'selected' : ''}} value="sub_admin">Sub Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{@$admin ?@$admin->phone_number : old('phone_number')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <div class="input-group">
                                <input type="file" class="form-control  group-input" id="profile_image" name="profile_image">
                            </div>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$admin ? @$admin->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.admins')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        $("#admin-add").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                admin_type: {
                    required: true,
                },
                phone_number: {
                    digits: true,
                },
                profile_image: {
                    extension: "jpg|jpeg|png",
                },
                status: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "The name field is required",
                    minlength: "Name must be at least 3 characters long"
                },
                email: {
                    required: "The email field is required",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "The password field is required",
                    minlength: "Password must be at least 6 characters long"
                },
                admin_type: {
                    required: "The admin type field is required",
                },
                phone_number: {
                    digits: "Please enter valid number",
                },
                profile_image: {
                    extension: "Only jpg, jpeg and png formats are allowed",
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


        $("#admin-edit").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                admin_type: {
                    required: true,
                },
                phone_number: {
                    digits: true,
                },
                profile_image: {
                    extension: "jpg|jpeg|png",
                },
                status: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "The name field is required",
                    minlength: "Name must be at least 3 characters long"
                },
                email: {
                    required: "The email field is required",
                    email: "Please enter a valid email address"
                },
                admin_type: {
                    required: "The admin type field is required",
                },
                phone_number: {
                    digits: "Please enter valid number",
                },
                profile_image: {
                    extension: "Only jpg, jpeg and png formats are allowed",
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
        $("#admin_type, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
