<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\ConvertkitConfig;
use DB;

class ConvertkitController extends Controller
{
    public function convertkit()
    {
        $meta_title = __('admin.convertkit');
        $config = DB::table('convertkit_configs')->first();
        return view('admin.convertkit', compact('meta_title', 'config'));
    }

    public function updateConvertkit(Request $request)
    {
        $config = ConvertkitConfig::first();
        if( is_null($config)  )
        {
            return redirect()->back()->with('failureMsg', __('admin.the_config_not_found'))->withInput();
        }

        $validator = Validator::make($request->all(), [
            'api_key' => ['required', 'string', 'max:1000'],
            'sequence_id' => ['required', 'string', 'max:1000'],
        ]);

        if( $validator->fails() )
        {
            $errorJson = $validator->errors();
            $beautifiedJson = GlobalHelper::beautifyJson($errorJson);

            return redirect()->back()->with('failureMsg', $beautifiedJson )->withErrors($validator)->withInput();
        }

        $config->api_key = $request->api_key;
        $config->sequence_id = $request->sequence_id;
        $config->save();

        return redirect(route('admin.convertkit'))->with('successMsg',  __('admin.settings_update_success'));
    }
}
