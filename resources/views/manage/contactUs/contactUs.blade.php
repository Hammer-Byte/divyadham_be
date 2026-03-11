@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    <style>
        .contact-us-message-cell {
            max-width: 220px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-break: break-word;
        }
    </style>
    @include('manage.include.alerts')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{ @$title }}</h5>
        </div>
        <div class="row m-2">
            <div class="table-responsive">
                <table class="table" id="contactUsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Attended</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('extraScript')
<script>
    function bindAttendedToggle() {
        $('.contact-us-attended-toggle').off('change').on('change', function() {
            var id = $(this).attr("data-row-id");
            var attended = $(this).prop('checked') ? 1 : 0;
            var switchElement = $(this);

            $.ajax({
                url: "{{ route('manage.contactUsUpdateAttended') }}",
                type: "POST",
                data: {
                    id: id,
                    attended: attended,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Updated!",
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: "#ED7B1B"
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message || "Something went wrong.",
                            icon: "error",
                            confirmButtonColor: "#ED7B1B"
                        });
                        switchElement.prop('checked', attended === 0);
                    }
                },
                error: function(xhr) {
                    var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Something went wrong.";
                    Swal.fire({
                        title: "Error!",
                        text: msg,
                        icon: "error",
                        confirmButtonColor: "#ED7B1B"
                    });
                    switchElement.prop('checked', attended === 0);
                }
            });
        });
    }

    $(document).ready(function() {
        $('#contactUsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('manage.contactUsList') }}",
                "error": function(xhr, error, thrown) {
                    console.error('DataTables Ajax Error:', error);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading data. Please check the console for details.');
                }
            },
            "columns": [
                { "data": null, "className": "", "orderable": false, "searchable": false,
                    "render": function (data, type, row, meta) { return meta.row + 1; }
                },
                { "data": "user_info", "className": "", "searchable": false, "orderable": false },
                { "data": "comment_subject", "className": "", "searchable": true, "orderable": true },
                { "data": "comment_message", "className": "contact-us-message-cell", "searchable": true, "orderable": false },
                { "data": "attended", "className": "text-center", "searchable": false, "orderable": true },
                { "data": "created_at", "className": "", "searchable": false, "orderable": true }
            ],
            "order": [[5, "desc"]],
            "drawCallback": function() {
                bindAttendedToggle();
            }
        });
    });
</script>
@append
