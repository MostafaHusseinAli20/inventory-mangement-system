<?php

namespace App\Repositories\Settings;

use App\Http\Requests\Admin\Settings\SettingRequest;
use App\Interfaces\Settings\SettingInterface;
use App\Models\Admin;
use App\Models\Setting;
use DateTime;
use Illuminate\Support\Facades\DB;

class SettingRepository implements SettingInterface
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function get_setting_data()
    {
        $data = Setting::where('com_code', auth()->guard('admin')->user()->com_code)->first();
        if ($data && $data->updated_by) {
            $data->updated_by_admin = Admin::find($data->updated_by)?->name;
        }

        $dt = new DateTime($data['updated_at']);
        $date = $dt->format('Y-m-d');
        $time = $dt->format('h:i');
        $newDateTime = date('A', strtotime($time));
        $newDateTimeType = $newDateTime == 'AM' ? 'صباحا ' : 'مساء';

        return response()->json([
            'data' => $data,
            'date' => $date,
            'time' => $time,
            'newDateTimeType' => $newDateTimeType
        ]);
    }

    public function edit()
    {
        $data = Setting::where('com_code', auth()->guard('admin')->user()->com_code)->first();
        return view('admin.settings.edit', [
            'data' => $data
        ]);
    }

    public function update_setting_data(SettingRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Setting::where('com_code', auth()->guard('admin')->user()->com_code)->first();
            $data->update([
                'system_name' => $request->system_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'updated_by' => auth()->guard('admin')->user()->id,
                'general_alert' => $request->general_alert,
            ]);

            if($request->hasFile('logo')) {
                $data->update([
                    'logo' => $request->file('logo')->store("settings/{$data->system_name}/logos", 'uploads'),
                ]);
            }

            DB::commit();
            return response()->json([
                'data' => $data,
                'message' => 'تم التعديل بنجاح'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}