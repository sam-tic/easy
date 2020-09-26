@extends('layouts.app')
@section('content')
<?php
session_start(); 
?>
    @if (session()->has('succes'))
    <div class="alert alert-success col-md-12 aler">
                {{session()->get('succes')}}
    </div>
    @endif
    <div class="add-enr">
        <div class="enreg-manage">
            <header>
                <div>
                    <h2>Home Rooms</h2>
                </div>
                <div class="add-button"><span  id="add-data">+</span></div>
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
                                        <form method="POST" action="{{ url('mod/'.$room->id) }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <span class="del-data" ><button type="button" class="btn-form btn-standard " style="margin:0 !important;background:#d63737">Delete</button></span>
                                            <span class="edit-data" ><button type="button"  class="btn-form btn-standard " style="margin:0 !important">Edit</button></span>
                                            <input type="hidden" name="id" value="{{ $room->id }}">
                                            <input type="hidden" name="name" value="{{ $room->name }}">
                                            <span class="join-data" ><button type="button"  class="btn-form btn-standard  " style="margin:0 !important">Join now !</button></span>                                        
                                        </form>
                                        <form name="meeting" method="GET" action="{{ url('mod/'.$room->id) }}">
                                            
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </div>
                                <div id="{{ 'collapse'.$room->id }}" class="collapse" aria-labelledby="{{ 'heading'.$room->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        <p><b>Langue :</b></p>
                                        <p>{{ $room->langue }}</p>
                                        <p><b>group</b></p>
                                        <p>{{ $room->group }}</p>
                                    </div>
                                </div>
                            </div>
                        
                  
                    @endforeach
               </div>
            </section>
        </div>
       
        


        <div class="model" id="addition-panel">
                <div class="model-content">
                    <header>
                            <h4><span>Create a new Room</span></h4>
                            <button class="btn-close">X
                            </button>
                    </header>
                    <section>
                            <form method="POST" action="{{ url('mod') }}" >
                                    {{ csrf_field() }}
                                    <label class="label-form">Name Meeting :</label>
                                    <input name="name" class="input-form" value="">
                                    <div><label class="label-form">Langue :</label></div>
                                    <select name="lang" class="input-form">
                                    @foreach ( $langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option> 
                                    @endforeach
                                    </select>
                                    <div><label class="label-form">group :</label></div>
                                    <select name="group" class="input-form">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                    {{-- <div><label class="label-form">Password Moderator :</label></div>
                                    <div><input class="input-form" type="text" name="pass_mod"></div>
                                    <div><label class="label-form">Password Attendee :</label></div>
                                    <div><input class="input-form" type="text" name="pass_att"></div> --}}
                                    <button type="submit" class="btn-form btn-standard">add</button>
                                </form>
                    </section>
                </div>
        </div>
        <div class="model" id="edit-panel">
                <div class="model-content">
                    <header>
                            <h4><span>Edit Room</span></h4>
                            <button class="btn-close">X
                            </button>
                    </header>
                    <section>
                            <form method="POST" action="" >
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id"> 
                                    <div><label class="label-form">Name Meeting :</label></div>
                                    <input name="name" class="input-form" value="{{ old('name') }}">
                                    {{-- <div><label class="label-form">Langue :</label></div>
                                    <select name="lang" class="input-form">
                                    @foreach ( $langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option> 
                                    @endforeach
                                    </select>
                                    <div><label class="label-form">group :</label></div>
                                    <select name="group" class="input-form">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                    <div><label class="label-form">Password Moderator :</label></div>
                                    <div><input class="input-form" type="text" name="pass_mod" value=""></div>
                                    <div><label class="label-form">Password Attendee :</label></div>
                                    <div><input class="input-form" type="text" name="pass_att" value=""></div> --}}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn-form btn-standard">Update</button>
                                    </form>
                    </section>
                </div>
        </div>
        
                
    </div> 
     
            <script>
                $(document).ready(function(){
                    $('select[name="facult"]').on('change',function()
                    {
                        var Idfac= $(this).val();
                        if (Idfac)
                        {
                            $.ajax({
                                url:'ajaxx/'+Idfac,
                                type: "GET",
                                dataType: "json",
                                success:function(data) 
                                        {   
                                            if ($.trim(data)=='')
                                            {
                                                $('.list-items').empty();
                                                $('.list-items').append('<li>No items to display.</li>');
                                            }   
                                            else
                                            {
                                                $('.list-items').empty();
                                                $.each(data, function(key, value) 
                                                {
                                                    var link = '{{url("speciality/")}}'+'/'+key;
                                                    //alert(link);
                                                $('.list-items').append('<li><h6 id="' + key + '">' + value + '</h6><div class="operation"><form method="POST" action="'+link+'"><input type="hidden" name="_method" value="DELETE"> {{ csrf_field() }} <span class="edit-data" ><svg class="icon-enreg icon-enreg-hide" ><use xlink:href="#edit"></use></svg></span><span class="del-data" ><svg class="icon-enreg icon-enreg-hide" ><use xlink:href="#del"></use></svg></span></form></div></li><hr>');
                                                });
                                            }
                                        }
                                        }) 
                        }else{
                            $('.list-items').empty();
                            $('.list-items').append('<li>No items to display.</li>');
                            
                        }
                    });


                    $('#add-data').on('click',function(){
                        $('#addition-panel').addClass('show-model');
                    })
                    $('.btn-close').on('click',function(){
                        $('.model').removeClass('show-model');
                    })
                    $('.list-items').on('click','.edit-data',function(){
                        var roomId=$(this).next().attr('value'),
                        roomName=$(this).next().next().attr('value');
                        $('#edit-panel').find('form').attr('action','mod/' + roomId );
                        $('#edit-panel').find('input[name="name"]').attr('value',roomName);
                        $('#edit-panel').addClass('show-model');
                        
                    });
                    $('.list-items').on('click','.del-data',function(){
                    if (confirm('Are you sure !!'))
                    {
                        $(this).parent().submit();
                    }
                    
                    })
                    $('.list-items').on('click','.join-data',function(){
                        $(this).parent().next().submit();
                    })
                })
            </script>
        {{-- 
        <form method="POST" action="{{ url('addSpe') }}">
            {{ csrf_field() }}
            <label>Department :</label><select name="dep">
                <option value="">Select one</option>
                @foreach ( $facultes as $faculte)
                <option value="{{ $faculte->id }}">{{ $faculte->departement }}</option> 
                @endforeach
            </select>
            <label>Speciality :</label><input type="text" name="spe">
            <button type="submit" class="btn btn-primary">add</button>
        </form>
        --}}
@endsection 