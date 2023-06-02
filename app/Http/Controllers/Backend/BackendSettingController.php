<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class BackendSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:settings-update', [ 'only' => [ 'index', 'update' ] ]);
    }
    public function index()
    {
        if (!auth()->user()->can('settings-update')) abort(403);
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {

        foreach ($request->settings as $key => $value) {
            if (!in_array($key, [ 'website_logo', 'website_wide_logo', 'website_icon', 'website_cover' ])){
                if (Setting::where('key', $key)->count()) {
                    Setting::where('key', $key)->update([ 'value' => $value ]);
                }else{
                    Setting::query()->create([ 'key' => $key ,'value' => $value ]);
                }
            }
        }
        if ($request->hasFile('settings.website_logo')) {
            $website_logo_setting = Setting::where('key', 'website_logo')->first();
            $image                = $website_logo_setting->addMedia($request[ 'settings' ][ 'website_logo' ])->toMediaCollection('website_logo');
            $website_logo_setting->update([ 'value' => $image->id . '/' . $image->file_name ]);
        }
        if ($request->hasFile('settings.website_wide_logo')) {
            $website_wide_logo_setting = Setting::where('key', 'website_wide_logo')->first();
            $image                     = $website_wide_logo_setting->addMedia($request[ 'settings' ][ 'website_wide_logo' ])->toMediaCollection('website_wide_logo');
            $website_wide_logo_setting->update([ 'value' => $image->id . '/' . $image->file_name ]);
        }
        if ($request->hasFile('settings.website_icon')) {
            $website_icon_setting = Setting::where('key', 'website_icon')->first();
            $image                = $website_icon_setting->addMedia($request[ 'settings' ][ 'website_icon' ])->toMediaCollection('website_icon');
            $website_icon_setting->update([ 'value' => $image->id . '/' . $image->file_name ]);

        }
        if ($request->hasFile('settings.website_cover')) {
            $website_cover_setting = Setting::where('key', 'website_cover')->first();
            $image                 = $website_cover_setting->addMedia($request[ 'settings' ][ 'website_cover' ])->toMediaCollection('website_cover');
            $website_cover_setting->update([ 'value' => $image->id . '/' . $image->file_name ]);
        }


        return redirect()->back()->withSuccess('تم تحديث الإعدادات بنجاح', 'عملية ناجحة');

    }

}
