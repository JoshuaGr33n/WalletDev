<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class CommonController extends BaseAPIController
{
    public function getUserNotification(Request $request)
    {
    	$notificationList = array();
    	
        $user_id  = Auth::id();
        $notifications = Notification::whereRaw("find_in_set($user_id,notify_to)")->orWhere('notify_to','0')->orderBy('id', 'desc')->get();
        
        if($notifications){
        	foreach ($notifications as $key => $value) {
        		$notification_icon = (!empty($value->notification_icon)) ? URL('uploads/notification/' . $value->notification_icon) : '';
        		$notificationList[] = array(
                                            "id" => intval($value->id),
                							"title" => "$value->title",
        									"short_desc" => "$value->short_desc",
        									"description" => "$value->description",
        									"notification_icon" => "$notification_icon"
        						        );
        	}
        }
    	return response()->json(['status' => 'success', 'message' => 'User Notification list Retrieved', 'data' => $notificationList], $this->successStatus);
    }
}
