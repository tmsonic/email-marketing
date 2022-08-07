<?php

namespace App\Helpers\Marketing;

use DB;
use Exception;

class SendyHelper
{
    public static function subscribeSendyList($name, $email, &$errorMsg)
    {
        $sendyConfig = DB::table('sendy_configs')->first();
        if(is_null($sendyConfig))
        {
            $errorMsg = __('email-marketing.sendy_config_not_found');
            return false;
        }

        if(is_null($sendyConfig->api_key))
        {
            $errorMsg = __('email-marketing.sendy_api_not_found');
            return false;
        }

        if(is_null($sendyConfig->list_id))
        {
            $errorMsg = __('email-marketing.sendy_list_id_not_found');
            return false;
        }

        if(is_null($sendyConfig->install_url))
        {
            $errorMsg = __('email-marketing.sendy_install_url_not_found');
            return false;
        }

        $postdata = http_build_query(
            array(
            'name' => $name,
            'email' => $email,
            'list' => $sendyConfig->list_id,
            'api_key' => $sendyConfig->api_key,
            'boolean' => 'true'
            )
        );

        $opts = array('http' => array('method'  => 'POST', 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata));
        $context  = stream_context_create($opts);

        try
        {
            $result = file_get_contents($sendyConfig->install_url.'/subscribe', false, $context);
        }
        catch(Exception $e)
        {
            $errorMsg = __('email-marketing.sth_went_wrong_while_subscribe');
            return false;

        }

        if($result != 1)
        {
            $errorMsg = $result;
            return false;
        }

        return true;
    }

}
