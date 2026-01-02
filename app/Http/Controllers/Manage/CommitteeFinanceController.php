<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CommitteeFinance;
use App\Models\User;
use App\Models\Committee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommitteeFinanceController extends Controller
{

  public function CommitteeFinanceList(Request $request, $committeeId) {
    $query = CommitteeFinance::where('committee_id', $committeeId);

    return DataTables::of($query)
        ->editColumn('transaction_date', function ($q) {
            return Carbon::parse($q->meeting_date)->format('d-m-Y');
        })
        ->editColumn('transaction_type', function ($q) {
            return ucfirst($q->transaction_type);
        })
        ->rawColumns(['actions'])
        ->make(true);
  }

  public function CommitteeFinanceCreate($committeeId){
    $data['title'] = 'Add Committee Finance';
    $data['method'] = 'Add';
    $data['committeeId'] = $committeeId;
    $data['committee'] = Committee::where('id', $committeeId)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeFinance.committeeFinanceCreateEdit', $data);
  }

  public function committeeFinanceMasterCalculation($committee_id){
    $totalIncome = CommitteeFinance::select(DB::raw('SUM(amount) as amount'))->where('committee_id',$committee_id)->where('transaction_type', 'income')->first();
    $totalExpense = CommitteeFinance::select(DB::raw('SUM(amount) as amount'))->where('committee_id',$committee_id)->where('transaction_type', 'expense')->first();
    $totalIncome = $totalIncome->amount ?? 0;
    $totalExpense = $totalExpense->amount ?? 0;
    $currentBalance = $totalIncome - $totalExpense;

    $committee = Committee::where('id', $committee_id)->first();
    $committee->total_income = $totalIncome;
    $committee->total_expense = $totalExpense;
    $committee->current_balance = $currentBalance > 0 ? $currentBalance : 0;
    $committee->save();
  }
  public function save(Request $request){
    $rules = [
        'committee_id' => 'required',
        'transaction_date' => 'required',
        'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'transaction_type' => 'required',
        'description' => 'nullable|min:3|max:500',
        'remark' => 'nullable|min:3|max:500',
    ];

    $messages =  [
        'committee_id.required' => 'The committee field is required.',
        'transaction_date.required' => 'The transaction date field is required.',
        'amount.required' => 'The amount field is required.',
        'amount.numeric' => 'Amount must be a valid number.',
        'amount.regex' => 'Up to 2 decimal digits are allowed.',
        'transaction_type.required' => 'The transaction type field is required.',
        'description.min' => 'Description must be at least 3 characters.',
        'description.max' => 'Description must be up to 500 characters.',
        'remark.min' => 'Remark must be at least 3 characters.',
        'remark.max' => 'Remark must be up to 500 characters.',
    ];

    $data = $request->validate($rules, $messages);

    $data['transaction_date'] = Carbon::parse($request->transaction_date)->format("Y-m-d");

    CommitteeFinance::create($data);

    $this->committeeFinanceMasterCalculation($request->committee_id);

    return redirect()->route('manage.committeeView',['id' => $request->committee_id, 'currentTab' => 'navs-pills-committee-finance'])->with('success', 'Committee Finance added successfully!');
  }

  public function CommitteeFinanceEdit($committeeId, $id){
    $data['title'] = 'Edit Committee Finance';
    $data['method'] = 'Edit';

    $data['CommitteeFinance'] = CommitteeFinance::selectRaw("*, DATE_FORMAT(transaction_date, '%Y-%m-%d') as transaction_date")->where('id', $id)->first();
    $data['committeeId'] = $committeeId;
    $data['committee'] = Committee::where('id', $committeeId)->first();
    $data['navbar_name'] = $data['committee']->name;

    return view('manage.committee.committeeFinance.committeeFinanceCreateEdit', $data);
  }

  public function update(Request $request){
    $rules = [
        'committee_id' => 'required',
        'transaction_date' => 'required',
        'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'transaction_type' => 'required',
        'description' => 'nullable|min:3|max:500',
        'remark' => 'nullable|min:3|max:500',
    ];

    $messages =  [
        'committee_id.required' => 'The committee field is required.',
        'transaction_date.required' => 'The transaction date field is required.',
        'amount.required' => 'The amount field is required.',
        'amount.numeric' => 'Amount must be a valid number.',
        'amount.regex' => 'Up to 2 decimal digits are allowed.',
        'transaction_type.required' => 'The transaction type field is required.',
        'description.min' => 'Description must be at least 3 characters.',
        'description.max' => 'Description must be up to 500 characters.',
        'remark.min' => 'Remark must be at least 3 characters.',
        'remark.max' => 'Remark must be up to 500 characters.',
    ];

    $data = $request->validate($rules, $messages);

    $data['transaction_date'] = Carbon::parse($request->transaction_date)->format("Y-m-d");

    $committee = CommitteeFinance::findOrFail($request->id);

    $committee->update($data);

    $this->committeeFinanceMasterCalculation($request->committee_id);

    return redirect()->route('manage.committeeView',['id' => $request->committee_id, 'currentTab' => 'navs-pills-committee-finance'])->with('success', 'Committee Finance updated successfully!');
  }
}
