@extends('layouts.pos')

@section('title', 'Login')

@section('body')
    <app-login :auth="{{ json_encode(auth()->user()) }}"></app-login>
@endsection
