@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.alerts')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
            <div class="m-3">
                <a href="{{route('manage.adminCreate')}}" title="Add"><i class="text-primary bx bx-plus bx-md"></i></a>
            </div>
        </div>
        <div class="row m-2">
            <div class="table-responsive text-nowrap">
                <table class="table" id="adminsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th>Status</th>
                            <th>Actions</th>
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
    $(document).ready(function() {
        $('#adminsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('manage.adminList') }}",
                "error": function(xhr, error, thrown) {
                    console.error('DataTables Ajax Error:', error);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading data. Please check the console for details.');
                }
            },
            "columns": [
                { "data": null, "className": "", "orderable": false, "searchable": false,"render": function (data, type, row, meta) {return meta.row + 1;}
                },
                { "data": "profile_image", "className": "", "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        return `<img src="${data}" alt="Profile Photo" class="rounded-circle" width="40" height="40">`;
                    }
                },
                { "data": "name", "className": "", "searchable": true, "orderable": true},
                { "data": "email",  "className": "", "searchable": true, "orderable": true},
                { "data": "phone_number", "className": "", "searchable": true, "orderable": true},
                { "data": "status", "className": "", "searchable": false, "orderable": false,
                    "render": function (data, type, row) {
                        var tableName = "{{$table_name}}"
                        var checked = data == 1 ? true : false
                        return `<div class="form-check form-switch"><input class="form-check-input datatable-status-toggle" type="checkbox" data-row-id="${row.id}" data-table-name="${tableName}" role="switch" ${data == 1 ? "checked" : ""}></div>`
                }
                },
                { "data": null, "className": "text-center", "orderable": false, "searchable": false,
                    "render": function (data, type, row) {
                                var tableName = "{{$table_name}}"
                                var editUrl = "{{ route('manage.adminEdit', ':id') }}".replace(':id', row.id);
                                return `<a class="mx-1" title="Edit" href="${editUrl}"><i class="text-info bx bx-edit"></i></a>
                                        <a class="mx-1 datatable-delete" title="Delete" href="javascript:void(0)" data-row-id="${row.id}" data-table-name="${tableName}"><i class="text-danger bx bx-trash"></i></a>`;
                            }
                }
            ],
            "order": [[2, "asc"]]
        });
    });
</script>
@append
