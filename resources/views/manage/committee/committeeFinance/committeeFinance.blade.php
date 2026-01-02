
<div class="col-12">
    <div class="d-flex justify-content-between">
        <div class="card-header mx-0 px-0">
            <button type="button" class="btn btn-info m-1 fw-bold"><span class="p-1">Current Balance:</span> {{$committee->current_balance}}</button>
            <button type="button" class="btn btn-success m-1 fw-bold"><span class="p-1">Total Income:</span> {{$committee->total_income}}</button>
            <button type="button" class="btn btn-danger m-1 fw-bold"><span class="p-1">Total Expense:</span> {{$committee->total_expense}}</button>
        </div>
        <div class="">
            <a href="{{route('manage.committeeFinanceCreate',['committeeId' => $committee->id])}}" title="Add"><i class="text-primary bx bx-plus bx-md"></i></a>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive text-nowrap">
            <table class="table" id="committeeFinanceTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transaction Date</th>
                        <th>Amount</th>
                        <th>Transaction Type</th>
                        <th>Description</th>
                        <th>Remark</th>
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

@section('extraScript')
<script>
    function committeeFinanceTable() {
        if (!$.fn.DataTable.isDataTable("#committeeFinanceTable")) {
            $('#committeeFinanceTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('manage.committeeFinanceList',['committeeId' => $committee->id]) }}",
                "columns": [
                    { "data": null, "className": "", "orderable": false, "searchable": false,"render": function (data, type, row, meta) {return meta.row + 1;}
                    },
                    { "data": "transaction_date", "className": "", "searchable": true, "orderable": true},
                    { "data": "amount", "className": "", "searchable": true, "orderable": true},
                    { "data": "transaction_type", "className": "", "searchable": true, "orderable": true},
                    { "data": "description", "className": "text-wrap text-left", "searchable": true, "orderable": true},
                    { "data": "remark", "className": "", "searchable": true, "orderable": true},
                    { "data": null, "className": "text-center", "orderable": false, "searchable": false,
                        "render": function (data, type, row) {
                                    var tableName = "committee_finances"
                                    var editUrl = "{{ route('manage.committeeFinanceEdit',['committeeId' => $committee->id, 'id' => ':id']) }}".replace(':id', row.id);
                                    return `<a class="mx-1" title="Edit" href="${editUrl}"><i class="text-info bx bx-edit"></i></a>`;
                                }
                    }
                ],
                "order": [[1, "asc"]]
            });
        }
    }
</script>
@append
