<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;

class ChartAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chartID = $request['chartID'];

        $currentWeekSalePercentage = 0;

        $startOfCurrentWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfCurrentWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        $startOfLastWeek = Carbon::now()->startOfWeek()->subDays(7)->format('Y-m-d');

      
        if ($chartID ==  'currentWeekSalePercentage') {
            $currentWeekSale =  Order::Receipt()
            ->select('order.*', 'product_price')
            ->whereBetween( 'order.created_at', [$startOfCurrentWeek, $endOfCurrentWeek] )
                        ->pluck('product_price')
                        ->sum();

            $lastWeekSale = Order::Receipt()
            ->select('order.*', 'product_price')
            ->whereBetween( 'order.created_at', [$startOfLastWeek,  $startOfCurrentWeek] )
                        ->pluck('product_price')
                        ->sum();

            if ( $lastWeekSale != 0) {
                $response = Store::WeeklyPercentage($lastWeekSale, $currentWeekSale);
            }else{
                $response = $currentWeekSalePercentage;
            }

        }elseif ($chartID ==  'monthlyYearlySale') {
            $response = Order::Receipt()->
            select(
                Order::Receipt()->raw('YEAR(order.created_at) as year'),
                Order::Receipt()->raw('MONTH(order.created_at) as month'),
                Order::Receipt()->raw('SUM(product_price) as sum')
            )
            ->whereYear('order.created_at', '=', Carbon::now()->year)
            ->orWhereYear('order.created_at', '=', Carbon::now()->subYear()->year)
            ->groupBy('year', 'month')
            ->get();  
        }
        elseif ($chartID ==  'monthlyProductVat') {
            $response = Order::Receipt()->
            select(
                Order::Receipt()->raw('YEAR(order.created_at) as year'),
                Order::Receipt()->raw('MONTH(order.created_at) as month'),
                Order::Receipt()->raw('SUM(receipt_product_vat) as sum')
            )
            ->whereYear('order.created_at', '=', Carbon::now()->year)
            ->orWhereYear('order.created_at', '=', Carbon::now()->subYear()->year)
            ->groupBy('year', 'month')
            ->get();  
        }
        
      
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


  
}
