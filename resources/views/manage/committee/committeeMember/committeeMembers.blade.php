
<div class="col-12">
    <div class="d-flex justify-content-between">
        <h5 class="card-header"></h5>
        <div class="">
            <a href="{{route('manage.committeeMemberCreate',['committeeId' => $committee->id])}}" title="Add"><i class="text-primary bx bx-plus bx-md"></i></a>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive text-nowrap">
            <table class="table" id="committeeMemberTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('extraScript')
<script>
    function committeeMembersTable() {
        if (!$.fn.DataTable.isDataTable("#committeeMemberTable")) {
            $('#committeeMemberTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('manage.committeeMembersList',['committeeId' => $committee->id]) }}",
                "columns": [
                    { "data": null, "className": "", "orderable": false, "searchable": false,"render": function (data, type, row, meta) {return meta.row + 1;}
                    },
                    { "data": "user_name", "className": "", "searchable": true, "orderable": true},
                    { "data": "role", "className": "", "searchable": true, "orderable": true},
                    { "data": "status", "className": "", "searchable": false, "orderable": false,
                        "render": function (data, type, row) {
                            var tableName = "committee_members"
                            var checked = data == 1 ? true : false
                            return `<div class="form-check form-switch"><input class="form-check-input datatable-status-toggle" type="checkbox" data-row-id="${row.id}" data-table-name="${tableName}" role="switch" ${data == 1 ? "checked" : ""}></div>`
                    }
                    },
                    { "data": null, "className": "text-center", "orderable": false, "searchable": false,
                        "render": function (data, type, row) {
                                    var tableName = "committee_members"
                                    var editUrl = "{{ route('manage.committeeMemberEdit',['committeeId' => $committee->id, 'id' => ':id']) }}".replace(':id', row.id);
                                    return `<a class="mx-1" title="Edit" href="${editUrl}"><i class="text-info bx bx-edit"></i></a>
                                            <a class="mx-1 datatable-delete" title="Delete" href="javascript:void(0)" data-row-id="${row.id}" data-table-name="${tableName}"><i class="text-danger bx bx-trash"></i></a>`;
                                }
                    }
                ],
                "order": [[1, "asc"]]
            });
        }
    }
</script>
@append
