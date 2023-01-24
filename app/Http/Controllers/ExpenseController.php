<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{   

    private $userModel;

    public function __construct()
    {   
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->Init();
        $expenses = Expense::List('expense_user_id', Auth::user()->user_id)->get();
        return view('expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->Init();
        if(isset($request->is_delete_request)) { 
            foreach($request->expense as $expeneData) {
                if(isset($expeneData['checked_row'])) {
                    Expense::where('expense_id', $expeneData['expense_id'])->delete();
                    
                }
            }
            return redirect()->back();
        }
        if(isset($request->is_save_request)) {
            $data = $request->except('is_save_request','_token');
            $expense = new Expense($data);
            $expense->expense_user_id = Auth::user()->user_id;
            $expense->expense_store_id = $this->userModel->store_id;
            $expense->save();
            return redirect()->back();

        }
        foreach($request->expense as $expeneData) {
            Expense::where('expense_id', $expeneData['expense_id'])->update($expeneData);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function Init()
    {
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();

        $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
        $this->settingModel = Setting::find($this->settingModel->setting_id);

        $this->categoryList = $this->settingModel->setting_stock_category;


        $this->storeList = Store::List('root_store_id', $this->userModel->store_id);

        $this->storeModel = Store::Account('store_id', $this->userModel->store_id)
            ->first();

        //$this->storeList->prepend($storeModel);
    }
}
