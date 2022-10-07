<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Redeem_voucher;
use App\Models\User_reward;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class TransactionController extends BaseAPIController
{
    public function setTransactionPin(Request $request)
    {
        //GET ENCRYPTED PIN NUMBER
        $encryptedPin = $request->header('encrypted-pin');
        if(!$encryptedPin){
            return response()->json(['status' => 'failed',
                    'error' => array('message' => 'Set transaction Pin failed.'),
                ], $this->successStatus);
        }else{
            //DECRYPT PIN NUMBER
            $fp = fopen(base_path().'/public/key/walletprivkey.pem',"r");
            $priv_key = fread($fp,8192);
            fclose($fp);
            $private_key = openssl_get_privatekey($priv_key);
            openssl_private_decrypt(base64_decode($encryptedPin), $decrypted, $private_key);
            //echo $decrypted;
            if($decrypted){
                if(!is_numeric($decrypted)){
                    return response()->json(['status' => 'failed',
                            'error' => array('message' => 'Set transaction Pin failed.'),
                        ], $this->successStatus);
                }
                if(strlen($decrypted) < 6){
                    return response()->json(['status' => 'failed',
                            'error' => array('message' => 'Set transaction Pin failed.'),
                        ], $this->successStatus);
                }
                //UPDATE TRANSACTION PIN
                User::Where('id', Auth::id())->update(array('transaction_pin' => $encryptedPin, 'updated_at' => date('Y-m-d H:i:s')));
    	        return response()->json(['status' => 'success', 'message' => 'Set transaction pin successfully', 'data' => array()], $this->successStatus);
            }else{
                return response()->json(['status' => 'failed',
                        'error' => array('message' => 'Set transaction Pin failed.'),
                    ], $this->successStatus);
            }
        }
    }
    public function checkTransactionPin(Request $request)
    {
		return response()->json(['status' => 'success', 'message' => 'Transaction pin verified successfully', 'data' => array()], $this->successStatus);
        //GET ENCRYPTED PIN NUMBER
        $encryptedPin = $request->header('encrypted-pin');
        if(!$encryptedPin){
            return response()->json(['status' => 'failed',
                    'error' => array('message' => 'verify transaction Pin failed.'),
                ], $this->successStatus);
        }else{
            $userInfo = User::where('id',Auth::id())->first();
            if(!$userInfo){
                return response()->json(['status' => 'failed',
                                'error' => array('message' => 'Invalid user'),
                            ], $this->successStatus);
            }
            //DECRYPT STORED PIN NUMBER
            $encyptPin = $userInfo->transaction_pin;
            $fp = fopen(base_path().'/public/key/walletprivkey.pem',"r");
            $priv_key = fread($fp,8192);
            fclose($fp);
            $private_key = openssl_get_privatekey($priv_key);
            openssl_private_decrypt(base64_decode($encyptPin), $decrypted, $private_key);

            //DECRYPT HEADER PIN NUMBER
            openssl_private_decrypt(base64_decode($encryptedPin), $current_decrypted, $private_key);
            //CHECK PIN NUMBER
            if($decrypted == $current_decrypted){
                return response()->json(['status' => 'success', 'message' => 'Transaction pin verified successfully', 'data' => array()], $this->successStatus);
            }else{
                return response()->json(['status' => 'failed',
                            'error' => array('message' => 'verify transaction Pin failed.'),
                        ], $this->successStatus);
            }
        }
    }

    

}
