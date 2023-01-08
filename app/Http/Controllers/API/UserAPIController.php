<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Models\Setting;

use App\Models\Stock;
use App\Helpers\MathHelper;

class UserAPIController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     private  $stockList;
  

    public function index(Request $request)
    {

        if ($request->has('action') && $request['action'] == 'createCustomer') {
           
            $data['personModel'] = new Person();
           
            $this->html = view('person.partial.createPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'showCustomer') {
           
            $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

            $this->personList = Person::Address('person_organisation_id', $this->userModel->organisation_id)
            ->paginate(20);

            $this->html = view('person.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'removeCustomer') {
            $setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.setupList');
            $setupList['customer'] = [];
            $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $setupList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'searchCustomer') {
            
            $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');
            $this->personList = Person::whereIn('person_user_id', $userList)
            ->orWhere('person_name->person_firstname', 'like', '%'.$request['value'].'%')
            ->orWhere('person_name->person_lastname', 'like', '%'.$request['value'].'%')
            ->paginate(20);
           
            $this->html = view('person.partial.indexPartial', ['data' => $this->Data()])->render();
        }
         //retrieve person_id
         elseif($request->has('action') && $request['action'] == 'searchCustomer'){
          
            $this->personModel = Person::find($request->get('person_id'));
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }


        
        return response()->json(['success'=>'Got Simple Ajax Request.', 'data' => $this->html]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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

    private function Data(){

        return [
         
            'stockList' => $this->stockList,
        ];
       
    }
}
