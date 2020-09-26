<?php
namespace App\Http\Controllers;
// putenv("BBB_SERVER_BASE_URL=https://bbb.sam-ticc.com/bigbluebutton/");
// putenv("BBB_SECRET=pBFDoR5mMexbzhNdPmptyHVEwFaFlYUHx3u3fAnWfYs");
use Illuminate\Http\Request;
use App\Room;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::user()->id;
        $rooms=Room::where('id_moderator',$id)->get();
        $langs=DB::table('lang')->get();
        return view('mod.room',compact('rooms','langs'));
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
        $rooms=Room::where('name',$request->input('name'))->count();
        if ($rooms == 0 )
        {
            $id=Auth::user()->id;
            $room=new Room;
            $room->id_moderator=$id;
            $room->name=$request->input('name');
            $room->langue=$request->input('lang');
            $room->group=$request->input('group');
            $room->pass_mod=randomPassword();
            $room->pass_att=randomPassword();
            $room->save();
            session()->flash('succes','Room was add !!');
            return redirect('/mod'); 
        }
        else
        {
            session()->flash('succes','Room existed, you can modifided it !!');
            return redirect('/mod');        
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
        $room=Room::find($id);
        $meetingID=$id;
        $meetingName=$room->name;
        $attendee_password=$room->pass_att;
        $moderator_password=$room->pass_mod;
        $user=User::find($room->id_moderator);
        $username=$user->username;
        $bbb = new BigBlueButton();
        $createMeetingParams = new CreateMeetingParameters($meetingID, $meetingName);
        $createMeetingParams->setAttendeePassword($attendee_password);
        $createMeetingParams->setModeratorPassword($moderator_password);
        $createMeetingParams->setRecord(false);
        $response = $bbb->createMeeting($createMeetingParams);
        if ($response->getReturnCode() == 'FAILED') {
            return 'Sorry '.$username.'.. cant create meeting !!'.$meetingID.$meetingName.$attendee_password.$moderator_password.$username;
        } else {
            echo "meeting created !!";
            $joinMeetingParams = new JoinMeetingParameters($meetingID, $username, $moderator_password);
            $joinMeetingParams->setRedirect(true);
            $joinMeetingParams->setJoinViaHtml5(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            header('Location: '.$url);
        exit;
                //return redirect('/JoinMeeting')->pluck($id);
            }
        //return dd($room);
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
    public function update(Request $request,$id)
    {
        $room=Room::find($id);
        $room->name=$request->input('name');
        // $room->name=$request->input('lang');
        // $room->group=$request->input('group');
        // $room->pass_mod=$request->input('pass_mod');
        // $room->pass_att=$request->input('pass_att');
        $room->save();
        session()->flash('succes','Room was updated !!');
        return redirect('/mod');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room=Room::where('id',$id);
        $room->delete();
        session()->flash('succes','Room was deleted !!');
        return redirect('/mod');   
    }
}
