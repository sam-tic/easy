@extends('layouts.app')

@section('content')
<div class="row">
<div class="trackingDiv col-md-6">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <h4><span style="color: brown">Easy</span><span style="color: #2a74a5">Track</span></h4>
    <hr>
    <p>Type your tracking number :</p>
    <form class=" form" action="{{ route('trackNumber') }}" method="post">
        @csrf
        <div class="form-group row">
        <input class="form-con col-md-10" type="text" name="TrackNumber">
        <input class="btn btn-outline-primary col-md-2 tr" type="submit" value="Track">
        <input type="hidden" value="0" name="auto">
    </div>
    </form>
    {{-- //---------- --}}
    {{-- @if (session('err'))
    <h5>{{ session('err') }}</h5> 
    <h5>{{ session('err1') }}</h5>  
    @endif--}}
    @if (session('err2'))
    <h5>{{ session('err2') }}</h5>   
    @endif 
    @if(session('errs'))
        @if (session('errs')['errorCode'] != null)
            @foreach (session()->get('errs') as $err)
                <h5>{{ $err }}</h5>       
            @endforeach     
        @else
            {{-- <div id="result_track">
                <dd class="post_message active">
                    <img style="width: 20px;float: left;margin: 0px 5px 5px -11px;display: inline-block;" src="//s.trackingmore.com/images/delivered1.png">
                    <time class="time"><strong>2020-06-19</strong><div class="clock">17:03:00</div></time>
                    <div class="message"><span lang="0">Delivered,LOS ANGELES,CA,90043,US</span></div>
                    <div style="clear:both;"></div>
                </dd>

            </div> --}}

            <div>
            <div><h5 style="color: rgb(68, 155, 34)">{{ session('errs')['Status'] }}</h5></div>
            <div><span style="color: brown">{{ session('errs')['deliveredDate'] }}</span></div>
            <div><h6 style="color: brown">{{ session('errs')['deliveredTime'] }}</h6></div>
            <div><h6 style="color: brown">{{ session('errs')['receivedBy'] }}</h6></div>
            </div>
            <div>
                @isset(session('errs')['detailShipment'])
                  @foreach (session('errs')['detailShipment'] as $det)
                {{-- {{ dd($det) }} --}}
                <div>
                    <h5>{{ $det['date'] }}</h5>
                    <h5>{{ $det['time'] }}</h5>
                    <h5>{{ $det['activityScan'].', '.$det['location'] }}</h5>
                    <hr>
                </div>
                @endforeach  
                @endisset
            
            </div>
            
        @endif
    @endif
    
    
    {{--  --}}
</div>
</div>
<div class="row carrier">
    <div class="col col-md-10 m-auto">
        <ul>
            <li class="col-xs-12 col-sm-12 col-md-2"><a href="#"><span><img src="img/ups.jpg" alt=""></span></a></li>
            <li class="col-xs-12 col-sm-12 col-md-2"><a href="#"><span><img src="img/usps.jpg" alt=""></span></a></li>
            <li class="col-xs-12 col-sm-12 col-md-2"><a href="#"><span><img src="img/fedex.jpg" alt=""></span></a></li>
            <li class="col-xs-12 col-sm-12 col-md-2"><a href="#"><span><img src="img/ems.png" alt=""></span></a></li>
        </ul>
    </div>
</div>
    
@endsection