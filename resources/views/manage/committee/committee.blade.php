@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.alerts')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
            <div class="m-3">
                <a href="{{route('manage.committeeCreate')}}" title="Add"><i class="text-primary bx bx-plus bx-md"></i></a>
            </div>
        </div>
        <div class="row m-2">
            <div class="table-responsive text-nowrap">
                <table class="table" id="committeeTable">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Name</th>
                            <th width="45%">Description</th>
                            <th width="10%">Formed Date</th>
                            <th width="10%">Status</th>
                            <th width="10%">Actions</th>
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
    $(document).ready(function() {
        $('#committeeTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manage.committeeList') }}",
            "columns": [
                { "data": null, "className": "", "orderable": false, "searchable": false,"render": function (data, type, row, meta) {return meta.row + 1;}
                },
                { "data": "name", "className": "", "searchable": true, "orderable": true},
                { "data": "description",  "className": "text-wrap text-left", "searchable": true, "orderable": true},
                { "data": "formed_date", "className": "", "searchable": true, "orderable": true},
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
                                var editUrl = "{{ route('manage.committeeEdit', ':id') }}".replace(':id', row.id);
                                var viewUrl = "{{ route('manage.committeeView', ':id') }}".replace(':id', row.id);
                                return `
                                <a class="mx-1" title="View" href="${viewUrl}"><i class="text-info bx bx-show"></i></a>
                                <a class="mx-1" title="Edit" href="${editUrl}"><i class="text-info bx bx-edit"></i></a>
                                <a class="mx-1 datatable-delete" title="Delete" href="javascript:void(0)" data-row-id="${row.id}" data-table-name="${tableName}"><i class="text-danger bx bx-trash"></i></a>
                                `;
                            }
                }
            ],
            "order": [[1, "asc"]]
        });
    });
</script>
@append
