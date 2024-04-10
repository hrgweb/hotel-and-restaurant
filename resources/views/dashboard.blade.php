@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('body-title', 'Dashboard')

@section('content')
    <app-header title="Dashboard" :auth="{{ json_encode(auth()->user()) }}"></app-header>


@endsection
