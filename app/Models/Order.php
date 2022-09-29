<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

use App\Models\User;
use App\Models\Person;
use App\Models\Receipt;
use App\Models\Order;
use App\Models\Warehouse;
use App\Models\Store;

use App\Helpers\MathHelper;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'order_id';
    
    public $timestamps = true;

   

    protected $attributes = [

        "order_setting_vat" => '{}',
        "order_status" => 0,
        "order_finalise_key" => '{}'

    ];

    protected $casts = [
        "order_finalise_key" => 'array',
        "order_setting_vat" => 'array'
    ];


    public static function List($column,  $filter)
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->leftJoin('payment', 'payment.payment_id', '=', 'order.order_payment_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }


    public static function Receipt($column,  $filter)
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.ordertable_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->where($column,  $filter);
            //->select('order.*', 'receipt.*', 'stock.*', 'user.*', 'person.*', 'order.created_at as order_created_at');
    }

    public static function HourlyReceipt()
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.ordertable_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id');
    }

    public static function Account()
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->orderBy('order.created_at', 'desc');
    }

    public static function Event()
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('event', 'event.event_id', '=', 'receipt.receipttable_id');
    }

  

   
    public static function AverageSale($service_cost_sum, $service_cost_count)
    {

        $increase =  $service_cost_sum * $service_cost_count;
        $averageSale = $increase / 100;

        return MathHelper::FloatRoundUp($averageSale, 2);
    }

    public static function Commission($service_cost_sum, $service_commission_percentage_sum)
    {

        $increase = $service_cost_sum * $service_commission_percentage_sum;
        $commission = $increase / 100;

        return MathHelper::FloatRoundUp($commission, 2);
    }


    public static function AnnualIncome($service_cost_sum, $service_commission_percentage_sum)
    {

        $annualIncome = $service_cost_sum + $service_commission_percentage_sum;
        return MathHelper::FloatRoundUp($annualIncome, 2);
    }

    //Increase = New Number - Original Number
    // % increase = Increase ÷ Original Number × 100.
    public static function WeeklyPercentage($lastWeekSale, $currentWeekSale)
    {

        $increase = $lastWeekSale - $currentWeekSale;
        $weeklyPercentage = $increase / $lastWeekSale * 100;
        return MathHelper::FloatRoundUp($weeklyPercentage, 0);
    }

    public static function OrderType()
    {
        return [
            'In-Store',
            'Online',
        ];
    }

    public static function Total($sessionCartList)
    {

        $totalPrice = 0;

        foreach ($sessionCartList as $cartValue => $cartItem) {
            if (array_key_exists('quantity', $sessionCartList)) {
                $price = $cartItem['price'] * $data['quantity'];
                $totalPrice = $totalPrice + $price;
            } else {
                $totalPrice =  $totalPrice + $cartItem['price'];
            }
        }

        return $totalPrice;
    }

    public static function OrderPaymentType()
    {
        return [
            "CASH",
            "CREDIT CARD"
        ];
    }

    public static function OrderStatus()
    {
        return [
            'Received',
            'Processing',
            'Preparing to Ship',
            'Shipped',
            'Delivered',
            'Check in Today',
            'Ready for Pickup',
            'Picked up',
            'Cancelled',
            'Refunded'
        ];
    }


    // add to db
    public static function Process($request, $data){
       
        $receipt = [];
        $receipt['priceVAT'] = 0;
        $receipt['totalPrice'] = 0;
        $receipt['discountTotal'] = 0;
        $orderData = [];
        $receiptData = [];
      

        //get receipt stock
        if($request->session()->has('user-session-'.Auth::user()->user_id. '.cartList')){

            $sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.cartList');
            //$stockList = Receipt::SessionDisplay($sessionCartList);
        }

        if ( $request->session()->has('user-session-'.Auth::user()->user_id. '.customerCartList') ) {
            $customerCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.customerCartList');

            $personModel = Person::find($customerCartList[0]['value']);
            $orderData += [
                'ordertable_id' => $personModel->person_id,
                'ordertable_type' => 'Person',
            ];
        }

        $userModel = User::Person('user_person_id', Auth::user()->user_person_id)
            ->first();
        
        //order type
        if (User::UserType()[Auth::User()->user_type] == 'Super Admin' && User::UserType()[Auth::User()->user_type] == 'Admin') {

            $orderData += [
                'order_store_id' => $userModel->user_store_id,
                'order_type' => array_search('In-Store', Order::OrderType())
            ];
           
        }else{
            $orderData += [
                'order_type' => array_search('Online', Order::OrderType())
            ];
        }

        //customer details
        if (User::UserType()[Auth::User()->user_type] == 'Super Admin' && User::UserType()[Auth::User()->user_type] == 'Admin' && 
        $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'customerList')) {

            $orderData += [
                'ordertable_id' => $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'customerList')[0],
                'ordertable_type' => 'Person'
            ];
           
        }else{
            $orderData += [
                'ordertable_id' => $userModel->person_id,
                'ordertable_type' => 'Person'
            ];
        }

     
        //add finalise key
        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'finaliseKeyList')) {
            if ( count( $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'finaliseKeyList') ) > 0) {
                $orderData += [
                    'order_finalise_key' => $request->session()->get('order_finalise_key')
                ];
            }
        }
        //add finalise key
        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'offerList')) {
            if ( count( $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'offerList') ) > 0) {
                $orderData += [
                    'order_offer' => $request->session()->get('order_finalise_key')
                ];
            }
        }
        
        //store order
        $orderData = [

            'order_user_id' => $userModel->user_id,
            'order_status' => 0,
            'order_setting_pos_id' => 1
        ];

        //$orderData = DatabaseHelper::MergeArray($orderData, DatabaseHelper::Timestamp());
        $orderID = Order::insertGetId($orderData);
        $loop = (object)['last' => false];
        //store receipt
        foreach ($sessionCartList as $key => $sessionCartList) {
           
           
            if($key >= count($sessionCartList)){
                $loop->last = true;
            }

           if (array_key_exists('receipt_discount', $sessionCartList)) {
                $receiptData += $sessionCartList['receipt_discount'];
           }
           
            $receipt = Receipt::Calculate($data, $sessionCartList, $loop, $receipt);
            
            //decrement stock from table
            $warehouseStock = Warehouse::Available( $sessionCartList['stock_id'] );
            $warehouse_quantity = $warehouseStock->warehouse_quantity - $sessionCartList['stock_quantity'];
            
            Warehouse::where( 'warehouse_id', $warehouseStock->warehouse_id)
            ->update(['warehouse_quantity' => $warehouse_quantity]);

            $receiptData = [
                    'receipttable_id' => $sessionCartList['stock_id'],
                    'receipttable_type' => 'Stock',
                    'receipt_warehouse_id' => 1,
                    'receipt_order_id' =>  $orderID,
                    'receipt_user_id' => $sessionCartList['user_id'],
                    'receipt_stock_cost' => $receipt['price'],
                    'receipt_setting_pos_id' => 1,
                    'receipt_warehouse_id' => $warehouseStock->warehouse_id,
                   
            ];
         
            Receipt::insert($receiptData);
        }

      
       
        //empty sessions
        Receipt::Empty($request);
    }


    /**
     * Get the store associated with the order.
     */
    public function store()
    {
        return $this->hasOne(Store::class,'order_store_id','store_id');
    }

   
}
