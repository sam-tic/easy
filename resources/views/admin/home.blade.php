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
    Welcome <strong>{{ Auth::user()->username }} </strong> !!
@endsection
