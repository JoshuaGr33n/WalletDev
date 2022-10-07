<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Datatables;

class AnnouncementController extends Controller
{

    public function __construct()
    {
        $this->announcementStatus = ['1' => 'Active','2' => 'Inactive'];
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
            $announcements = Announcement::query();

            if ($request->title) {
                $announcements->where('title', 'like', '%' . $request->title . '%');
            }
            
            $results = $announcements->get();
            return Datatables::of($results)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    if (empty($data->title)) {
                        return 'N/A';
                    }
                    return $data->title;
                })
                ->addColumn('description', function ($data) {
                    if (empty($data->description)) {
                        return 'N/A';
                    }
                    return (strlen($data->description) > 72) ? substr($data->description,0,70).'.' : $data->description;
                })
                ->addColumn('status', function ($data) {
                    if (empty($data->status)) {
                        return 'N/A';
                    }
                    return $this->announcementStatus[$data->status];
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a class="btn btn-info btn-xs" href="' . route('announcement.edit', ['id' => $row->id]) . '" data-toggle="tooltip" data-placement="top" title="Edit Announcement"><i class="fa fa-edit"></i> Edit</a>&nbsp;';
                    $btn .= '<a class="btn btn-danger btn-xs deleteAnnouncement" href="javascript:;" data-announcement="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Delete Announcement"><i class="fa fa-trash-o"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = 'Manage Announcement';

        return view('pages.announcement.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = $this->announcementStatus;
        return view('pages.announcement.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        if ($request->hasFile('announcement_image')) {
            $imageName = time().'_announcement.' . $request->file('announcement_image')->getClientOriginalExtension();
            $request->file('announcement_image')->move(
                base_path() . '/public/uploads/announcements/', $imageName
                );
        }else{
            $imageName = '';
        }
        Announcement::insert(['title' => $request->title, 'description' => $request->description, 'announcement_image' => $imageName, 'created_by' => $request->user()->id, 'status' => $request->status]);

        return redirect()->route('announcement.index');
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
    public function edit($id)
    {
        $data['announcementInfo'] = Announcement::findOrFail($id);   //
        $data['status'] = $this->announcementStatus;
        return view('pages.announcement.edit',$data);
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
        $request->validate([ 'title' => 'required' ]);
        $menu = Announcement::find($id);
        $menu->title = $request->title;
        $menu->description = $request->description;
        if ($request->hasFile('announcement_image')) {
            $imageName = time().'_announcement.' . $request->file('announcement_image')->getClientOriginalExtension();
            $request->file('announcement_image')->move(
                base_path() . '/public/uploads/announcements/', $imageName
            );
            $menu->announcement_image = $imageName;
            if($request->current_announcement_image){
                unlink(base_path() . '/public/uploads/announcements/'.$request->current_announcement_image);
            }
        }
        $menu->status = $request->status;
        $menu->save();
        return redirect()->route('announcement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $announcement = Announcement::find($request->id);
        $announcement->delete();
        return redirect()->route('announcement.index');
    }
}
