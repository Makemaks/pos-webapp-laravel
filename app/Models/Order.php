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
    
    //public $timestamps = true;

    protected $attributes = [

        "order_setting_vat" => '{}',
        "order_status" => '{}',
        "order_setting_key" => '{}',
        "order_group" => '{}',
    ];

    protected $casts = [
        "order_setting_key" => 'array',
        "order_setting_vat" => 'array',
        "order_group" => 'array',
        "order_status" => 'array',
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
            ->leftJoin('store', 'store.store_id', '=', 'order.order_store_id')
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

  

   
    public static function AverageSale($service_price_sum, $service_price_count)
    {

        $increase =  $service_price_sum * $service_price_count;
        $averageSale = $increase / 100;

        return MathHelper::FloatRoundUp($averageSale, 2);
    }

    public static function Commission($service_price_sum, $service_commission_percentage_sum)
    {

        $increase = $service_price_sum * $service_commission_percentage_sum;
        $commission = $increase / 100;

        return MathHelper::FloatRoundUp($commission, 2);
    }


    public static function AnnualIncome($service_price_sum, $service_commission_percentage_sum)
    {

        $annualIncome = $service_price_sum + $service_commission_percentage_sum;
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
        

        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.setupList')) {

            $data['setupList'] = $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList');

            if ( $data['setupList']['order_price_total'] ) {

                $userModel = User::Account('account_id', Auth::user()->user_account_id)
                ->first();

                $orderData = [];
                $receiptData = [];
                $warehouse_id = NULL;
            
                $orderData += [
                    'order_user_id' => $userModel->user_id,
                    'order_status' => 0,
                    'order_setting_pos_id' => 1,
                    'created_at' => $request->get('created_at'),
                    'updated_at' => $request->get('updated_at')
                ];

                //get receipt stock
                if($request->session()->has('user-session-'.Auth::user()->user_id. '.cartList')){

                    $sessionCartListUser = $request->session()->get('user-session-'.Auth::user()->user_id. '.cartList');
                
                }

                if ( $request->session()->has('user-session-'.Auth::user()->user_id. '.customerCartList') ) {
                    $customerCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.customerCartList');

                    $userModel = User::find($customerCartList[0]['value']);
                    $orderData += [
                        'ordertable_id' => $userModel->user_id,
                        'ordertable_type' => 'User',
                    ];
                }


                //order type
                if (User::UserType()[Auth::User()->user_type] == 'Super Admin' || User::UserType()[Auth::User()->user_type] == 'Admin') {

                    $orderData += [
                        'order_store_id' => $userModel->store_id,
                        'order_type' => array_search('In-Store', Order::OrderType())
                    ];
                
                }else{
                    $orderData += [
                        'order_type' => array_search('Online', Order::OrderType())
                    ];
                }


                //customer details
                if (count( $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList.customer') ) > 0) {

                    $orderData += [
                        'ordertable_id' => $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList.customer')['value'],
                        'ordertable_type' => 'User'
                    ];
                
                }else{
                    $orderData += [
                        'ordertable_id' => $userModel->person_id,
                        'ordertable_type' => 'User'
                    ];
                }

               
                
                //setting_key
                $data = Setting::SettingKeyProcessed($data, 'order_price_total', 'order_setting_key');
                
                //add finalise key
                $orderData += [
                    'order_setting_key' => json_encode($data['setupList']['order_setting_key'])
                ];

            
                $orderID = Order::insertGetId($orderData);
                
                //store receipt
                foreach ($sessionCartListUser as $key => $sessionCartList) {
                
                    //decrement stock from table
                    $warehouseStock = Warehouse::List('warehouse_stock_id', $sessionCartList['stock_id'])
                    ->where('warehouse_store_id', $sessionCartList['store_id'])
                    ->where('warehouse_stock_quantity', '>', 0)
                    ->where('warehouse_type', 2)
                    ->first();
                    
                    $warehouse_quantity = $warehouseStock->warehouse_stock_quantity - $sessionCartList['stock_quantity'];
                
                    Warehouse::where( 'warehouse_id', $warehouseStock->warehouse_id)
                    ->update(['warehouse_stock_quantity' => $warehouse_quantity]);

                    //setting_key
                  
                    $data = Setting::SettingKeyProcessed($data, 'stock_price_total', 'stock_setting_key');

                        $receiptData = [
                            'receipttable_id' => $sessionCartList['stock_id'],
                            'receipttable_type' => 'Stock',
                            'receipt_warehouse_id' => $sessionCartList['warehouse_store_id'],
                            'receipt_order_id' =>  $orderID,
                            'receipt_user_id' => $sessionCartList['user_id'],
                            'receipt_stock_price' => json_encode($sessionCartList['stock_price']),
                            'receipt_stock_vat' => json_encode($sessionCartList['stock_setting_vat']),
                            'receipt_setting_offer' => json_encode($sessionCartList['stock_setting_vat']),
                            'receipt_setting_pos_id' => 1,
                            'receipt_warehouse_id' => $warehouseStock->warehouse_id,
                            'receipt_setting_key' => json_encode($data['setupList']['stock_setting_key'])
                        ];
                
                
                    Receipt::insert($receiptData);
                }

                //empty sessions for this particular cart
                Receipt::Empty($request);
            }

        }

    }

   
}
