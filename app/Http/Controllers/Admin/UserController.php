<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_user;
use Illuminate\Support\Facades\Hash;
use Datatables;
use DB;

class UserController extends Controller
{

    public function __construct()
    {
        $this->userStatus = ['1' => 'Active','2' => 'Inactive'];
        $this->defaultPassword = 'wallet@123';
        $this->middleware('AdminAccess'); // Allows Access to Admin
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //$users = User::query();
            $users = User::with(['roles','role_user'])->whereHas('roles', function ($q) {
                $q->where('name','!=','Customer');
            });

            if ($request->full_name) {
                $users->where('full_name', 'like', '%' . $request->full_name . '%');
            }

            $results = $users->get();
            //print_r($results);
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('full_name', function ($data) {
                    if (empty($data->full_name)) {
                        return 'N/A';
                    }
                    return $data->full_name;
                })
                ->addColumn('roleId', function ($data) {
                    if($data->roles){
                        return $data->roles[0]->name;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('user_name', function ($data) {
                    if (empty($data->user_name)) {
                        return 'N/A';
                    }
                    return $data->user_name;
                })
                ->addColumn('email', function ($data) {
                    if (empty($data->email)) {
                        return 'N/A';
                    }
                    return $data->email;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->userStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('user.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteuser" href="javascript:;" data-user="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash-o"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage User';

        return view('pages.admin_user.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->userStatus;
        $data['password'] = $this->defaultPassword;
        $data['roles']  = Role::Where('name','!=','Customer')->get();
        return view('pages.admin_user.add',$data);
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
                        'user_name' => 'required|unique:users,user_name',
                        'full_name' => 'required',
                        'password'  => 'required',
                        'roleId'    => 'required|regex:/^\d+(\.\d{1,2})?$/'
                    ]);
        if ($request->hasFile('user_image')) {
            $imageName = time().'_user.' . $request->file('user_image')->getClientOriginalExtension();
            $request->file('user_image')->move(
                base_path() . '/public/uploads/admin_users/', $imageName
                );
        }else{
            $imageName = '';
        }
        $password = Hash::make($request->password);
        /*User::insert(['full_name' => $request->full_name, 'user_name' => $request->user_name, 'password' => $password, 'roleId' => $request->roleId, 'user_image' => $imageName, 'email' => $request->email, 'created_by' => $request->user()->id, 'status' => $request->status, 'created_at' => date('Y-m-d H:i:s')]);*/
        $user_id = DB::table('users')->insertGetId(
                array(
                'full_name' => $request->full_name,
                'user_name' => $request->user_name,
                'email'     => $request->email,
                'user_image'=> $imageName,
                'password'  => $password, 
                'created_at'=> date('Y-m-d H:i:s')
                )
            );
        DB::table('role_user')->insert([
                    'user_id' => $user_id,
                    'role_id' => $request->roleId
                ]);
        /*User::insert([
                    'user_id' => $user_id,
                    'role_id' => $request->roleId
                ]);*/

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTasks($id)
    {
        //$task =  Role_user::findOrFail($id); // this is line 94
        return $task;
    }
    public function edit($id)
    {
        $article = User::with(['roles','role_user'])->first();
        //$data['userInfo'] = User::findOrFail($id);
        $userInfo = User::with(['roles','role_user'])->where('id', '=', $id)->get();
        $data['userInfo'] = $userInfo[0];
        
        $data['role_id'] = $userInfo[0]['roles'][0]['pivot']->role_id;
        $data['user_id'] = $userInfo[0]['roles'][0]['pivot']->user_id;
        $data['status'] = $this->userStatus;
        $data['roles']  = Role::Where('name','!=','Customer')->get();
        return view('pages.admin_user.edit',$data);
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
                        'user_name' => 'required|unique:users,user_name,' . $id . '',
                        'full_name' => 'required',
                        'roleId'    => 'required|regex:/^\d+(\.\d{1,2})?$/'
                    ]);
        $user = User::find($id);
        $user->user_name = $request->user_name;
        $user->full_name = $request->full_name;
        //$user->password  = Hash::make($request->password);
        $user->email = $request->email;
        if ($request->hasFile('user_image')) {
            $imageName = time().'_user.' . $request->file('user_image')->getClientOriginalExtension();
            $request->file('user_image')->move(
                base_path() . '/public/uploads/admin_users/', $imageName
            );
            $user->user_image = $imageName;
            if($request->current_user_image){
                unlink(base_path() . '/public/uploads/admin_users/'.$request->current_user_image);
            }
        }
        $user->save();
        //UPDATE ROLE
        $userRoleData['role_id'] = $request->roleId;
        Role_user::where('user_id', $id)->update($userRoleData);
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = User::find($request->id);
        $category->delete();
        return redirect()->route('user.index');
    }
}
