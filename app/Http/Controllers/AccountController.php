<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $accountList;
    private $accountModel;

    public function Index()
    {
        $this->accountList = Account::orderBY('account_id', 'desc')->paginate(10);
        // $accountList = Account::List('account_id', Auth::user()->user_account_id)->paginate(10);
        return view('account.index', ['data' => $this->Data()]);
    }

    public function Store(Request $request) 
    {
        Account::insert($request->form);
        return redirect()->route('account.index');
    }

    public function Update(Request $request)
    {
        if($request->account_delete){
            foreach($request->account_delete as $account){
                Account::destroy($account);
            }
        } else {
            $account_datatable_title = collect(collect($request->account)->first())->except('account_id')->toArray();
            Account::upsert($request->account, ['account_id'], array_keys($account_datatable_title));
        }
        
        return redirect()->route('account.index');
    }

    private function Data()
    {
        return [
            'accountModel' => $this->accountModel,
            'accountList' => $this->accountList,
        ];
    }
}
