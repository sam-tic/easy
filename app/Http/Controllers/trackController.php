<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class trackController extends Controller
{
    public function __construct()
    {
        
    }
    public function index()
    {
        return view('tracking.home');
    }
    public function tracking(Request $request)
    {

        // Validation from

        $this->is_valid_number($request);

        //Define type of carrier

        $Num=$request->input('TrackNumber');
        $type = get_carrier_type($Num);
        
        //tracking script 
            //dd($type);
            switch ($type) {
                case 'UPS':
                    $detail=Ups_tracking($Num);
                    break;
                case 'USPS'://9449008205496612091746//9400111298370718571488
                    $detail=Usps_tracking($Num);
                    break;
                case 'FEDEX':
                    $detail=Fedex_tracking($Num);
                    break;
                case 'EMS':
                    $detail=Ems_tracking($Num);
                    break;
                default:
                
                return redirect()->back()->with('err2','No Carrier Available !!');
                }
                $detail['carrier']=$type;
                // dd($detail);
                //dd($detail['detailShipment']);
                return view('tracking.result',compact('detail'));
    }

    function is_valid_number(Request $request)

    {
        $this->validate($request,['TrackNumber'=>'required|min:8']);
    }

    function carrier(){
        return view('tracking.carriers');
    }

}

