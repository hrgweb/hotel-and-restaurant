@extends('layouts.dashboard')

@section('title')
    User Roles
@endsection

@section('body-title')
    User Roles
@endsection

@section('body')
    <user-role-page :data="{{ json_encode($data) }}" />
@endsection
