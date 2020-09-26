@extends('admin.app')
@section('navbar')
<div class="row">
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
@if (session('del'))
<h3 class="alert alert-danger">{{ session('del')  }}</h3>    
@endif

@if (session('success'))
<h3 class="alert alert-success">{{ session('success')  }}</h3>    
@endif

    <div class=" col-md-4 my-2">
      <input id="input-search" type="text" class="form-control" placeholder="Search..">
        
        
    </div>
<table class="table table-striped" >
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody id="tableMod">
        {{-- @foreach ($mod as $item) --}}
        {{-- <tr class="item"> --}}
            {{-- <th scope="row">-</th>
            <td>{{ $item->username }}</td>
            <td>{{ $item->email }}</td>
            <td>
            <form action="{{ url('admin/mod/'.$item->id) }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td> --}}
          {{-- </tr>       --}}
        {{-- @endforeach --}}
      
    </tbody>
  </table>
</div>
<script>
    $(document).ready(function(){

            var data = {!! json_encode($mod->toArray()) !!};
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
                    if (data[i].permission==1)
                    tableHtml = '<tr><th scope="row">-</th><td>'+data[i].username+'</td><td>'+data[i].email+'</td><td><form action="mod/'+data[i].id+'" method="POST"><input type="hidden" name="_method" value="DELETE">@csrf<button type="submit" class="btn btn-danger">Delete</button></form></td></tr>';
                    else 
                    tableHtml = '<tr><th scope="row">-</th><td>'+data[i].username+'</td><td>'+data[i].email+'</td><td><form action="mod/'+data[i].id+'" method="POST">@csrf<button type="submit" class="btn btn-success">Add as Moderator</button></form></td></tr>';
                    //console.log(tableHtml);
                    table.innerHTML+=tableHtml;
                  }
                  
              }

  });
  
</script>
  
@endsection
