<?php



namespace App\Http\Controllers\API;



use App\Http\Controllers\Controller;

use App\Models\Cart;

use App\Models\Kitchens;

use App\Models\OrderNo;

use Auth;

use DB;

use Illuminate\Http\Response;

use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;



class BaseAPIController extends Controller

{

    protected $successStatus = 200;

    protected $failedStatus = 422;

    protected $forbiddenStatus = 401;



    private static $sid = "AC0c253cd110b399607e9b74787aca4aed"; // Your Account SID from www.twilio.com/console

    private static $token = "94695e19769de037e0983686f29532fe"; // Your Auth Token from www.twilio.com/console

    protected $twiliosid;

    protected $twiliotoken;

    protected $_response;

    private $_parameters;

    public function __construct($params = array(), $response = null)

    {

        $this->twiliosid = self::$sid;

        $this->twiliotoken = self::$token;

        $this->_response = new Response();

        $this->_parameters = self::parseParams($params);

    }



    public function customPaginator($array, $request)

    {

        $page = $request->get('page', 1);

        $perPage = (empty($request->per_page)) ? 15 : $request->per_page;

        $offset = ($page * $perPage) - $perPage;



        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,

            ['path' => $request->url(), 'query' => $request->query()]);

    }



    protected static function parseParams($params)

    {

        if (is_array($params) && count($params) == 0) {

            return array();

        }



        if ($params[0] == '/') {

            $params = substr($params, 1);

        }



        $tmp = explode('/', $params);

        $parameters = array();



        foreach ($tmp as $t) {

            if (isset($paramname)) {



                if (preg_match('/^([^\[\]]+)\[([^\[\]]+)\]$/', $paramname, $m)) {

                    if ($m[2]) {

                        $parameters[$m[1]][$m[2]] = rawurldecode($t);

                    } else {

                        $parameters[$m[1]][] = rawurldecode($t);

                    }



                } else {

                    $paramname = preg_replace('/[^0-9a-zA-Z\.]/', '', $paramname);

                    $parameters[$paramname] = rawurldecode($t);

                }

                unset($paramname);

            } else {

                $paramname = preg_replace('/[^0-9a-zA-Z\.\[\]]/', '', rawurldecode($t));

            }

        }



        return $parameters;

    }



    public function _redirectWithPost($url, $post = array(), $get_open_form_only = false)

    {

        $body = array();



        foreach ($this->_getPostFlattenedArray($post) as $name => $value) {

            $body[] = '<input type="hidden" name="' . $name . '" value="' . $value . '">';

        }



        if ($get_open_form_only) {

            return

            '<body onload="document.getElementById(\'form\').submit()">'

            . '<form id="form" action="' . $url . '" method="post">'

            . implode('', $body);

        } else {

            $this->_response->redirect()->action($url);

        }

    }



    protected function _getPostFlattenedArray($arr, $prefix = '')

    {

        $ret = array();



        foreach ($arr as $name => $value) {

            $name = ($prefix == '' ? $name : $prefix . '[' . $name . ']');

            if (is_array($value)) {

                if (count($value) > 0) {

                    $ret = array_merge($ret, $this->_getPostFlattenedArray($value, $name));

                }



            } else {

                $ret[$name] = $value;

            }

        }



        return $ret;

    }



    public function kitchenDeliveryAreas($kitchenid)

    {

        $kitchen = Kitchens::findOrFail($kitchenid);

        $deliveryLocations = $kitchen->deliveryLocations()->get();



        $deliveryAreas = array();

        foreach ($deliveryLocations as $location):

            $deliveryAreas[] = $location->id;

        endforeach;



        return (in_array(self::userLocation(), $deliveryAreas)) ? true : false;

    }



    public function checkKitchen($productKitchen)

    {

        $cart = Cart::with('products')->where('user_id', Auth::id())->first();



        if ($cart):

            $cartKitchen = $cart->products->kitchen_id;

            if ($productKitchen != $cartKitchen):

                return response()->json(['status' => 'error',

                    'message' => 'Products from Multiple Kitchens Not allowed'], 422);

            endif;

        endif;



        return true;

    }



    public static function generateOrderNo($entity, $prefix, $padLength, $pkTable)

    {

        $defValue = $prefix . str_pad('004', $padLength, '0', STR_PAD_LEFT);

        $lenSV = strlen($prefix);



        //check for existence!

        $sqlChk = "SELECT order_id FROM " . $pkTable . " WHERE prefix = '" . $prefix . "' AND entity = '" . $entity . "'";

        $rowChk = DB::select($sqlChk);

        if (empty($rowChk)) {

            $next_id = $defValue;

            $sqlAuto = "INSERT INTO order_no SET entity = '" . $entity . "', prefix = '" . $prefix . "', order_id = '" . $defValue . "'";

            OrderNo::insert(['entity' => $entity, 'prefix' => $prefix, 'order_id' => $defValue]);

        } else {

            $next_id = $prefix . str_pad(((int) substr($rowChk[0]->order_id, $lenSV) + 1), $padLength, '0', STR_PAD_LEFT);

            try {

                OrderNo::where('id', '4')->update(['prefix' => $prefix, 'entity' => $entity, 'order_id' => $next_id]);

            } catch (\Exception $e) {

                echo $e->getMessage();

                exit;

            }



        }



        return $next_id;

    }



    public function sendSMS($mobileno, $messageContent)

    {



        try {

            $client = new \Twilio\Rest\Client($this->twiliosid, $this->twiliotoken);

            $message = $client->messages->create('+91' . $mobileno, // Text this number

                array(

                    'from' => '+12055129136', // From a valid Twilio number

                    'body' => $messageContent,

                ));

            return true;

        } catch (\Exception $e) {

            return response()->json(['status' => 'error',

                'message' => $e->getMessage()], 422);

        }

    }



    public static function userLocation()

    {

        $userLocation = Auth::user()->address->location_id; // To get User Location

        return $userLocation;

    }

    

    public function _redirect($url, $options=array())

	{

		header('Location: '. $url);

		exit;



	}

}

