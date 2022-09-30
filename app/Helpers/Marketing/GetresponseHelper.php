<?php

namespace App\Helpers\Marketing;

use DB;

class GetresponseHelper
{
    public static function subscribeToGetresponseList($name, $email, &$errorMsg)
    {
        $getresponseConfig = DB::table('getresponse_configs')->first();
        if(is_null($getresponseConfig))
        {
            $errorMsg = __('email-marketing.gr_config_not_found');
            return false;
        }

        if(empty($getresponseConfig->api_key))
        {
            $errorMsg = __('email-marketing.gr_api_not_found');
            return false;
        }

        if(empty($getresponseConfig->list_token))
        {
            $errorMsg = __('email-marketing.gr_list_token_not_found');
            return false;
        }

        $url = 'https://api.getresponse.com/v3/contacts';
        $httpHeader = array('Content-Type: application/json',
                            'X-Auth-Token: api-key ' . $getresponseConfig->api_key);
        $data = json_encode(array("name" => $name,
                                  "email" => $email,
                                  "campaign" => array("campaignId" => $getresponseConfig->list_token)
                                  ));
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

        // successful return status code is 202 according to:
        // https://apireference.getresponse.com/?_ga=2.133535111.887740822.1659834357-1616157755.1659834357#operation/createContact
        // and
        // https://apidocs.getresponse.com/v3/resources/contacts#contacts.create
        if($info['http_code'] != 202)
        {
            if(!is_null($response))
            {
                $jsonObj = json_decode($response);
                if(property_exists($jsonObj, 'message'))
                {
                    $errorMsg = $jsonObj->message;
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
