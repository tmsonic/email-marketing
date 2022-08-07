<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\SendinblueConfig;
use DB;

class SendinBlueController extends Controller
{
    public function sendinblue()
    {
        $meta_title = __('admin.sendinblue');
        $config = DB::table('sendinblue_configs')->first();
        return view('admin.sendinblue', compact('meta_title', 'config'));
    }

    public function updateSendinblue(Request $request)
    {
        $config = SendinblueConfig::first();
        if( is_null($config)  )
        {
            return redirect()->back()->with('failureMsg', __('admin.the_config_not_found'))->withInput();
        }

        $validator = Validator::make($request->all(), [
            'api_key' => ['required', 'string', 'max:1000'],
            'list_id' => ['required', 'string', 'max:1000'],
        ]);

        if( $validator->fails() )
        {
            $errorJson = $validator->errors();
            $beautifiedJson = GlobalHelper::beautifyJson($errorJson);

            return redirect()->back()->with('failureMsg', $beautifiedJson )->withErrors($validator)->withInput();
        }

        $config->api_key = $request->api_key;
        $config->list_id = $request->list_id;
        $config->save();

        return redirect(route('admin.sendinblue'))->with('successMsg',  __('admin.settings_update_success'));
    }
}
