@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="grid">
                <form method="POST" action="{{ route('register') }}" class="form login">
                 <header class="login__header">
                   <h3 class="login__title">Register</h3>
                 </header>
                 <div class="login__body">
                       @csrf
                       <div class="form__field">
                        <input id="name" type="text" placeholder="Username"  @error('name') is-invalid @enderror name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                       </div>
                   <div class="form__field">
                    <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" >
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                   </div>
                   <div class="form__field">
                   <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                   @error('password')
                   <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
                   @enderror
                  </div>
                  <div class="form__field" >
                    <input id="password-confirm" type="password" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password">
                   </div>
                 </div>
                 <footer class="login__footer" style="justify-content:center !important">
                   <input type="submit" value="Regiter">
                 </footer>
               </form> 
           </div>
        </div>
    </div>
</div>
@endsection
