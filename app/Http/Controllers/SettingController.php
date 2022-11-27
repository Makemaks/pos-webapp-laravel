<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Arr;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\User;


class SettingController extends Controller
{

    private $settingModel;
    private $settingList;

    public function Index(Request $request)
    {       
        //floor Plan code
        if ($request->session()->has('view') && $request->session()->get('view') == 'floor-plan') {

            dd('hello');

        }
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        //$setting_stock_set = ["category", "group", "plu"];
        //$setting_stock_set_key = array_search( $request->session()->get('view'), $setting_stock_set);


        if ($request->session()->has('view')) {
            $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)
                ->first();
            $request->session()->keep('view');

            return view('menu.setting.group', ['data' => $this->Data()]);
        } else {
            $this->settingList = Setting::paginate(20);
            return view('setting.index', ['data' => $this->Data()]);
        }
    }

    public function Create()
    {
        $this->settingModel = new Setting();
        return view('Setting.create', ['data' => $this->Data()]);
    }

    public function Store(Request $request)
    {
        // Check condition from request to add new setting_stock_set
        if (isset($request->form['setting_stock_set'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_stock_set',$request->form['setting_stock_set']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_offer'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_offer',$request->form['setting_offer']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_key'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_key',$request->form['setting_key']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_stock_tag'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_stock_tag',$request->form['setting_stock_tag']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_stock_tag_group'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_stock_tag_group',$request->form['setting_stock_tag_group']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_vat'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_vat',$request->form['setting_vat']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_stock_set_menu'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_stock_set_menu',$request->form['setting_stock_set_menu']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_preset_message'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_preset_message',$request->form['setting_preset_message']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_price_level_scheduler'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_price_level_scheduler',$request->form['setting_price_level_scheduler']);
            return back()->with('success', 'Added Successfuly');
        }
        if ($request->hasFile('setting_logo_url')) {
            
            $upload = $request->setting_logo_url->store('/images/uploads');
        }

        
        
        $settingInput = $request->except('_token', '_method');
        $settingInput['setting_logo_url'] = $upload;



        $settingInput['created_at'] =  \Carbon\Carbon::now();
        $settingInput['updated_at'] = \Carbon\Carbon::now();


        Setting::insert($settingInput);

        return back()->with('success', 'Setting Added Successfuly');
    }

    public function Edit(Request $request, $setting)
    {
        $this->settingModel = Setting::find($setting);
        
        // Check condition from url to edit setting_stock_set
        if($request->has('index')) {
            $request->session()->reflash();
            $this->settingModel['setting_stock_set'] = $this->settingModel['setting_stock_set'][$request->index];
            $this->settingModel['edit'] = true;
            return view('menu.setting.settingStockGroup', ['data' => $this->Data()]);
        } else if($request->stock_offer['index']) {
            $this->settingModel['setting_offer'] = $this->settingModel['setting_offer'][$request->stock_offer['index']];
            $this->settingModel['edit'] = true;
            return view('menu.setting.mix-&-match', ['data' => $this->Data()]);
        }
        return view('Setting.edit', ['project' => $settingsetting.update]);
    }

    public function Update(Request $request, $setting)
    {
        // dd($request->all());
        $this->settingModel = Setting::find($setting);
        $settingInput = $request->except('_token', '_method', 'created_at', 'updated_at');
        $request->session()->reflash();

        if ($request->settingDelete) {
            $this->settingModel = Setting::find($setting);
            if($request->setting_offer_delete) {
                $setting_offers = $this->settingModel->setting_offer;

                $setting_offer = $this->DeleteColumnIndex($request->setting_offer_delete, $setting_offers);
                $this->settingModel->setting_offer = $setting_offer;
                $view = 'menu.setting.mix-&-match';
            } else if ($request->setting_stock_set_delete) {
                $setting_stock_sets = $this->settingModel->setting_stock_set;

                $setting_stock_set = $this->DeleteColumnIndex($request->setting_stock_set_delete, $setting_stock_sets);
                $this->settingModel->setting_stock_set = $setting_stock_set;
                $view = 'menu.setting.settingStockGroup';
            } else if($request->setting_key_delete) {
                $setting_keys = $this->settingModel->setting_key;

                $setting_key = $this->DeleteColumnIndex($request->setting_key_delete, $setting_keys);
                $this->settingModel->setting_key = $setting_key;
                $view = 'menu.setting.key';
            } else if($request->setting_stock_tag_delete) {
                $setting_stock_tags = $this->settingModel->setting_stock_tag;

                $setting_stock_tag = $this->DeleteColumnIndex($request->setting_stock_tag_delete, $setting_stock_tags);
                $this->settingModel->setting_stock_tag = $setting_stock_tag;
                $view = 'menu.setting.settingStockTag';
            } else if($request->setting_stock_tag_group_delete) {
                $setting_stock_tag_groups = $this->settingModel->setting_stock_tag_group;

                $setting_stock_tag_group = $this->DeleteColumnIndex($request->setting_stock_tag_group_delete, $setting_stock_tag_groups);
                $this->settingModel->setting_stock_tag_group = $setting_stock_tag_group;
                $view = 'menu.setting.settingStockTagGroup';
            } else if($request->setting_vat_delete) {
                $setting_vats = $this->settingModel->setting_vat;

                $setting_vat = $this->DeleteColumnIndex($request->setting_vat_delete, $setting_vats);
                $this->settingModel->setting_vat = $setting_vat;
                $view = 'menu.setting.settingVat';
            } else if($request->setting_stock_set_menu_delete) {
                $setting_stock_set_menus = $this->settingModel->setting_stock_set_menu;

                $setting_stock_set_menu = $this->DeleteColumnIndex($request->setting_stock_set_menu_delete, $setting_stock_set_menus);
                $this->settingModel->setting_stock_set_menu = $setting_stock_set_menu;
                $view = 'menu.setting.settingStockSetMenu';
            } else if($request->setting_preset_message_delete) {
                $setting_preset_messages = $this->settingModel->setting_preset_message;

                $setting_preset_message = $this->DeleteColumnIndex($request->setting_preset_message_delete, $setting_preset_messages);
                $this->settingModel->setting_preset_message = $setting_preset_message;
                $view = 'menu.setting.settingPresetMessage';
            } else if($request->setting_price_level_scheduler_delete) {
                $setting_price_level_schedulers = $this->settingModel->setting_price_level_scheduler;

                $setting_price_level_scheduler = $this->DeleteColumnIndex($request->setting_price_level_scheduler_delete, $setting_price_level_schedulers);
                $this->settingModel->setting_price_level_scheduler = $setting_price_level_scheduler;

                $this->settingModel->update();
                
                // To show stock in index
                $this->StockPrice();
                
                $view = 'menu.setting.settingPriceLevelScheduler';
                return view($view, ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
            } 
            $this->settingModel->update();
            return view($view, ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        }
        else if ($request->setting_stock_set) { //update
            $filter = Arr::except($this->settingModel->setting_stock_set, array_keys($request->setting_stock_set));
            $this->settingModel->setting_stock_set = collect($settingInput['setting_stock_set']+$filter)->sortKeys();
        } else if ($request->setting_offer) {
            $filter = Arr::except($this->settingModel->setting_offer, array_keys($request->setting_offer));
            $this->settingModel->setting_offer = collect($settingInput['setting_offer']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.mix-&-match', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_key) {
            $filter = Arr::except($this->settingModel->setting_key, array_keys($request->setting_key));
            $this->settingModel->setting_key = collect($settingInput['setting_key']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.key', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_stock_tag) {
            $filter = Arr::except($this->settingModel->setting_stock_tag, array_keys($request->setting_stock_tag));
            $this->settingModel->setting_stock_tag = collect($settingInput['setting_stock_tag']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.settingStockTag', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_stock_tag_group) {
            $filter = Arr::except($this->settingModel->setting_stock_tag_group, array_keys($request->setting_stock_tag_group));
            $this->settingModel->setting_stock_tag_group = collect($settingInput['setting_stock_tag_group']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.settingStockTagGroup', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_vat) {
            $filter = Arr::except($this->settingModel->setting_vat, array_keys($request->setting_vat));
            $this->settingModel->setting_vat = collect($settingInput['setting_vat']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.settingVat', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_stock_set_menu) {
            $filter = Arr::except($this->settingModel->setting_stock_set_menu, array_keys($request->setting_stock_set_menu));
            $this->settingModel->setting_stock_set_menu = collect($settingInput['setting_stock_set_menu']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.settingStockSetMenu', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_preset_message) {
            $filter = Arr::except($this->settingModel->setting_preset_message, array_keys($request->setting_preset_message));
            $this->settingModel->setting_preset_message = collect($settingInput['setting_preset_message']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.settingPresetMessage', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        } else if ($request->setting_price_level_scheduler) {
            $filter = Arr::except($this->settingModel->setting_price_level_scheduler, array_keys($request->setting_price_level_scheduler));
            $this->settingModel->setting_price_level_scheduler = collect($settingInput['setting_price_level_scheduler']+$filter)->sortKeys();
            $this->settingModel->update();

            // To show stock in index
            $this->StockPrice();
            
            return view('menu.setting.settingPriceLevelScheduler', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
        }
        // else if($request->code) {
        //     $setting_stock_set = $this->settingModel->setting_stock_set;
        //     $update_setting_stock_set_data = $setting_stock_set[$request->index];
        //     $update_setting_stock_set_data['code'] = $request->code;
        //     $update_setting_stock_set_data['name'] = $request->name;
        //     $setting_stock_set[$request->index] = $update_setting_stock_set_data;
        //     $this->settingModel->setting_stock_set = $setting_stock_set;
        // } 
        
        $this->settingModel->update();
        return redirect()->back()->with('success', 'Setting Updated Successfuly');
    }

    public function Destroy(Request $request, $setting)
    {
        /* $currentRoute = explode('-', $setting);
        if($request->settingDelete){
            foreach($request->setting_offer_delete as $setting_offer_delete){
                
            }
        }
        else if(is_array($currentRoute)) {
            $this->settingModel = Setting::find($currentRoute[0]);
            $setting_stock_set = $this->settingModel->setting_stock_set;
            unset($setting_stock_set[$currentRoute[1]]);
            $this->settingModel->setting_stock_set = $setting_stock_set;
            $this->settingModel->update();
            $request->session()->reflash();
         
            $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

            $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id);
            foreach ($this->stockList  as $key => $value) {
                //$stockModel->stock_merchandise['category_id']
            }

            return view('menu.setting.settingStockGroup', ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        } else {
            Setting::destroy($setting);
        } */

        Setting::destroy($setting);
        
       
    }

    private function StoreSettingColumn($id,$column_type,$form_request)
    {
        $this->settingModel = Setting::find($id);
        $columns = $this->settingModel->$column_type;
        if(!empty($columns)){
            $last_key = (int)collect($columns)->keys()->last();
            $columns[$last_key + 1] = $form_request;
        } else {
            $columns[1] = $form_request;
        }
        $this->settingModel->$column_type = $columns;
        $this->settingModel->save();
        return true;
    }

    private function DeleteColumnIndex($request_delete, $setting_column)
    {
        foreach($setting_column as $key => $setting) {
            if(in_array($key, $request_delete)) {
                unset($setting_column[$key]);
            }
        }
        return $setting_column;
    }

    private function StockPrice()
    {
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)->first();

        $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)->paginate(20);

        $stockPrices = $this->stockList->first()->stock_price;

        $stock_price_count = 0;
        $stock_price_key = 0;
        foreach($stockPrices as $key => $stockPrice) {
            if($stock_price_count < count($stockPrice)) {
                $stock_price_key = $key;
                $stock_price_count = count($stockPrice);
            }
        }
        
        $this->settingModel['stock_prices'] = collect($stockPrices[$stock_price_key])->keys();
        return true;
    }

    private function Data()
    {
        return [
            'settingModel' => $this->settingModel,
            'settingList' => $this->settingList,
        ];
    }
}
