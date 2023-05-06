<?php

use App\Setting;

function paytm_checksum($order_data){

    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");
    // following files need to be included
    // lib.config_paytm.php
    //Change the value of PAYTM_MERCHANT_KEY constant with details received from Paytm.
    $setting = Config::get('mobile-config.PAYTM');
    $getSetting=[];
    foreach ($setting as $sk => $ss){
        $getSetting[]='PAYTM_'.$sk;
    }
    $setting_value=Setting::whereIn('key',$getSetting)->get();


    $setting=$setting_value->first(function ($value, $key) {
        return $value->key=="PAYTM_SECRET_KEY";
    });
    define('PAYTM_MERCHANT_KEY', optional($setting)->value);

    // lib/encdec_paytm.php

        function encrypt_e($input, $ky){
            $ky   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt ( $input , "AES-128-CBC" , $ky, 0, $iv );
            return $data;
        }

        function decrypt_e($crypt, $ky){
            $ky   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $ky, 0, $iv );
            return $data;
        }

        function generateSalt_e($length) {
            $random = "";
            srand((double) microtime() * 1000000);

            $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
            $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
            $data .= "0FGH45OP89";

            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
            }

            return $random;
        }

        function checkString_e($value) {
            if ($value == 'null')
                $value = '';
            return $value;
        }

        function getChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getChecksumFromString($str, $key) {

            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }

        function verifychecksum_e($arrayList, $key, $checksumvalue) {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function verifychecksum_eFromStr($str, $key, $checksumvalue) {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function getArray2Str($arrayList) {
            $findme   = 'REFUND';
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function getArray2StrForVerify($arrayList) {
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function redirect2PG($paramList, $key) {
            $hashString = getchecksumFromArray($paramList);
            $checksum = encrypt_e($hashString, $key);
        }

        function removeCheckSumParam($arrayList) {
            if (isset($arrayList["CHECKSUMHASH"])) {
                unset($arrayList["CHECKSUMHASH"]);
            }
            return $arrayList;
        }

        function getTxnStatus($requestParamList) {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }

        function getTxnStatusNew($requestParamList) {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }

        function initiateTxnRefund($requestParamList) {
            $CHECKSUM = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
            $requestParamList["CHECKSUM"] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }

        function callAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

        function callNewAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
        function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getRefundArray2Str($arrayList) {
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function callRefundAPI($refundApiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

        $checkSum = "";

        // below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose.
        $findme   = 'REFUND';
        $findmepipe = '|';

        $paramList = array();
        $order_id = mt_rand(1000,5000).time();// randomString(15);
        $customer_id = \Auth::user()->id ;//randomString(15);

        $setting=$setting_value->first(function ($value, $key) {
            return $value->key=="PAYTM_MERCHANT_ID";
        });
        $paramList["MID"] = isset($setting->value) ? $setting->value : '';
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $customer_id;

        $setting=$setting_value->first(function ($value, $key) {
            return $value->key=="PAYTM_INDUSTRY_TYPE_ID";
        });
        $paramList["INDUSTRY_TYPE_ID"] = isset($setting->value) ? $setting->value : '';

        $setting=$setting_value->first(function ($value, $key) {
            return $value->key=="PAYTM_CHANNEL_ID";
        });
        $paramList["CHANNEL_ID"] = isset($setting->value) ? $setting->value : '';
        $paramList["TXN_AMOUNT"] = '';

        $setting=$setting_value->first(function ($value, $key) {
            return $value->key=="PAYTM_CALLBACK_URL";
        });
        $paramList['CALLBACK_URL'] = optional($setting)->value."".$order_id;

        $setting=$setting_value->first(function ($value, $key) {
            return $value->key=="PAYTM_WEBSITE";
        });
        $paramList["WEBSITE"] = isset($setting->value) ? $setting->value : '';
        // $paramList['EMAIL']
        foreach($order_data as $key => $value)
        {
            $pos = strpos($value, $findme);
            $pospipe = strpos($value, $findmepipe);
            if ($pos === false || $pospipe === false)
            {
                $paramList[$key] = $value;
            }
        }
        // dd($paramList);

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
        $data['order_data'] = $paramList;

        $checksum_json = array("CHECKSUMHASH" => $checkSum , "ORDER_ID" => $order_id, "payt_STATUS" => "1");
        $data['checksum_data'] = $checksum_json;
        return $data;
        //Sample response return to SDK

        //  {"CHECKSUMHASH":"GhAJV057opOCD3KJuVWesQ9pUxMtyUGLPAiIRtkEQXBeSws2hYvxaj7jRn33rTYGRLx2TosFkgReyCslu4OUj\/A85AvNC6E4wUP+CZnrBGM=","ORDER_ID":"asgasfgasfsdfhl7","payt_STATUS":"1"}

        // $paytmChecksum = "";
        // // $paramList = array();
        // $isValidChecksum = FALSE;

        // // $paramList = $_POST;
        // $return_array = $paramList;
        // $paytmChecksum = isset($checkSum) ? $checkSum : ""; //Sent by Paytm pg
        // // $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

        // //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        // $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

        // // if ($isValidChecksum===TRUE)
        // // 	$return_array["IS_CHECKSUM_VALID"] = "Y";
        // // else
        // // 	$return_array["IS_CHECKSUM_VALID"] = "N";

        // $return_array["IS_CHECKSUM_VALID"] = $isValidChecksum ? "Y" : "N";
        // //$return_array["TXNTYPE"] = "";
        // //$return_array["REFUNDAMT"] = "";
        // unset($return_array["CHECKSUMHASH"]);

        // $encoded_json = htmlentities(json_encode($return_array));
}
?>
