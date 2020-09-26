@extends('layouts.app')

@section('content')
<div class="row">
<div class="trackingDiv col-md-6">
    <h5 style="color: #aaaaaa;margin-bottom:20px;padding-left:10px">Tracking Result :</h5>
            <div class="header-track">
            <h5 style="color:#195C99">{{ $detail['trackNumber'] }}</h5>
            <p>{{ $detail['Status'] }}</p>
            <p><span>{{ $detail['deliveredDate'] }}</span> - <span>{{ $detail['deliveredTime'] }}</span></p>
            <p> {{ $detail['receivedBy'] }}</p>
            </div>
            <div class="body-track">
                @isset($detail['detailShipment'])
                  @foreach ($detail['detailShipment'] as $det)
                {{-- {{ dd($det) }} --}}
                <div>
                    <p><strong><span>{{ $det['date'] }}</span> ,<span>{{ $det['time'] }}</span></strong></p>
                    <p>{{ $det['activity'] }}</p>
                    <p>{{ $det['location'] }}</p>
                    <p>{{ $det['description'] }}</p>
                    <hr>
                </div>
                @endforeach  
                @endisset
            
            </div>  
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