@extends('layouts.app')
@section('content')
<?php
session_start(); 
?>
    @if (session()->has('succes'))
    <div class="alert alert-success col-md-4 aler">
                {{session()->get('succes')}}
    </div>
    @endif
    <div class="add-enr">
        <div class="enreg-manage">
            <header>
                <div>
                    <h4>My Rooms</h4>
                </div>
            </header>
            <section>                
                    <div id="accordion" class="list-items">
                    @foreach ($rooms as $room)
                            <div class="card text-black bg-pers">
                                <div class="card-header" id="{{ '#heading'.$room->id }}">
                                    <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="{{ '#collapse'.$room->id }}" aria-expanded="false" aria-controls="{{ '#collapse'.$room->id }}">
                                        {{ $room->name }}
                                    </button>
                                    </h5>
                                    <div class="operation">
                                        @guest
                                        <span class="subs-data" ><a class="btn-form btn-standard " style="margin:0 !important;background:#d63737" href="{{ URL::to('/login') }}">Login </a></span>
                                        @else
                                        @if (in_array($room->id, $myrooms)) 

                                        <form name="meeting" method="post" action="{{ url('room') }}">
                                            <input type="hidden" name="id" value="{{ $room->id }}">
                                            <span class="join-data" ><button class="btn-form btn-standard " style="margin:0 !important">Join this room</button></span>
                                            {{ csrf_field() }}
                                        </form>
                                        @else
                                        <span class="subs-data" ><a class="btn-form btn-standard " style="margin:0 !important;background:#d63737" href="{{ URL::to('/subscribe') }}">Subscibe Now! </a></span>
                                        @endif                               
                                        @endguest
                                    </div>
                                </div>
                                <div id="{{ 'collapse'.$room->id }}" class="collapse" aria-labelledby="{{ 'heading'.$room->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        {{ 'Meeting name : '.$room->name }}
                                    </div>
                                </div>
                            </div>
                        
                  
                    @endforeach
               </div>
            </section>
        </div>
       
    </div> 
@endsection 