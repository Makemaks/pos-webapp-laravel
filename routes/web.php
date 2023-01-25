<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderManagerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreManagerController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReceiptManagerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PlanManagerController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ContactManagerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuBuilderController;
use App\Http\Controllers\WarehouseController;

use App\Http\Controllers\API\HomeAPIController;
use App\Http\Controllers\API\GatewayAPIController;
use App\Http\Controllers\API\ChartAPIController;
use App\Http\Controllers\API\CartAPIController;
use App\Http\Controllers\API\SchemeAPIController;
use App\Http\Controllers\API\OrderAPIController;


Route::middleware(['datetimeMiddleware'])->group(function () {


Route::get('/', function () {
    return view('welcome.index');
});

Route::get('/menu', function () {
    return view('menu.index');
})->name('menu');

Route::get('login', [AuthenticationController::class, 'Login'])->name('authentication.login');
Route::get('forgot-password', [AuthenticationController::class, 'ForgotPassword'])->name('authentication.forgot-password');
Route::get('reset-password/{id}', [AuthenticationController::class, 'ResetPassword'])->name('authentication.reset-password');
Route::get('logout', [AuthenticationController::class, 'Logout'])->name('authentication.logout');
Route::get('clock-out', [AuthenticationController::class, 'ClockOut'])->name('authentication.clock-out');
Route::get('register', [AuthenticationController::class, 'Register'])->name('authentication.register');
Route::get('admin-store/{store}', [AuthenticationController::class, 'adminStore'])->name('authentication.admin-store');


Route::resource('home', HomeController::class);
Route::resource('user', UserController::class);
Route::resource('company', CompanyController::class);
// Route::resource('address', AddressController::class);
Route::resource('person', PersonController::class);
Route::resource('store', StoreController::class);
Route::resource('order', OrderController::class);
Route::resource('stock', StockController::class);
// Route::resource('activity', ActivityController::class);
// Route::resource('subscription', SubscriptionController::class);
Route::resource('setting', SettingController::class);
Route::resource('dashboard', DashboardController::class);
// Route::resource('reservation', ReservationController::class);
// Route::resource('scheme', SchemeController::class);
// Route::resource('plan', PlanController::class);

// Route::resource('account', AccountController::class);
Route::resource('report', ReportController::class);
Route::resource('event', EventController::class);
Route::resource('warehouse', WarehouseController::class);
Route::resource('receipt', ReceiptController::class);

// Route::get('mail/', [MailController::class, 'Index'])->name('mail.index');
// Route::post('mail/send', [MailController::class, 'Send'])->name('mail.send');



/* Route::get('home/', [HomeController::class,'Index'])->name('home.index');
Route::get('home/store', [HomeController::class,'Create'])->name('home.create');
Route::get('home/create', [HomeController::class,'Store'])->name('home.store');
Route::get('home/category/{category}', [HomeController::class,'Category'])->name('home.category');
Route::get('home/user/{user}', [HomeController::class,'User'])->name('home.user');

Route::get('receipt-manager/', [ReceiptManagerController::class,'Index'])->name('receipt-manager.index');
Route::get('receipt-manager/create', [ReceiptManagerController::class,'Create'])->name('receipt-manager.create');
Route::get('receipt-manager/suspend', [ReceiptManagerController::class,'Suspend'])->name('receipt-manager.suspend');
Route::get('receipt-manager/awaiting', [ReceiptManagerController::class,'Awaiting'])->name('receipt-manager.awaiting');
Route::get('receipt-manager/empty', [ReceiptManagerController::class,'Empty'])->name('receipt-manager.empty');
Route::get('receipt-manager/remove/{receipt}', [ReceiptManagerController::class,'Remove'])->name('receipt-manager.remove');
Route::get('receipt-manager/recover/{receipt}', [ReceiptManagerController::class,'Recover'])->name('receipt-manager.recover');
Route::get('receipt-manager/checkout', [ReceiptManagerController::class,'Checkout'])->name('receipt-manager.checkout');

Route::get('init/account-link/model/{model}', [InitController::class,'Link'])->name('init.account-link');
Route::get('init/person/type/model/{type}/{model}', [InitController::class,'Person'])->name('init.person');
Route::get('init/dashboard/type/model/{type}/{model}', [InitController::class,'Dashboard'])->name('init.dashboard');
Route::get('init/scheme/type/model/{type}/{model}', [InitController::class,'Scheme'])->name('init.scheme');
Route::get('init/account/type/model/{type}/{model}', [InitController::class,'Account'])->name('init.account');
Route::get('init/order/type/model/{type}/{model}', [InitController::class,'Order'])->name('init.order');
Route::get('init/card/type/model/{type}/{model}', [InitController::class,'Card'])->name('init.card');
Route::get('init/print/model/{type}/{model}', [InitController::class,'Print'])->name('init.print');

Route::get('contact-manager/dashboard/type/model/{type}/{model}', [ContactManagerController::class,'Dashboard'])->name('contact-manager.dashboard');
Route::get('contact-manager/branch/type/model/{type}/{model}', [ContactManagerController::class,'Branch'])->name('contact-manager.branch');
Route::get('contact-manager/person/type/model/{type}/{model}', [ContactManagerController::class,'Person'])->name('contact-manager.person');
Route::get('contact-manager/person/type/model/{type}/{model}', [ContactManagerController::class,'Person'])->name('contact-manager.person');
Route::get('contact-manager/address/type/model/{type}/{model}', [ContactManagerController::class,'Address'])->name('contact-manager.address');

Route::get('store-manager/dashboard/store/{store}', [StoreManagerController::class,'Dashboard'])->name('store-manager.dashboard');
Route::get('store-manager/person/store/{store}', [StoreManagerController::class,'Person'])->name('store-manager.person');
Route::get('store-manager/person/store/{store}', [StoreManagerController::class,'Person'])->name('store-manager.person');
Route::get('store-manager/address/store/{store}', [StoreManagerController::class,'Address'])->name('store-manager.address');
Route::get('store-manager/branch/store/{store}', [StoreManagerController::class,'Branch'])->name('store-manager.branch');
Route::get('store-manager/order/store/{store}', [StoreManagerController::class,'Order'])->name('store-manager.order');
 */

Route::get('menu/stock/', [MenuController::class,'Stock'])->name('menu.stock');
Route::get('menu/setting/', [MenuController::class,'Setting'])->name('menu.setting');
Route::get('menu/order/', [MenuController::class,'Order'])->name('menu.order');
Route::get('menu/customer/', [MenuController::class,'Customer'])->name('menu.customer');

Route::get('menu/home/', [MenuController::class,'Home'])->name('menu.home');

Route::get('menu/stock/get-list/', [StockController::class,'getStockList'])->name('menu.stock.get_list');

Route::apiResources([
    'home-api' => HomeAPIController::class,
    'gateway-api' => GatewayAPIController::class,
    'chart-api' => ChartAPIController::class,
    'cart-api' => CartAPIController::class,
    'scheme-api' => SchemeAPIController::class,
    'order-api' => OrderAPIController::class,
]);

/* Route::get('order-manager/checkout/', [OrderManagerController::class, 'Checkout'])->name('order-manager.checkout');
Route::post('order-manager/checkin', [OrderManagerController::class, 'Checkin'])->name('order-manager.checkin');

Route::get('plan-manager/plan/scheme/{type}/{id}', [PlanManagerController::class,'Scheme'])->name('plan-manager.scheme');
Route::get('plan-manager/statistics/{stock}', [PlanManagerController::class,'Statistics'])->name('plan-manager.statistics'); */

});
