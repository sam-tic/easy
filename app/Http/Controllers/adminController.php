<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Room;
use App\User;
use App\Attroom;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{ 

/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 
    public function index()
    {
        return view('admin.home');
    }
   
    public function showMod()
    {
        $mods=User::all();
        return view('admin.manage.mod')->with('mod',$mods);
    }
    public function destMod($id)
    {
        $mod=user::find($id);
        $mod->permission=0;
        $mod->save();
        return redirect()->back()->with('del','moderator deleted !!');

    }
     public function addMod($id)
    {
        $mod=user::find($id);
        $mod->permission=1;
        $mod->save();
        return redirect()->back()->with('success','moderator was Add !!');
    }
    // *------------------
    // Attendee functions
    // *------------------
    public function showatt()
    {
        $att=user::with('rooms')
                   ->where('permission',0)
                   ->get();
        $rooms=Room::all();
        if ($att->count() > 0)
        return view('admin.manage.att')->with('att',$att)
                                       ->with('room',$rooms);
        else 
        return view('admin.manage.att')->with('room',$rooms);
       
            // for ($i=1;$i<15;$i++)
            // {
            //             $room=new User;
            //             $room->username='user'.$i;
            //             $room->email='user'.$i.'@gmail.com';
            //             $room->password=Hash::make('password');
            //             $room->save();
            // }
            // dd(user::all());
    }

    public function addUserRoom(Request $request){
      $user = User::find($request->id);
      $user->rooms()->attach($request->room);
     return redirect()->back();
    }
    
    public function removeUserRoom(Request $request){
        $user = User::find($request->id);
        $user->rooms()->detach($request->room);
       return redirect()->back();
      }
}
