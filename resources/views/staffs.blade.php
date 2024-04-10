@extends('layouts.dashboard')

@section('title')
    Staffs
@endsection

@section('body-title')
    Staffs
@endsection

@section('content')
    <app-header title="Staffs" :auth="{{ json_encode(auth()->user()) }}"></app-header>

    <staff-page :data="{{ json_encode($data) }}" :roles="{{ json_encode($roles) }}" />
@endsection
