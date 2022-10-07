<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Datatables;
use Exception;
use File;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    private $profileStatus;

    public function __construct()
    {
        $this->profileStatus = ['0' => 'Inactive', '1' => 'Active'];
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }

    public function getProfile(Request $request)
    {

        $user = Auth::user();
        if ($request->action == 'updateprofile'):
            $request->validate(['first_name' => 'required|regex:/^[\pL\s\-]+$/u', 'email' => 'required', 'mobile_no' => 'required|unique:users,mobile_no,' . Auth::id() . ''], ['first_name.required' => 'Please Enter Full Name.']);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            // $user->email = $request->email;
             $user->mobile_no = $request->mobile_no;
            $user->save();
            return redirect()->route('adminprofile')
                ->with('success', trans('WebMessages.profile_updated'));
        endif;
        $data['user'] = $user;
        $data['title'] = 'Profile';
        return view('Admin.profile', $data);
    }

    public function listCustomers(Request $request)
    {

        if ($request->ajax()) {
            $users = User::with('address', 'location')->whereHas('roles', function ($q) {
                $q->where('name', 'Customer');
            });

            if ($request->first_name) {
                $users->where('first_name', 'like', '%' . $request->first_name . '%');
                $users->orwhere('email', 'like', '%' . $request->first_name . '%');
                $users->orwhere('mobile_no', 'like', '%' . $request->first_name . '%');
            }

            $results = $users->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('first_name', function ($data) {
                    if (empty($data->first_name)) {
                        return 'N/A';
                    }

                    return $data->first_name;
                })
                ->addColumn('location', function ($data) {
                    if (empty($data->address->location->location_name)) {
                        return 'N/A';
                    }

                    return $data->address->location->location_name;
                })
                ->addColumn('status', function ($data) {

                    if ($data->status) {
                        $btn = '<span class="status available"></span><span>Active</span>';
                    } else {
                        $btn = '<span class="status not-available"></span><span>Inactive</span>';
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<span class="edit-del-icon"><a href="' . route('editprofile', ['id' => $row->id]) . '"><img src="' . url('/images/menu/edit-user.svg') . '" data-toggle="tooltip" data-placement="top" title="Edit Profile"/></a>';
                    $btn .= '<a href="javascript:;" data-customerid="'.$row->id.'"><img src="' . url('/images/menu/delete.svg') . '" class="deletecustomer" data-customerid="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Customer"/></a></span>';

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $profileStatus = $this->profileStatus;
        $data['profileStatus'] = $profileStatus;
        $data['title'] = 'Manage Customers';

        return view('Admin.customers.list', $data);
    }    

}
