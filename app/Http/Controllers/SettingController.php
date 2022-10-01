<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Arr;
use App\Models\Setting;
use App\Models\User;

class SettingController extends Controller
{

    private $settingModel;
    private $settingList;

    public function Index(Request $request)
    {

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        //$setting_stock_group = ["category", "group", "plu"];
        //$setting_stock_group_key = array_search( $request->session()->get('view'), $setting_stock_group);


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
        // Check condition from request to add new setting_stock_group
        if ($request->code) {
            $this->settingModel = Setting::find($request['setting_id']);
            $settingInput = $request->except('_token', '_method', 'setting_id', 'created_at', 'updated_at');
            $stock_group = $this->settingModel->setting_stock_group;
            if(!empty($stock_group)){
                $last_key = (int)collect($stock_group)->keys()->last();
                $stock_group[$last_key + 1] = $settingInput;
            } else {
                $stock_group[1] = $settingInput;
            }
            $this->settingModel->setting_stock_group = $stock_group;
            $this->settingModel->save();
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
        $setting = Setting::find($setting);

        // Check condition from url to edit setting_stock_group
        if($request->has('index')) {
            $edit_setting_stock_group = $setting->setting_stock_group;
            $this->settingModel['setting_id'] = $setting->setting_id;
            $this->settingModel['setting_stock_group'] = $edit_setting_stock_group[$request->index];
            $this->settingModel['edit'] = true;
            return view('menu.setting.settingStockGroupEdit', ['data' => $this->Data()]);
        }
        return back()->with('success', 'Setting Added Successfuly');
    }

    public function Update(Request $request, $setting)
    {
        $this->settingModel = Setting::find($setting);
        $settingInput = $request->except('_token', '_method');

        // Check condition from request to update particular index of setting_stock_group

        if ($request->settingDelete) {
            if ($request->setting_offer_delete) {
                $setting_offers = $this->settingModel->setting_offer;
                $setting_offer = $this->DeleteColumnIndex($request->setting_offer_delete, $setting_offers);
                $this->settingModel->setting_offer = $setting_offer;
                $view = 'menu.setting.mix-&-match';
            }

            $this->settingModel->update();
            return view($view, ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        } else {
            if ($request->code) {
                $setting_stock_group = $this->settingModel->setting_stock_group;
                $update_setting_stock_group_data = $setting_stock_group[$request->index];
                $update_setting_stock_group_data['code'] = $request->code;
                $update_setting_stock_group_data['name'] = $request->name;
                $setting_stock_group[$request->index] = $update_setting_stock_group_data;
                $this->settingModel->setting_stock_group = $setting_stock_group;
                $this->settingModel->update();
                return redirect()->back();
            }
            else if ($request->setting_offer) {
                $filter = Arr::except($this->settingModel->setting_offer, array_keys($request->setting_offer));
                $this->settingModel->setting_offer = collect($settingInput['setting_offer']+$filter)->sortKeys();
                $this->settingModel->update();
                return view('menu.setting.mix-&-match', ['data' => $this->Data()])->with('success', 'Setting Updated Successfuly');
            }
        }
        
       

        $this->settingModel->update();
        return redirect()->back()->with('success', 'Setting Updated Successfuly');
    }

    public function Destroy($setting)
    {
        $currentRoute = explode('-', $setting);
        if(is_array($currentRoute)) {
            $setting_stock_groups = Setting::find($currentRoute[0]);
            $setting_stock_group = $setting_stock_groups->setting_stock_group;
            unset($setting_stock_group[$currentRoute[1]]);
            $setting_stock_groups->setting_stock_group = $setting_stock_group;
            $setting_stock_groups->update();
        } else {
            Setting::destroy($setting);
        }
        
        return back()->with('success', 'Setting Deleted Successfuly');
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

    private function Data()
    {
        return [
            'settingModel' => $this->settingModel,
            'settingList' => $this->settingList,
        ];
    }
}
