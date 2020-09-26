@extends('admin.app')
@section('navbar')
<style>
  .formAdd{
    visibility: hidden;
    opacity: 0;
  }
</style>
<div class="col-md-10 mx-auto">
    <nav>
        <ul>
            <li><a href="{{ route('admin.mod.show') }}">Moderators</a></li>
            <li><a href="{{ route('admin.att.show') }}">Attendee</a></li>
            <li><a href="#">setting</a></li>
            <li><a href="#">logout</a></li>
        </ul>
    </nav>
</div>
@endsection
@section('content')
<div class="col-md-10 mx-auto">
{{-- @if (session('del'))
<h3 class="alert alert-danger">{{ session('del')  }}</h3>    
@endif

@if (session('success'))
<h3 class="alert alert-success">{{ session('success')  }}</h3>    
@endif --}}
<?php 
// $user=App\User::find(2);
// $rom=App\Room::find(19);
?>
 {{-- @foreach ( $user as $usr) --}}

{{-- <h6>{{ $user->rooms[1]->name }}</h6>     --}}
{{-- @endforeach --}}
    <div class=" col-md-6 my-2 mx-auto">
      <input id="input-search" type="text" class="form-control" placeholder="Search..">
    </div>
    <div style="overflow: auto;height:600px">
    <table class="table table-striped" >
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Rooms affected</th>
            <th scope="col">Operation</th>
          </tr>
        </thead>
        <tbody id="tableMod">
        </tbody>
    </table>
    </div>
</div>
    <div class="col-md-6 mx-auto formAdd">
      {{-- 
        Add form
        --}}
      <div class="card classAdd">
        <div class="card-header"><h5>Add to room</h5></div>
        <div class="card-body">
          <form id="formAdd" action="{{ route('admin.att.room.add') }}" method="post">
          @csrf
          <input type="hidden" name="id" value="">
          <div class="form-group form-group-lg">
          <select class="form-control" name="room" id="addUserRoom">
            {{-- options with js --}}
          </select>
        </div>
          <div class="form-group">
            <button class="btn btn-success">Add</button>
          </div>
          </form>
        </div>
      </div>
      {{-- 
        Remove form
        --}}
      <div class="card classRemove">
        <div class="card-header"><h5>Remove from room</h5></div>
        <div class="card-body">
          <form id="formRemove" action="{{ route('admin.att.room.remove') }}" method="post">
          @method('DELETE')
          @csrf
          <input type="hidden" name="id" value="">
          <div class="form-group form-group-lg">
          <select class="form-control" name="room" id="removeUserRoom">
            {{-- options with js --}}
          </select>
        </div>
          <div class="form-group">
            <button class="btn btn-danger">Remove</button>
          </div>
          </form>
        </div>
      </div>
    </div>
@if ($att ?? '')
    <script>
    $(document).ready(function(){
      
        // if (exist{!! $att ?? '' ?? '' !!})
        // {
            var data = {!! json_encode($att ?? '' ->toArray() ?? '') !!};
            var rooms = {!! json_encode($room ?? '' ->toArray() ?? '') !!};
            buildingTable(data);
            //Capture inputSearch
            
            $('#input-search').on('keyup',function()
            {
              returnSearchData($(this).val().toLowerCase(),data);
            });

             // Function Filter
            
             function returnSearchData(inputSearch,data)
             {
              newData = [];
               for ( var i = 0 ; i < data.length ; i++ ) 
               {
                 if (data[i].username.includes(inputSearch))
                 {
                   newData.push(data[i]);
                 }

               }
               buildingTable(newData);
             }
            
             // function build table of Moderators
            
              function buildingTable(data)
              {
                var table=document.querySelector('#tableMod');
                  table.innerHTML='';
                  tableHtml='';
                  for (var i = 0 ; i < data.length ; i++ )
                  {
                    let nbrRooms = data[i].rooms.length,
                    nameRooms='';
                    if ( nbrRooms > 0)
                    {
                      for (j=0;j<nbrRooms;j++)
                      nameRooms+=' ,' + data[i].rooms[j].name;
                      mesRooms="You are presented in " + nbrRooms + ' Rooms !';
                    }
                    else
                    nameRooms="Empty !";
                    
                    tableHtml = '<tr><th scope="row">-</th><td>'+data[i].username+'</td><td>'+data[i].email+'</td><td><p>' + nameRooms  + '</p></td><td><form><button type="button" class="add btn btn-success">Add new room</button><button type="button" class="remove btn btn-danger">Remove new room</button><input type="hidden" name="id_user" value="'+data[i].id+'"</form></td></tr>';
                    //console.log(tableHtml);
                    table.innerHTML+=tableHtml;
                  }
                  
              }
              // 
              // add room to user
              // 
                $('.add').on('click',function()
                {
                  var n=$(this).parent('form').find('input[name=id_user]').val();
                  $('#formAdd').find('input[name=id]').val(n);
                  $('.formAdd').css({'visibility':'visible','opacity':'1','display':'block'});
                  $('.classAdd').css({'visibility':'visible','opacity':'1','display':'block'});
                  $('.classRemove').css({'visibility':'hidden','opacity':'0','display':'none'});
                  let select=document.querySelector('#addUserRoom'),
                  options = '',
                  allRooms = [...rooms],
                  roomsUser;//make copy of rooms
                  select.innerHTML = '';  
                  for (d in data)
                  {
                    if (data[d].id==n)
                    {
                    roomsUser = data[d].rooms;
                    console.log(roomsUser);
                    break;
                    }
                  }
                  let nbrRooms=roomsUser.length;
                  //
                  //verfie if user have rooms
                  //
                   if ( nbrRooms > 0 )
                   { 
                    roomsUser.forEach(element => {
                            for ( i = 0 ; i < allRooms.length ; i++ )
                            {
                                if (element.id===allRooms[i].id)
                                {
                                  //delete allRooms[i];
                                  allRooms.splice(i, 1);
                                  break;
                                }
                            }                          
                      });
                   }
                   if (allRooms.length>0)
                   {

                    allRooms.forEach(element => {
                      options+='<option value="'+element.id +'">'+ element.name +'</option>';
                    });
                  }
                  else
                  {
                    options+='<option value="">no rooms to show ..</option>';

                  }
                   select.innerHTML+=options;
                });
                // 
                // Remove user from a room
                // 
                $('.remove').on('click',function()
                {
                  var n=$(this).parent('form').find('input[name=id_user]').val();
                  $('#formRemove').find('input[name=id]').val(n);
                  $('.formAdd').css({'visibility':'visible','opacity':'1','display':'block'});
                  $('.classRemove').css({'visibility':'visible','opacity':'1','display':'block'});
                  $('.classAdd').css({'visibility':'hidden','opacity':'0','display':'none'});
                  
                  let roomsUser, 
                  select=document.querySelector('#removeUserRoom'),
                  options = '';
                  
                  select.innerHTML = '';  
                  for (d in data)
                  {
                    if (data[d].id==n)
                    {
                    roomsUser = data[d].rooms;
                    console.log(roomsUser);
                    break;
                    }
                  }
                  nbrRooms=roomsUser.length;
                  //
                  //verfie if user have rooms
                  //
                   if ( nbrRooms > 0 )
                    { 
                       roomsUser.forEach(element => {
                       options+='<option value="'+element.id +'">'+ element.name +'</option>';
                    });
                    }
                    else
                    {
                       options+='<option value="">no rooms to show ..</option>';

                    }
                    select.innerHTML+=options;

                });
        // }
  });
  
</script>
@endif

@endsection
