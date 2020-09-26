@extends('admin.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
    <div class="row">
        <div class="col-md-6 mx-auto justify-content-center">
            <p class="mx-auto">{{ session('error')  }}</p></div>
    </div>
    
    @endif
    

<div class="row" style="margin:100px auto auto auto">
    <div class="col-md-3 mx-auto" style="border: 1px solid #777">
        <h3>Login controlle</h3>
        <form action="{{route('admin.login.submit') }}" method="POST">
               
                <div class="form-group">
                    <label for="email">email :</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="email"  autocomplete="email" value="{{ old('email') }}">
                </div>
             @csrf

                <div class="form-group">
                    <label for="password">Password :</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password"  autocomplete="password">
                </div>
                
                <div class="form-group">
                    <button class="btn btn-success" type="submit">{{ __('Login') }}</button>
                </div>
                
        </form>
    </div> 
    </div>
</div>

@endsection