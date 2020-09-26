<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Dosis:300|Lato:300,400,600,700|Roboto+Condensed:300,700|Open+Sans+Condensed:300,600|Open+Sans:400,300,600,700|Maven+Pro:400,700);
        body{
            font-family: "Open Sans";
            background: #fff;
        }
        #app{
            width: 60%;
            margin: 0 auto;
            height: 100vh;
            overflow: hidden;

        }
        header{
            background: rgb(9, 159, 179);
            height: 50px;
            padding: .5rem 1rem;
        }
        header a{
            text-decoration: none;
            color: aliceblue;
            font-size: 1.5rem;
            line-height: 30px;
            font-weight: 600;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FIEUM') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.theme.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.js') }}"></script>
</head>
<body>
    <div id="app" >
        <header>
            <a href="#">Admin Console</a>  
        </header>
        @yield('navbar')
        @yield('content')
    </div>
 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" ></script>
 <script src="{{ asset('js/bootstrap.min.js') }}"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
    $(document).ready(function(){
        $('.submenu').on('click',function(){
            var submenu=$(this).parent().children('div');
            submenu=submenu.toggleClass('show-submenu');
            submenu.parent().children('a').toggleClass('active');
            console.log(submenu);

        });


    });
</script>
{{-- <script>
    var theToggle = document.getElementById('toggle');

    // based on Todd Motto functions
    // https://toddmotto.com/labs/reusable-js/

    // hasClass
    function hasClass(elem, className) {
        return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    }
    // addClass
    function addClass(elem, className) {
        if (!hasClass(elem, className)) {
            elem.className += ' ' + className;
        }
    }
    // removeClass
    function removeClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, ' ') + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(' ' + className + ' ') >= 0 ) {
                newClass = newClass.replace(' ' + className + ' ', ' ');
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }
    // toggleClass
    function toggleClass(elem, className) {
        var newClass = ' ' + elem.className.replace( /[\t\r\n]/g, " " ) + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(" " + className + " ") >= 0 ) {
                newClass = newClass.replace( " " + className + " " , " " );
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        } else {
        elem.className += ' ' + className;
        }
    }   
    var on=false;
    theToggle.onclick = function() {
    toggleClass(this, 'on');
    let vis=document.getElementById('menu');

    if (on) {
        vis.style.visibility='hidden';
        vis.style.opacity='0';
        on=false;

    }
    else{
        vis.style.visibility='visible';
        vis.style.opacity='1';
        on=true;

    }
    
   
    //document.getElementById('#menu').style.opacity=1;
    //return false;
    }
</script> --}}
</body>
</html>
{{-- svg new student  --}}
