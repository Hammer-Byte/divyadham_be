@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="village-member-form" method="post" action="{{@$method == 'Add' ? route('manage.villageMemberAdd') : route('manage.villageMemberUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$villageMember->id}}" name="id"/>
            @endif
            <input type="hidden" value="{{$villageId}}" name="village_id"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="user_id" class="form-label">User</label>
                            <select id="user_id" name="user_id" class="form-control select2">
                                @php
                                    $selectedUser = @$villageMember ? @$villageMember->user_id : old('user_id');
                                @endphp
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option {{$selectedUser == $user->id ? 'selected' : ''}} value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$villageMember ? @$villageMember->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.villageView',['id' => $villageId, 'currentTab' => 'navs-pills-village-members'])}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        $("#village-member-form").validate({
            rules: {
                user_id: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                user_id: {
                    required: "The user field is required",
                },
                role: {
                    required: "The role field is required",
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
        $("#user_id, #role, #status").on("change", function() {
            $(this).valid();
        });
    });
</script>
@append
