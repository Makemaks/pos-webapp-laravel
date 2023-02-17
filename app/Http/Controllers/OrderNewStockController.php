<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class OrderNewStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $warehouses = Warehouse::latest('warehouse.created_at')
                    ->join('company', 'company_id', '=', 'warehouse_company_id')
                    //->join('company', 'company_id', '=', 'warehouse_company_id')
                    ->paginate(10);

      return view('orderNewStock.index',compact('warehouses'))
          ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orderNewStock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'ordertable_type' => 'required',
          'order_status' => 'required',
      ]);

      Order::create($request->all());

      return redirect()->route('orderNewStock.index')
                      ->with('success','New Stock Order created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orderNewStock.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orderNewStock.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
      $request->validate([
          'ordertable_type' => 'required',
          'order_status' => 'required',
      ]);

      $order->update($request->all());

      return redirect()->route('orderNewStock.index')
                      ->with('success','New Stock Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
      $order->delete();

      return redirect()->route('orderNewStock.index')
                      ->with('success','New Stock Orderx deleted successfully');
    }
}
