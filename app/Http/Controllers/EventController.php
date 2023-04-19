<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        DB::table('events')
              ->where('start_date', '<', date('Y-m-d'))
              ->where('status', '!=', 'Rejected')
              ->where('status', '!=', 'Cancelled')
              ->update(['status' => 'Done']);

        DB::table('events')
              ->where('start_date', '=', date('Y-m-d'))
              ->where('status', '=', 'Waiting To Do')
              ->update(['status' => 'Doing']);

        $data = array();
        return view('event.index', $data);
    }

    public function form($id = '')
    {
        $event = Event::find($id);
        // $group = Group::select('id','name')->get();
        $group = DB::table('groups')
            ->rightJoin('user_groups', function($join) use ($id)
                {
                    $join->on('user_groups.group_id', '=', 'groups.id');
                })
            ->select('groups.id as id','groups.name as name', 'user_groups.user_id as id_user')
            ->where('user_groups.user_id', '=', Auth::user()->id)
            ->get();

        if($id == ''){
            $title = 'Create Event';
            $state = 'create';
        }else{
            $title = 'Edit Event';
            $state = 'edit';
        }
        $data = array(
            'event'=>$event,
            'groups'=>$group,
            'title'=>$title,
            'state'=>$state,
            'current_date'=>date('Y-m-d')
        );
        return view('event.form', $data);
    }

    public function store(Request $request, $id = '')
    {
        if($id == ''){
            $event = new Event;
            $event->created_by = Auth::user()->id;
        }else{
            $event = Event::find($id);
            $event->updated_by = Auth::user()->id;
        }

        $event->name = $request->name;
        $event->description = $request->description;
        $event->group_id = $request->group;

        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->category = $request->category;
        $event->price = $request->price;

        $group = Group::find($request->group);

        if($group->admin_id == Auth::user()->id){
            if($id != '' && $event->status == 'Requested'){
                if($request->status == 'Approved'){
                    if(strtotime(date('Y-m-d')) == strtotime($request->start_date)) {
                        $event->status = 'Doing';
                    }else{
                        $event->status = 'Waiting To Do';
                    }
                }else{
                    $event->status = $request->status;
                }
            }else{
                if(strtotime(date('Y-m-d')) == strtotime($request->start_date)) {
                    $event->status = 'Doing';
                }else{
                    $event->status = 'Waiting To Do';
                }
            }
            if($request->status == 'Cancelled'){
                $event->status = $request->status;
            }
        }else{
            $event->status = 'Requested';
        }

        if($request->price > 1){
            $event->is_free = 0;
        }else{
            $event->is_free = 1;
        }
        $event->save();

        echo "<script>window.opener.reloadDatatable();</script>";
        echo "<script>window.opener.run_alert('success', 'Proses Sukses');</script>";
        echo "<script>window.close();</script>";
    }

    public function gridview()
    {
        $events = DB::table('events')
            ->leftJoin('user_groups', 'user_groups.group_id', '=','events.group_id')
            ->rightJoin('groups', 'user_groups.group_id', '=', 'groups.id')
            ->select('events.name as name', 'events.id as id', 'groups.name as group_name', 'events.description', 'groups.admin_id as id_admin_group', 'events.created_by', 'events.status')
            ->where('user_groups.user_id', '=', Auth::user()->id)
            ->get();

        

        return Datatables::of($events)
            ->addColumn('event_action', function ($event) {
                $button_edit = '';
                if($event->status != 'Cancelled' && $event->status != 'Rejected' && $event->status != 'Done'){
                    if($event->id_admin_group == Auth::user()->id || $event->created_by == Auth::user()->id){
                        $button_edit = '<button data-id="'.$event->id.'" class="btn btn-sm btn-outline-warning tombol_edit" data-toggle="modal">Edit</button>';
                        if($event->id_admin_group != Auth::user()->id){
                            if($event->created_by != $event->id_admin_group && $event->status != 'Requested'){
                                $button_edit = '';
                            }  
                        }
                        
                    }    
                }
                
                return $button_edit.'  <button data-id="'.$event->id.'" data-name="'.$event->name.'" class="btn btn-sm btn-outline-secondary tombol_show">Show</button> ';
            })
            ->addColumn('group_name', function ($event) {
                return $event->group_name;
            })
            ->addIndexColumn()->rawColumns(['event_action', 'group_name'])->make();
    }

    public function show($id)
    {
        $events = DB::table('events')
            ->leftJoin('groups', 'events.group_id', '=', 'groups.id')
            ->select('events.name as name', 'events.id as id', 'groups.name as group_name', 'events.description', 'groups.admin_id as id_admin_group', 'events.category as category', 'events.start_date', 'events.end_date', 'events.price', 'events.status')
            ->where('events.id', '=', $id)
            ->get();

        $data = array(
            'event'=>$events[0],
        );
        return view('event.detail', $data);
    }
}
