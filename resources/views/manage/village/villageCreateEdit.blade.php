@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="villlage-add-edit" method="post" action="{{@$method == 'Add' ? route('manage.villageAdd') : route('manage.villageUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$village->id}}" name="id"/>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{@$village ? @$village->name : old('name')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$village ? @$village->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="state" class="form-label">State</label>
                            <select id="state" name="state" class="form-control select2">
                                @php
                                    $selectedState = @$village ? @$village->state : old('state');
                                @endphp
                                <option value="">Select User</option>
                                @foreach ($states as $state)
                                    <option {{$selectedState == $state->id ? 'selected' : ''}} value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="district" class="form-label">District</label>
                            <select id="district" name="district" class="form-control select2">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="population" class="form-label">Population</label>
                            <input type="text" class="form-control" id="population" name="population" value="{{@$village ? @$village->population : old('population')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{@$village ? @$village->latitude : old('latitude')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{@$village ? @$village->longitude : old('longitude')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-control select2">
                                @php
                                    $selectedStatus = @$village ? @$village->status : old('status');
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
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.villages')}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(window).on('load', function() {
        setTimeout(function () {
            $('#state').trigger('change');
        }, 200);
    });

    $(document).ready(function() {
        var selectedDistrictId = "{{ $village->district ?? '' }}";

        $('#state').change(function () {
            console.log('inn');

            var stateId = $('#state').val()

            if (stateId) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route("manage.get-districts")  }}',
                    type: 'Post',
                    dataType: 'json',
                    data: {
                        state_id:stateId,
                    },
                    success: function(data) {
                        var newOptions = '<option value="">Select District</option>';
                        $.each(data, function(index, district) {
                            var selected = (district.id == selectedDistrictId) ? 'selected' : '';
                            newOptions += '<option value="' + district.id + '" ' + selected + '>' + district.name + '</option>';
                        });

                        $('#district').html(newOptions).trigger('change');
                    },
                    error: function(xhr) {
                        alert('Something went wrong while fetching districts!');
                    }
                });
            } else {
                $('#district').empty().append('<option value="">Select District</option>');
            }
        })

        $("#villlage-add-edit").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                description: {
                    required: true,
                    minlength: 3,
                    maxlength: 500,
                },
                state: {
                    required: true,
                },
                district: {
                    required: true,
                },
                population: {
                    required: true,
                    digits: true,
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
                name: {
                    required: "The name field is required",
                    minlength: "Name must be at least 3 characters long"
                },
                description: {
                    required: "The description field is required",
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
                },
                state: {
                    required: "The state field is required",
                },
                district: {
                    required: "The district field is required",
                },
                population: {
                    required: "The population field is required",
                    digits: "Please enter valid number",
                },
                latitude: {
                    required: "The latitude field is required",
                },
                longitude: {
                    required: "The longitude field is required",
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
