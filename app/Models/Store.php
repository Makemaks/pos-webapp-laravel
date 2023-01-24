<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;


class Store extends Model
{
    use HasFactory;

    protected $table = 'store';
    protected $primaryKey = 'store_id';



    public static function List($column,  $filter)
    {
        return Store::join('company', 'company.company_id', 'store.store_company_id')
            ->where($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }

    public static function Stock()
    {
        return Store::leftJoin('stock', 'stock.stock_store_id', '=', 'store.store_id')
        ->leftJoin('warehouse', 'warehouse.warehouse_stock_id', '=', 'stock.stock_id')
            ->orderBy('store.store_name', 'desc');
    }



    public static function Setting($column,  $filter)
    {
        return Store::leftJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('setting', 'setting.setting_account_id', '=', 'store.store_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }


    public static function Order($column,  $filter)
    {
        return Store::rightJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.ordertable_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->leftJoin('setting', 'setting.setting_account_id', '=', 'store.store_id')
            ->select('order.*', 'receipt.*', 'stock.*', 'store.*', 'user.*', 'person.*', 'setting.*', 'order.created_at as order_created_at')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }

    public static function Company($column,  $filter)
    {
        return Store::leftJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftjoin('company', 'company.company_id', '=', 'store.store_company_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.ordertable_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }

    public static function Account($column,  $filter)
    {
        return Store::leftJoin('account', 'account.account_id', '=', 'store.store_account_id')
            ->leftJoin('company', 'company.company_id', '=', 'store.store_company_id')
            ->where($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }

    public static function Linked($column,  $filter)
    {
        return Store::leftJoin('account', 'account.account_id', '=', 'store.store_id')
            ->whereIn($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }


    public static function Root($column,  $filter)
    {
        return Store::leftJoin('account', 'account.account_id', '=', 'store.store_id')
            ->leftJoin('company', 'company.company_store_id', '=', 'store.store_id')
            ->whereNULL('root_store_id')
            ->where($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }

    public static function User($column,  $filter)
    {
        return Store::leftJoin('person', 'person.user_account_id', '=', 'store.store_id')
            ->leftJoin('user', 'user.user_person_id', '=', 'person.person_id')
            ->where($column,  $filter);
    }

    public static function Address($column,  $filter)
    {
        return Store::leftJoin('address', 'address.addresstable_id', '=', 'store.store_id')
            ->where('addresstable_type', 'store')
            ->where($column,  $filter);
    }

    public static function DatePeriod(Request $request)
    {
        $user_id = null;
        $started_at = Carbon::now()->startOfDay()->toDateTimeString();
        $ended_at = Carbon::now()->toDateTimeString();
        $title = '';
        $table = '';

        $userModel = Auth::user();

        if ($request->title) {
            $title = $request->title;

            if (
                $title === 'monthly_summary'
            ) {
                $started_at = Carbon::now()->startOfMonth()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfMonth()->setTime(23, 59, 59)->toDateTimeString();
                $table = 'payratePartial';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'weekly_summary') {
                $started_at = Carbon::now()->startOfWeek()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfWeek()->setTime(23, 59, 59)->toDateTimeString();
                $table = 'payratePartial';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'time_attendance_daily_hours_worked') {
                $table = 'attendancePartial';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'time_attendance_daily_shifts') {
                $table = 'attendancePartial';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'time_attendance_hours_worked') {
                $table = 'attendanceHoursWorked';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'time_attendance_audit_trail') {
                $table = 'attendanceTrail';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'customer_person_address_list') {
                $table = 'address';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'customer_company_address_list') {
                $table = 'address';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'customer_last_used') {
                $table = 'customerLastUsed';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'blacklisted_customer') {
                $table = 'blacklistCustomer';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'avg_dept_sales_by_day_and_hour') {
                $table = 'deptSales';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'avg_dept_sales_by_day') {
                $table = 'deptSalesByDay';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'avg_sales_by_day_and_hour') {
                $table = 'sales';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'avg_sales_by_day') {
                $table = 'salesByDay';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'hourly_sales') {
                $table = 'hourlySales';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'customer_email_list') {
                $table = 'emailCustomer';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'customer_list') {
                $table = 'customerList';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'clerk_list') {
                $table = 'clerkList';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'clerk_pay_rate_summary') {
                $table = 'clerkPayRate';
                $title = str_replace('_', ' ', $title);
            }

            if ($title === 'plu_sales_by_clerk') {
                $table = 'pluClerk';
                $title = str_replace('_', ' ', $title);
            }
        }

        if ($request->user_id) {
            // searching by user, date or user , date_period
            $request->user_id = $user_id;
            $userModel = User::Person('user_id', $request->user_id)->first();

        }

        if ($request->date_period) {

            // searching by date and date_period
            $date_period = $request->date_period;

            if ($date_period === 'Today') {
                $started_at = Carbon::now()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Yesterday') {
                $started_at = Carbon::yesterday()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::yesterday()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'This Week') {
                $started_at = Carbon::now()->startOfWeek()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfWeek()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Last Week') {
                $started_at = Carbon::now()->startOfWeek()->subWeek()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfWeek()->subWeek()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'This Month') {
                $started_at = Carbon::now()->startOfMonth()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfMonth()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Last Month') {
                $started_at = Carbon::now()->startOfMonth()->subMonth()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfMonth()->subMonth()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'This Quarter') {
                $started_at = Carbon::now()->startOfQuarter()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfQuarter()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Last Quarter') {
                $started_at = Carbon::now()->startOfQuarter()->subQuarter()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfQuarter()->subQuarter()->setTime(23, 59, 59)->toDateTimeString();
            }


        }

        if ($request->ended_at && $request->started_at) {
            // searching by date
            $started_at = $request->started_at;
            $ended_at = $request->ended_at;
        }


        $userModel = User::Account('account_id', Auth::user()->user_account_id)->first();

        $orderList =  Store::Order('store_id',  $userModel->store_id)
        ->whereBetween('order.created_at', [$started_at, $ended_at])
        ->orWhere('user_id', $user_id)
        ->get();


        $orderListASC = $orderList;

        $orderHourly = $orderListASC;

        $orderListLimited100 = $orderListASC;

        $clerkBreakdown = $orderList;



        // Address
        $addressCompany = User::Company('store_id',  $userModel->store_id)
            ->where('addresstable_type', 'Company') // person::company
            ->where('company_type', 1) // supplier::customer::contractor
            ->whereBetween('company.created_at', [$started_at, $ended_at])->orWhere('user_id', $user_id)->get();

        $addressPerson = User::Person('store_id',  $userModel->store_id)
            ->where('addresstable_type', 'Person') // person::company
            ->where('person_type', 2) // employee::non-employee::customer
            ->orWhereBetween('person.created_at', [$started_at, $ended_at])
            ->orWhere('user_id', $user_id)->get();

        // Account level last used
        $accountModel = User::Account('store_id', $userModel->store_id)
            ->orWhereBetween('person.created_at', [$started_at, $ended_at])
            ->orWhere('user_id', $user_id)->get();

        // Account Company / blacklisted
        $accountCompanyModel = User::Account('store_id', $userModel->store_id)
            ->orWhereBetween('person.created_at', [$started_at, $ended_at])->orWhere('user_id', $user_id)->get();

        // Attendance Log
        $attendanceModel = Attendance::User('store_id', $userModel->store_id)
            ->orWhereBetween('attendance.created_at', [$started_at, $ended_at])->orWhere('user_id', $user_id)->get();

        // dept average
        $settingModel = Setting::where('setting_account_id', $userModel->store_id)->first();

        // dropdown clerk option
        $clerkBreakdownOption = User::Account('store_id', $userModel->store_id)->get();

        // clerk list with employment identity
        $clerkList = User::Employment('store_id',  $userModel->store_id)
            ->where('person_type', 0)
            ->get();

        $employmentList = User::Employment('store_id',  $userModel->store_id)
        ->where('attendance_status', '<', 2)
        ->orWhereBetween('attendance.created_at', [$started_at, $ended_at])
        ->orWhere('user_id', $user_id)
        ->get();

        $orderSettingList = Store::Setting('store_id',  $userModel->store_id)->orWhereBetween('order.created_at', [$started_at, $ended_at])->limit(10);
        $eat_in_eat_out = Order::where('order_store_id', $userModel->store_id)->orderBy('order.created_at', 'desc')->orWhereBetween('order.created_at', [$started_at, $ended_at])->get();



        return [
            'orderList' => $orderList,
            'orderSettingList' => $orderSettingList,
            'orderHourly' => $orderHourly,
            'orderListASC' => $orderListASC,
            'orderListLimited100' => $orderListLimited100,
            'clerkBreakdownOption' => $clerkBreakdownOption,
            'clerkBreakdown' => $clerkBreakdown,
            'eat_in_eat_out' => $eat_in_eat_out,
            'userModel' => $userModel,
            'started' => $started_at,
            'ended' => $ended_at,
            'user_id' => $user_id,
            'employmentList' => $employmentList,
            'title' => $title,
            'table' => $table,
            'addressCompany' => $addressCompany,
            'addressPerson' => $addressPerson,
            'accountModel' => $accountModel,
            'accountCompanyModel' => $accountCompanyModel,
            'attendanceModel' => $attendanceModel,
            'settingModel' => $settingModel,
            'clerkList' => $clerkList,

        ];
    }
}
