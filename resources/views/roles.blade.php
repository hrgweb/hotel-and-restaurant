@extends('layouts.dashboard')

@section('title')
    User Roles
@endsection

@section('body-title')
    User Roles
@endsection

@section('content')
    <app-header title="Staff Roles"></app-header>

    <user-role-page :data="{{ json_encode($data) }}" />
@endsection
