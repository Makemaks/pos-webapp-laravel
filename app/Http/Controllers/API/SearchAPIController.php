<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class SearchAPIController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     private  $stockList;
  

    public function index(Request $request)
    {

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

       
        if ($request->has('search_element_type')) {
          
            if ($request['search_element_type'] == 'user') {
                $this->stockList = Stock::Store()
                            ->where('stock_merchandise->stock_name', 'like', '%'.$request['search_element'].'%')
                            
                            ->get();
                
                $this->html = view('receipt.partial.receiptPartial', $this->Data())->render();
            } 
            elseif ($request['search_element_type'] == 'product') {
                $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
                            ->where('stock_merchandise->stock_name', 'like', '%'.$request['search_element'].'%')
                            
                            ->get();
                
                $this->html = view('receipt.partial.receiptPartial', $this->Data())->render();
                       
                
              

            }
            
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
