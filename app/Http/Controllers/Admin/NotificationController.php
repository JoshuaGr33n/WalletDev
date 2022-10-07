<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User_device_info;
use App\Models\User;
use App\Libraries\PushNotification;
use Auth;
use Datatables;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->AreaStatus = ['1' => 'Active','2' => 'Inactive'];
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Notification::query();

            if ($request->notify_to) {
                $categories->where('notify_to', 'like', '%' . $request->notify_to . '%');
            }

            $results = $categories->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('notify_to', function ($data) {
                    if (!isset($data->notify_to)) {
                        return 'N/A';
                    }
                    if($data->notify_to == 0){
                        return 'All';
                    }else{
                        return $data->notify_to;
                    }
                })
                ->addColumn('title', function ($data) {
                    if (empty($data->title)) {
                        return 'N/A';
                    }
                    return $data->title;
                })
                ->addColumn('short_desc', function ($data) {
                    if (empty($data->short_desc)) {
                        return 'N/A';
                    }
                    return $data->short_desc;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-info btn-xs" href="' . route('notification.show', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="View Notification"><i class="fa fa-view"></i> View</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteNotification" href="javascript:;" data-notification="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Notification"><i class="fa fa-trash-o"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['title'] = 'Manage Notification';
        return view('pages.notification.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'Customer');
        });
        $results = $users->get();
        $data['userlists'] = $results;
        $data['status'] = $this->AreaStatus;
        return view('pages.notification.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        					'notify_to' => 'required',
    						'title' => 'required',
                            'short_desc' => 'required',
                            'description' => 'required'
    					]);
        if(in_array(0, $request->notify_to)){
            $strTo = 0;
        }else{
            $strTo = implode(",",$request->notify_to);
        }
        if ($request->hasFile('notification_icon')) {
            $imageName = time().'_voucher.' . $request->file('notification_icon')->getClientOriginalExtension();
            $request->file('notification_icon')->move(
                base_path() . '/public/uploads/notification/', $imageName
                );
        }else{
            $imageName = '';
        }
        Notification::insert([
                            'notify_to' => $strTo,
                            'title' => trim($request->title),
                            'short_desc' => trim($request->short_desc),
                            'description' => $request->description,
                            'notification_icon' => $imageName,
                            'created_by' => Auth::id(),
                            'created_at' => date("Y-m-d H:i:s")
                        ]);

        //PUSH NOTIFICATION
        if(in_array(0, $request->notify_to)){
            $deviceTokenList = User_device_info::whereRaw('LENGTH(device_token) > 10')->get();
        }else{
            $deviceTokenList = User_device_info::whereIn('user_id', $request->notify_to)->whereRaw('LENGTH(device_token) > 10')->get();
        }
        //PUSH NOTIFICATION GUIDER
        if($deviceTokenList){
            $push_data  = array(
                                'title'         => trim($request->title),
                                'body'          => trim($request->short_desc),
                                'action'        => 'send_notification',
                                'notificationId'=> 1,
                                'sound'         => 'notification',
                                'icon'          => 'icon'
                              );
            $device_tokenA = array();
            $device_tokenI = array();
            foreach ($deviceTokenList as $tokenList) {
                $device_token   = trim($tokenList->device_token);
                $device_type    = trim($tokenList->device_type);
                if ($device_type == 1) {
                    $device_tokenI[] = $device_token;
                }else if ($device_type == 2) {
                    $device_tokenA[] = $device_token;
                }
            }
            if (!empty($device_tokenA)) {
                PushNotification::sendPushNotification_android($device_tokenA, $push_data);
            }
            if (!empty($device_tokenI)) {
                PushNotification::sendPushNotification_ios($device_tokenI, $push_data);
            }
        }
        //END PUSH NOTIFICATION
        
        return redirect()->route('notification.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $url = "https://www.googleapis.com/identitytoolkit/v3/relyingparty/verifyPhoneNumber?key=AIzaSyA0fyMF9wwcGLT7AjPNOYhzuQDSUkuon5A";
        
        $data = array(
                'sessionInfo' => '6-seBr9nJHXxPoA-NjqGfDyoIKMGmiJec7wUfT7vSZ0DOGSy',
                'code' => '123456'
                );
 
        $payload = json_encode($data);
     
        // Prepare new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
         
        // Set HTTP Header for POST request 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($ch);
        print_r($result);
        // Close cURL session handle
        curl_close($ch);


        $data['notificationInfo'] = Notification::findOrFail($id);
        return view('pages.notification.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'Customer');
        });
        $results = $users->get();
        $data['userlists'] = $results;
        $data['status'] = $this->AreaStatus;
        $data['notificationInfo'] = Notification::findOrFail($id);//
        return view('pages.notification.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
                            'notify_to' => 'required',
                            'message' => 'required'
                        ]);
        if(in_array(0, $request->notify_to)){
            $strTo = 0;
        }else{
            $strTo = implode(",",$request->notify_to);
        }
        $notification = Notification::find($id);
        $notification->notify_to = $strTo;
        $notification->message = $request->message;
        $notification->status = $request->status;
        $notification->save();
        return redirect()->route('notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $notification = Notification::find($request->id);
        $notification->delete();
        return redirect()->route('notification.index');
    }
}
