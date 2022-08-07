<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\SendyConfig;
use DB;

class SendyController extends Controller
{
    public function sendy()
    {
        $meta_title = __('admin.sendy');
        $config = DB::table('sendy_configs')->first();
        return view('admin.sendy', compact('meta_title', 'config'));
    }

    public function updateSendy(Request $request)
    {

        $config = SendyConfig::first();
        if( is_null($config)  )
        {
            return redirect()->back()->with('failureMsg', __('admin.the_config_not_found'))->withInput();
        }

        $validator = Validator::make($request->all(), [
            'install_url' => ['required', 'string', 'max:1000'],
            'api_key' => ['required', 'string', 'max:1000'],
            'list_id' => ['required', 'string', 'max:1000'],
        ]);

        if( $validator->fails() )
        {
            $errorJson = $validator->errors();
            $beautifiedJson = GlobalHelper::beautifyJson($errorJson);

            return redirect()->back()->with('failureMsg', $beautifiedJson )->withErrors($validator)->withInput();
        }

        $config->install_url = $request->install_url;
        $config->api_key = $request->api_key;
        $config->list_id = $request->list_id;
        $config->save();

        return redirect(route('admin.sendy'))->with('successMsg',  __('admin.settings_update_success'));
    }
}
