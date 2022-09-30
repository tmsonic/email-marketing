<?php

namespace App\Helpers\Marketing;

use DB;
use Exception;

class SendinblueHelper
{
    public static function subscribeToSendinblueList($name, $email, &$errorMsg)
    {
        $sendinblueConfig = DB::table('sendinblue_configs')->first();
        if(is_null($sendinblueConfig))
        {
            $errorMsg = __('email-marketing.sb_config_not_found');
            return false;
        }

        if(empty($sendinblueConfig->api_key))
        {
            $errorMsg = __('email-marketing.sb_api_not_found');
            return false;
        }

        if(empty($sendinblueConfig->list_id))
        {
            $errorMsg = __('email-marketing.sb_list_id_not_found');
            return false;
        }

        $config = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $sendinblueConfig->api_key);

        $apiInstance = new \SendinBlue\Client\Api\ContactsApi(
            new \GuzzleHttp\Client(),
            $config
        );
        $createContact = new \SendinBlue\Client\Model\CreateContact(); // Values to create a contact
        $createContact['email'] = $email;
        $createContact['listIds'] = [intval($sendinblueConfig->list_id)];
        $createContact['attributes'] = ['FIRSTNAME' => $name];

        try
        {
            $result = $apiInstance->createContact($createContact);
        }
        catch (Exception $e)
        {
            if(method_exists($e, 'getResponseBody'))
            {
                $errorResponse = $e->getResponseBody();
                $jsonDecodedObj = json_decode($errorResponse);
                // the error response from sendinblue should contain a message property, which describes the error
                if(property_exists($jsonDecodedObj, 'message'))
                {
                    $errorMsg = $jsonDecodedObj->message;
                }
                else
                {
                    $errorMsg = __('email-marketing.sth_went_wrong_while_subscribe');
                }
            }
            else
            {
                $errorMsg = __('email-marketing.sth_went_wrong_while_subscribe');
            }

            return false;
        }

        return true;
    }

}
