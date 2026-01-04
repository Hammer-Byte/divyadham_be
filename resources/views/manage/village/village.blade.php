@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.alerts')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
            <div class="m-3">
                <a href="{{route('manage.villageCreate')}}" title="Add"><i class="text-primary bx bx-plus bx-md"></i></a>
            </div>
        </div>
        <div class="row m-2">
            <div class="table-responsive text-nowrap">
                <table class="table" id="villagesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Population</th>
                            <th>Location</th>
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
        $('#villagesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manage.villageList') }}",
            "columns": [
                { "data": null, "className": "", "orderable": false, "searchable": false,"render": function (data, type, row, meta) {return meta.row + 1;}
                },
                { "data": "name", "className": "", "searchable": true, "orderable": true},
                { "data": "description", "className": "text-wrap text-left", "searchable": true, "orderable": true},
                { "data": "population",  "className": "", "searchable": true, "orderable": true},
                { "data": "location", "className": "", "searchable": true, "orderable": false,
                    "render": function (data, type, row) {
                        return `<div>
                                    <span>State: ${data.state}</span><br/>
                                    <span>District: ${data.district}</span><br/>
                                    <span>Lat-Long: ${data.lat}, ${data.long}</span>
                                </div>`
                }
                },
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
                                var editUrl = "{{ route('manage.villageEdit', ':id') }}".replace(':id', row.id);
                                var viewUrl = "{{ route('manage.villageView', ':id') }}".replace(':id', row.id);
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
