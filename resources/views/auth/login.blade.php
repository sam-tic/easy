@extends('layouts.app')

@section('content')
<div class="container">
    @error('email')
    <span class="alert" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror  
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="grid">
                 <form method="POST" action="{{ route('login') }}" class="form login">
                  
                  <header class="login__header">
                    <h3 class="login__title">{{ __('Login') }}</h3>
                  </header>
                  
                  <div class="login__body">
                        @csrf
                    <div class="form__field">
                     <input id="email" type="email" class="" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" >
                    </div>

                    <div class="form__field">
                    <input id="password" type="password" placeholder="Password" class="" name="password" required autocomplete="current-password">
                   </div>
    
                  </div>

                  <footer class="login__footer" >
                    <input type="submit" value="Login">
                    <p><span class="icon icon--info">?</span><a href="#">Forgot Password</a></p>
                  </footer> 
                </form> 
            </div>
        </div>


    </div>
</div>
@endsection
