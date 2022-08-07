<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\GetresponseConfig;
use DB;

class GetresponseController extends Controller
{
    public function getresponse()
    {
        $meta_title = __('admin.getresponse');
        $config = DB::table('getresponse_configs')->first();
        return view('admin.getresponse', compact('meta_title', 'config'));
    }

    public function updateGetresponse(Request $request)
    {
        $config = GetresponseConfig::first();
        if( is_null($config)  )
        {
            return redirect()->back()->with('failureMsg', __('admin.the_config_not_found'))->withInput();
        }

        $validator = Validator::make($request->all(), [
            'api_key' => ['required', 'string', 'max:1000'],
            'list_token' => ['required', 'string', 'max:1000'],
        ]);

        if( $validator->fails() )
        {
            $errorJson = $validator->errors();
            $beautifiedJson = GlobalHelper::beautifyJson($errorJson);

            return redirect()->back()->with('failureMsg', $beautifiedJson )->withErrors($validator)->withInput();
        }

        $config->api_key = $request->api_key;
        $config->list_token = $request->list_token;
        $config->save();

        return redirect(route('admin.getresponse'))->with('successMsg',  __('admin.settings_update_success'));
    }
}
