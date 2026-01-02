@extends('manage.layouts.contentNavbarLayout')

@section('title', @$title)

@section('content')
    @include('manage.include.validation-alert')
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">{{@$title}}</h5>
        </div>
        <form id="committee-finance-form" method="post" action="{{@$method == 'Add' ? route('manage.committeeFinanceAdd') : route('manage.committeeFinanceUpdate')}}" enctype="multipart/form-data">
            @csrf
            @if(@$method == 'Edit')
                <input type="hidden" value="{{$CommitteeFinance->id}}" name="id"/>
            @endif
            <input type="hidden" value="{{$committeeId}}" name="committee_id"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="transaction_date" class="form-label">Transaction Date</label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{@$CommitteeFinance ? @$CommitteeFinance->transaction_date : old('transaction_date')}}" aria-describedby="defaultFormControlHelp">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" aria-describedby="defaultFormControlHelp" value="{{@$CommitteeFinance ? @$CommitteeFinance->amount : old('amount')}}">
                        </div>
                        <div class="col-12 mb-1">
                            <label for="transaction_type" class="form-label">Transaction Type</label>
                            <select id="transaction_type" name="transaction_type" class="form-control select2">
                                @php
                                    $selectedTransactionType = @$CommitteeFinance ? @$CommitteeFinance->transaction_type : old('transaction_type');
                                @endphp
                                <option value="">Select Transaction Type</option>
                                <option {{$selectedTransactionType == 'income' ? 'selected' : ''}} value="income">Income</option>
                                <option {{$selectedTransactionType == 'expense' ? 'selected' : ''}} value="expense">Expense</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12 mb-1">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="defaultFormControlHelp">{{@$CommitteeFinance ? @$CommitteeFinance->description : old('description')}}</textarea>
                        </div>
                        <div class="col-12 mb-1">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea type="text" class="form-control" id="remark" name="remark" aria-describedby="defaultFormControlHelp">{{@$CommitteeFinance ? @$CommitteeFinance->remark : old('remark')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a type="button" class="btn btn-secondary m-1" href="{{route('manage.committeeView',['id' => $committeeId, 'currentTab' => 'navs-pills-committee-finance'])}}">Cancel</a>
                <button type="submit" class="btn btn-primary m-1">Submit</button>
            </div>
        </form>
    </div>
@endsection

@section('extraScript')
<script>
    $(document).ready(function() {
        $("#committee-finance-form").validate({
            rules: {
                transaction_date: {
                    required: true,
                },
                amount: {
                    required: true,
                    decimalNumber: true,
                },
                transaction_type: {
                    required: true,
                },
                description: {
                    required: false,
                    minlength: 3,
                    maxlength: 500,
                },
                remark: {
                    required: false,
                    minlength: 3,
                    maxlength: 500,
                },
            },
            messages: {
                transaction_date: {
                    required: "The transaction date field is required",
                },
                amount: {
                    required: "The amount field is required",
                },
                transaction_type: {
                    required: "The transaction type field is required",
                },
                description: {
                    minlength: "Description must be at least 3 characters long",
                    maxlength: "Description must be up to 500 characters long",
                },
                remark: {
                    minlength: "Remark must be at least 3 characters long",
                    maxlength: "Remark must be up to 500 characters long",
                },
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
    });
</script>
@append
