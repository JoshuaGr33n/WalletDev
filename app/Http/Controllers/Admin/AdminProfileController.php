<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuisines;
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

    public function getAjaxCustomersInfo(Request $request)
    {
        $limit = $request->get('draw');
        $offset = $request->get('start');
        $length = $request->get('length');
        $users = User::with('address', 'location')->whereHas('roles', function ($q) {
            $q->where('name', 'Customer');
        })->offset($offset * $limit)->limit($limit)->get();
        $data = array(
            'draw' => $limit,
            'recordsTotal' => $users->count(),
            'recordsFiltered' => $users->count(),
            'data' => $users,
        );

        echo json_encode($data);
    }

    public function listCooks(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('kitchen', 'location:location_name')->whereHas('roles', function ($q) {
                $q->where('name', 'SME');
            });
            if ($request->kitchen_name) {
                $users->whereHas('kitchen', function ($q) use ($request) {
                    $q->where('kitchen_name', 'like', '%' . $request->kitchen_name . '%');
                });
                
                $users->orwhere('email', 'like', '%' . $request->kitchen_name . '%');
                $users->orwhere('mobile_no', 'like', '%' . $request->kitchen_name . '%');
            }

            $results = $users->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('kitchen_name', function ($data) {
                    $newKitchen = (isset($data->kitchen->is_kitchen_registered) && $data->kitchen->is_kitchen_registered == 0) ? ' <span style="font-size:10px;color:green;font-weight:bold;">(NEW)</span>' : '';
                    if (empty($data->kitchen->kitchen_name)) {
                        return 'N/A'.$newKitchen;
                    }
                    return $data->kitchen->kitchen_name.$newKitchen;
                })
                ->addColumn('location', function ($data) {
                    if (empty($data->kitchen->location->location_name)) {
                        return 'N/A';
                    }

                    return $data->kitchen->location->location_name;
                })
                ->addColumn('kitchen_status', function ($data) {

                    if (isset($data->kitchen->status) && $data->kitchen->status == 1) {
                        $btn = '<span class="status available"></span><span>Active</span>';
                    } else {
                        $btn = '<span class="status not-available"></span><span>Inactive</span>';
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<span class="edit-del-icon"><a href="' . route('editprofile', ['id' => $row->id]) . '"><img src="' . url('/images/menu/edit-user.svg') . '" data-toggle="tooltip" data-placement="top" title="Edit Profile"/></a>';
                    $btn .= '<a href="' . route('kitchenprofile', ['id' => $row->id]) . '"><img src="' . url('/images/menu/edit.svg') . '" data-toggle="tooltip" data-placement="top" title="Edit Kitchen"/></a>';
                    $btn = $btn . ' <a href="javascript:;" data-cookid="'.$row->id.'"><img src="' . url('/images/menu/delete.svg') . '" class="deletecook" data-cookid="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Cooks"/></a></span>';

                    return $btn;
                })
                ->rawColumns(['action', 'kitchen_status', 'kitchen_name'])
                ->make(true);
        }

        $profileStatus = $this->profileStatus;
        $data['profileStatus'] = $profileStatus;
        $data['title'] = 'Manage Cooks';
        return view('Admin.cooks.list', $data);
    }

    public function editProfile(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($request->action == 'update'):
            $request->validate(['first_name' => 'required|regex:/^[\pL\s\-]+$/u', 'email' => 'required|email|unique:users,email,' . $request->id, 'mobile_no' => 'required|numeric|digits_between:8,11|unique:users,mobile_no,' . $request->id], ['first_name.required' => 'Please Enter Full Name.', 'mobile_no.numeric' => 'Please Enter Valid Mobile Number.', 'mobile_no.required' => 'Please Enter Mobile Number.', 'email.required' => 'Please Enter Email Address.']);
            $user->first_name = $request->first_name;
            //   $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->status = $request->status;
            $user->save();
            $userRole = ($user->roles()->first()->name == 'SME') ? route('listcooks') : route('listusers');
            return redirect($userRole)->with('success', trans('WebMessages.profile_updated'));
        endif;
        $profileStatus = $this->profileStatus;
        $data['user'] = $user;
        $data['role'] = $user->roles()->first()->name;
        $data['profileStatus'] = $profileStatus;
        $data['title'] = 'Edit Profile';
        return view('Admin.edit', $data);
    }

    public function editCuisine(Request $request)
    {

        $cuisine = Cuisines::findOrFail($request->id);
        if (!empty($cuisine)):
            if ($request->file('cuisine_image')):
                $cuisineImage = $request->file('cuisine_image');
                $imageName = str_replace(' ', '-', $cuisine->cuisine_name) . '-' . time() . '.' . $cuisineImage->getClientOriginalExtension();
                try {
                    $cuisineImage->move(public_path('cuisines'), $imageName);
                    File::delete(public_path('cuisines/' . $cuisine->cuisine_image . '')); // Delete Old Image
                } catch (Exception $e) {
                    echo $e->getMessage();
                    die;
                }
                $cuisine->cuisine_image = $imageName; // To save the Cuisine Image Name
            endif;

            if ($request->action == 'updatecuisine'):
                $request->validate(['cuisine_name' => 'required|unique:cuisines,cuisine_name,' . $request->id, 'cuisine_image' => 'sometimes|mimes:jpeg,jpg,png,gif|max:10000'], ['cuisine_name.required' => 'Please Enter Cuisine Name', 'cuisine_name.unique' => 'Cuisine Already Exists', 'cuisine_image.sometimes' => 'Please Add Cuisine Image.']);
                $cuisine->cuisine_name = $request->cuisine_name;
                $cuisine->cuisine_description = $request->cuisine_description;
                $cuisine->status = $request->status;
                $cuisine->save();
                return redirect()->route('listcuisines')
                    ->with('success', trans('WebMessages.cuisine_updated'));
            endif;
        endif;
        $data['cuisine'] = $cuisine;
        $data['title'] = 'Edit Cuisine';
        return view('Admin.cuisines.edit', $data);
    }

    public function listCuisines(Request $request)
    {
        if ($request->ajax()) {
            $cuisines = Cuisines::query();

            if ($request->cuisine_name) {
                $cuisines->where('cuisine_name', 'like', '%' . $request->cuisine_name . '%');
            }

            $results = $cuisines->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {

                    if ($data->status) {
                        $btn = '<span class="status available"></span><span>Active</span>';
                    } else {
                        $btn = '<span class="status not-available"></span><span>Inactive</span>';
                    }
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<span class="edit-del-icon">';
                    $btn .= '<a href="' . route('editcuisine', ['id' => $row->id]) . '"/><img src="' . url('/images/menu/edit.svg') . '" data-toggle="tooltip" data-placement="top" title="Edit Cuisine"/></a>';
                    $btn .= ' <a href="javascript:;" data-id="'.$row->id.'"/><img class="deletecuisine" data-cuisineid="'.$row->id.'" src="' . url('/images/menu/delete.svg') . '" data-toggle="tooltip" data-placement="top" title="Delete Cuisine"/></a>';
                    $btn .= "</span>";

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $profileStatus = $this->profileStatus;
        $data['profileStatus'] = $profileStatus;
        $data['title'] = 'List Cuisines';
        return view('Admin.cuisines.list', $data);
    }

    public function addCuisine(Request $request)
    {
        $profileStatus = $this->profileStatus;
        $data['profileStatus'] = $profileStatus;
        $data['title'] = 'Add Cuisine';
        return view('Admin.cuisines.add', $data);
    }

    public function addCuisineData(Request $request)
    {
        $request->validate(['cuisine_name' => 'required|unique:cuisines,cuisine_name', 'cuisine_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:10000'], ['cuisine_name.required' => 'Please Enter Cuisine Name', 'cuisine_name.unique' => 'Cuisine Already Exists', 'cuisine_image.required' => 'Please Add Cuisine Image.']);

        if ($request->file('cuisine_image')):
            $cuisineImage = $request->file('cuisine_image');
            $imageName = str_replace(' ', '-', $request->cuisine_name) . '-' . time() . '.' . $cuisineImage->getClientOriginalExtension();
            try {
                $cuisineImage->move(public_path('cuisines'), $imageName);
                File::delete(public_path('cuisines/' . $cuisineImage . '')); // Delete Old Image
                $cuisineData['cuisine_image'] = $imageName; // To save the Cuisine Image Name
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
        endif;

        if ($request->action == 'addcuisine'):
            $cuisineData['cuisine_name'] = $request->cuisine_name;
            $cuisineData['cuisine_description'] = $request->cuisine_description;
            $cuisineData['status'] = $request->status;
            try {
                Cuisines::create($cuisineData);
            } catch (\Exception $e) {
                echo $e->getMessage();
                die;
            }
            return redirect()->route('listcuisines')
                ->with('success', trans('WebMessages.cuisine_added'));
        endif;

        $profileStatus = $this->profileStatus;
        $data['profileStatus'] = $profileStatus;
        $data['title'] = 'Add Cuisine';
        return view('Admin.cuisines.add', $data);
    }

    public function deleteCuisine(Request $request)
    {
        try {
            $cuisine = Cuisines::findOrFail($request->id);
            if (!empty($cuisine->cuisine_image)):
                File::delete(public_path('cuisines/' . $cuisine->cuisine_image . '')); // Delete Cuisine Image
            endif;
            $cuisine->delete();
            $request->session()->flash('success', trans('WebMessages.cuisine_deleted'));
            return response()->json(['status' => 'success']);
        } catch (Exception $e) { 
            $request->session()->flash('failed', $e->getMessage());
            return response()->json(['status' => 'failed']);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $role = $user->roles()->first()->name;
            $user->delete();
            $request->session()->flash('success', $role . ' Deleted Successfully!');
            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            $request->session()->flash('failed', $e->getMessage());
            return response()->json(['status' => 'failed']);
        }
    }

}
