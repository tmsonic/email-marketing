<?php

namespace App\Helpers\Marketing;

use DB;

class ConvertkitHelper
{
    public static function subscribeToConvertkitSequence($name, $email, &$errorMsg)
    {
        $convertkitConfig = DB::table('convertkit_configs')->first();
        if(is_null($convertkitConfig))
        {
            $errorMsg =  __('email-marketing.ckit_config_not_found');
            return false;
        }

        if(empty($convertkitConfig->api_key))
        {
            $errorMsg = __('email-marketing.ckit_api_not_found');
            return false;
        }

        if(empty($convertkitConfig->sequence_id))
        {
            $errorMsg = __('email-marketing.ckit_sequence_id_not_found');
            return false;
        }

        $url = 'https://api.convertkit.com/v3/sequences/' . $convertkitConfig->sequence_id . '/subscribe';
        $httpHeader = array('Content-Type: application/json; charset=utf-8');
        $data = json_encode(array("api_key" => $convertkitConfig->api_key,
                                  "email" => $email,
                                  "first_name" => $name));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_VERBOSE, true); // useful for debugging curl calls
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // if not set to true, it messes with our fetch API call
        curl_setopt($curl, CURLOPT_FAILONERROR, true); // to fail on HTTP response >= 400
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        if(curl_error($curl))
        {
            $errorMsg = curl_error($curl);
            curl_close($curl);
            return false;
        }

        if($info['http_code'] != 200 && $info['http_code'] != 201)
        {
            if(!is_null($response))
            {
                $jsonObj = json_decode($response);
                if(property_exists($jsonObj, 'error'))
                {
                    $errorMsg = $jsonObj->error;
                }
                else
                {
                    $errorMsg = __('email-marketing.sth_went_wrong_while_subscribe');
                }
            }
            else
            {
                $errorMsg = __('email-marketing.sth_went_wrong_with_request');
            }
            curl_close($curl);
            return false;
        }

        curl_close($curl);
        return true;
    }

}
