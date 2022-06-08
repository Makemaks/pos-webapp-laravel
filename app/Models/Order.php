<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\MathHelper;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'order_id';

    protected $attributes = [

        "order_store_id" => 1,
        "order_status" => 0,
        "order_store_id" => 1,
        "order_finalise_key" => '{}'

    ];

    protected $casts = [
        "order_finalise_key" => 'array'
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


    public static function Receipt()
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.order_user_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->select('order.*', 'receipt.*', 'stock.*', 'user.*', 'person.*', 'order.created_at as order_created_at');
    }

    public static function HourlyReceipt()
    {
        return Order::leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.order_user_id')
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
            'Picked up'
        ];
    }
}
