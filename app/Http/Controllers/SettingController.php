<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

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
        if ($request->get('resource_type') == 'voucher') {
            $default_structure = (new Setting())->getAttribute('setting_offer')[1];
            $settingInput = $request->except('_token', '_method', 'resource_type', 'setting_id', 'created_at', 'updated_at');
            $new_voucher = array_replace_recursive($default_structure, $settingInput);
            if ($this->settingModel = Setting::find($request->get('setting_id'))) {
                $setting_offer = $this->settingModel->setting_offer;
                if (!empty($setting_offer)) {
                    $last_key = (int)collect($setting_offer)->keys()->last();
                    $setting_offer[$last_key + 1] = $new_voucher;
                } else {
                    $setting_offer[1] = $new_voucher;
                }
                $this->settingModel->setting_offer = $setting_offer;
                $this->settingModel->save();
                return back()->with('success', 'Added Successfuly');
            } else {
                return back()->withInput()->withErrors(['error' => trans('Setting not found')]);
            }
        }

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

        if ($request->get('resource_type') == 'voucher') {
            $this->settingModel['setting_id'] = $setting->setting_id;
            $this->settingModel['setting_offer'] = $setting->setting_offer[$request->get('index')];
            $this->settingModel['edit'] = true;
            return view('menu.setting.vouchers.edit', ['data' => $this->Data(), 'index' => $request->get('index')]);
        }

        // Check condition from url to edit setting_stock_group
        if($request->has('index')) {
            $edit_setting_stock_group = $setting->setting_stock_group;
            $this->settingModel['setting_id'] = $setting->setting_id;
            $this->settingModel['setting_stock_group'] = $edit_setting_stock_group[$request->index];
            $this->settingModel['edit'] = true;
            return view('menu.setting.settingStockGroupEdit', ['data' => $this->Data()]);
        }
        return view('Setting.edit', ['project' => $setting]);
    }

    public function Update(Request $request, $setting)
    {
        $this->settingModel = Setting::find($setting);
        $settingInput = $request->except('_token', '_method');

        if ($request->get('resource_type') == 'voucher') {
            if ($request->has('voucherUpdate')) {
                if (!$request->has('setting_offer') || !count($request->get('setting_offer'))) {
                    return back()->withErrors(['error' => trans('Vouchers not found')]);
                }
                $setting_offer = $this->settingModel->setting_offer;
                $settingInput = $request->except('_token', '_method', 'resource_type', 'setting_id', 'index', 'created_at', 'updated_at');
                foreach ($settingInput['setting_offer'] as $setting_offer_id => $setting_offer_values) {
                    $setting_offer[$setting_offer_id] = array_replace_recursive($setting_offer[$setting_offer_id], $setting_offer_values);
                }
                $this->settingModel->setting_offer = $setting_offer;
                $this->settingModel->update();
                return back()->with('success', trans('Success'));
            } elseif ($request->has('voucherDelete')) {
                return $this->Destroy($request, $setting);
            } else {
                return back()->with('message', trans('Action not found'));
            }
        }

        // Check condition from request to update particular index of setting_stock_group
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
        return view('Setting.edit', ['project' => $setting]);
    }

    public function Destroy(Request $request, $setting)
    {

        if ($request->get('resource_type') == 'voucher') {
            if (empty($request->get('setting_offer_delete_indexes'))) {
                return back()->with('message', 'Please, select vouchers');
            }

            $setting_offer_delete_indexes = $request->get('setting_offer_delete_indexes');
            $setting = Setting::find($setting);
            $setting_offer = $setting->setting_offer;
            foreach ($setting_offer_delete_indexes as $setting_offer_index => $tmp) {
                if (isset($setting_offer[$setting_offer_index])) {
                    unset($setting_offer[$setting_offer_index]);
                }
            }
            $setting->setting_offer = $setting_offer;
            $setting->update();
            return back()->with('success', 'Success');
        }

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

    private function Data()
    {
        return [
            'settingModel' => $this->settingModel,
            'settingList' => $this->settingList,
        ];
    }
}
