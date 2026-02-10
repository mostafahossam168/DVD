<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        // return view('dashboard.settings');
    }
    public function update(Request $request)
    {
        $current_file = ['logo', 'fav'];
        $files = $request->file();
        $data = $request->except(array_keys($files), '_token');
        if (empty($files)) {
            foreach ($current_file as $ele) {
                $data[$ele] = setting($ele);
            }
        }
        foreach ($files as $file => $value) {
            if (!empty(setting($file))) {
                delete_file(setting($file));
            }
            $data[$file] = store_file($value, 'settings');
        }
        DB::table('settings')->delete();
        setting($data)->save();
        return redirect()->back()->with('success', 'تم حفظ التعديلات بنجاح');
    }
}
