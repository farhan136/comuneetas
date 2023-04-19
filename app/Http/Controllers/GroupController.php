<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\GroupInvitation;

class GroupController extends Controller
{
    public function index()
    {
        $data = array();
        return view('group.index', $data);
    }

    public function gridview()
    {
        $groups = Group::get();

        return Datatables::of($groups)
            ->addColumn('group_action', function ($group) {
                if($group->admin_id == Auth::user()->id){
                    $button_edit = '<button data-id="'.$group->id.'" class="btn btn-sm btn-outline-warning tombol_edit" data-toggle="modal">Edit</button>  <button data-id="'.$group->id.'" class="btn btn-sm btn-outline-success tombol_invite" data-toggle="modal">Invite People</button>';
                }else{
                    $button_edit = '';
                }
                return $button_edit.'  <button data-id="'.$group->id.'" data-name="'.$group->name.'" class="btn btn-sm btn-outline-secondary tombol_show"  data-toggle="modal" data-target="#memberModal">Show</button>';
            })->addIndexColumn()->rawColumns(['group_action'])->make();
    }

    public function gridview_listmember(Request $request)
    {
        $members = DB::table('user_groups')
            ->leftJoin('groups', 'groups.id', '=', 'user_groups.group_id')
            ->leftJoin('users', 'users.id', '=', 'user_groups.user_id')
            ->leftJoin('users as users2','users2.id', '=', 'groups.admin_id')
            ->select('users.name as name')
            ->selectRaw('if(users.id = users2.id, "Admin", "Member") as status')
            ->where('user_groups.group_id','=',$request->id)
            ->get();

        return Datatables::of($members)
            ->addColumn('status', function ($member) {
                if($member->status == 'Admin'){
                    return '<button class="btn btn-sm btn-success">Admin</button>';
                }else{
                    return '<button class="btn btn-sm btn-secondary">Member</button>';
                }
            })->addIndexColumn()->rawColumns(['status'])->make();

        
    }

    public function form($id = '')
    {
        $group = Group::find($id);
        $data = array(
            'group'=>$group,
            'current_date'=>date('Y-m-d')
        );
        return view('group.form', $data);
    }

    public function invite_people($id = '')
    {
        $members = DB::table('users')
            ->leftJoin('user_groups', function($join) use ($id)
                {
                    $join->on('user_groups.user_id', '=', 'users.id');
                    $join->on('user_groups.group_id','=',DB::raw($id));
                })
            ->select('users.id as id_user', 'user_groups.user_id', 'users.name as username')
            ->where('user_groups.user_id','=',null)
            ->get();

        $data = array(
            'members'=>$members,
            'group_id'=>$id
        );
        return view('group.invite', $data);
    }

    public function store(Request $request, $id = '')
    {
        if($id == ''){
            Group::create([
                'name'=> $request->name,
                'description'=> $request->description,
                'admin_id'=>Auth::user()->id
            ]);
        }else{
            $group = Group::find($id);
            $group->name = $request->name;
            $group->description = $request->description;
            $group->save();
        }
        echo "<script>window.opener.reloadDatatable();</script>";
        echo "<script>window.opener.run_alert('success', 'Proses Sukses');</script>";
        echo "<script>window.close();</script>";
    }

    public function send_email(Request $request)
    {
        $user = User::find($request->id);
        $group = Group::find($request->group_id);
        $data = collect([
            (object) [
                'sender'=>Auth::user()->name,
                'group_name'=>$group->name,
                'group_id'=>$group->id,
                'user_name'=>$user->name
            ]
        ]);
        Mail::to($user->email)->send(new GroupInvitation($data[0]));
    }
}
