<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Attroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;

class roomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room=Room::find($request->id);
        $meetingID=$room->id;
        $attendee_password=$room->pass_att;
        $moderator_password=$room->pass_mod;
        $username=Auth::user()->username;
        $bbb = new BigBlueButton();
        $getMeetingInfoParams = new GetMeetingInfoParameters($meetingID, $moderator_password);
        $response = $bbb->getMeetingInfo($getMeetingInfoParams);
        if ($response->getReturnCode() == 'FAILED') {
	    return view('attendee.closed');
        } else {
             $joinMeetingParams = new JoinMeetingParameters($meetingID, $username, $attendee_password);
        $joinMeetingParams->setRedirect(true);
        $joinMeetingParams->setJoinViaHtml5(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        header('Location: '.$url);
    exit;
	   // return json_encode( $response);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check()){

        
        $room=Attroom::where('id_user',Auth::user()->id,'=')->get()->pluck('id_room');
        $myrooms=DB::table('rooms')->whereIn('id', $room)
                                     ->get()->pluck('id')->toArray();
          $rooms = Room::all();
          return view('attendee.room',compact('rooms','myrooms')); 
    }
    else{
        $rooms = Room::all();
        return view('attendee.room',compact('rooms'));
    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
