<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Arr;

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
        if (isset($request->form['setting_stock_group'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_stock_group',$request->form['setting_stock_group']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_offer'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_offer',$request->form['setting_offer']);
            return back()->with('success', 'Added Successfuly');
        } else if(isset($request->form['setting_key'])) {
            $this->StoreSettingColumn($request['setting_id'],'setting_key',$request->form['setting_key']);
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
        
        // Check condition from url to edit setting_stock_group
        if($request->has('index')) {
            $request->session()->reflash();
            $this->settingModel['setting_stock_group'] = $this->settingModel['setting_stock_group'][$request->index];
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
            } else if ($request->setting_stock_group_delete) {
                $setting_stock_groups = $this->settingModel->setting_stock_group;

                $setting_stock_group = $this->DeleteColumnIndex($request->setting_stock_group_delete, $setting_stock_groups);
                $this->settingModel->setting_stock_group = $setting_stock_group;
                $view = 'menu.setting.settingStockGroup';
            } else if($request->setting_key_delete) {
                $setting_keys = $this->settingModel->setting_key;

                $setting_key = $this->DeleteColumnIndex($request->setting_key_delete, $setting_keys);
                $this->settingModel->setting_key = $setting_key;
                $view = 'menu.setting.key';
            }
            $this->settingModel->update();
            return view($view, ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        }
        else if ($request->setting_stock_group) {
            $filter = Arr::except($this->settingModel->setting_stock_group, array_keys($request->setting_stock_group));
            $this->settingModel->setting_stock_group = collect($settingInput['setting_stock_group']+$filter)->sortKeys();
        } else if ($request->setting_offer) {
            $filter = Arr::except($this->settingModel->setting_offer, array_keys($request->setting_offer));
            $this->settingModel->setting_offer = collect($settingInput['setting_offer']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.mix-&-match', ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        } else if ($request->setting_key) {
            $filter = Arr::except($this->settingModel->setting_key, array_keys($request->setting_key));
            $this->settingModel->setting_key = collect($settingInput['setting_key']+$filter)->sortKeys();
            $this->settingModel->update();
            return view('menu.setting.key', ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        } 
        // else if($request->code) {
        //     $setting_stock_group = $this->settingModel->setting_stock_group;
        //     $update_setting_stock_group_data = $setting_stock_group[$request->index];
        //     $update_setting_stock_group_data['code'] = $request->code;
        //     $update_setting_stock_group_data['name'] = $request->name;
        //     $setting_stock_group[$request->index] = $update_setting_stock_group_data;
        //     $this->settingModel->setting_stock_group = $setting_stock_group;
        // } 
        
        $this->settingModel->update();
        return redirect()->back()->with('success', 'Setting Updated Successfuly');
    }

    public function Destroy(Request $request, $setting)
    {
        $currentRoute = explode('-', $setting);
        if($request->settingDelete){
            foreach($request->setting_offer_delete as $setting_offer_delete){
                
            }
        }
        else if(is_array($currentRoute)) {
            $this->settingModel = Setting::find($currentRoute[0]);
            $setting_stock_group = $this->settingModel->setting_stock_group;
            unset($setting_stock_group[$currentRoute[1]]);
            $this->settingModel->setting_stock_group = $setting_stock_group;
            $this->settingModel->update();
            $request->session()->reflash();
         
            return view('menu.setting.settingStockGroup', ['data' => $this->Data()])->with('success', 'Setting Deleted Successfuly');
        } else {
            Setting::destroy($setting);
        }
        
       
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
