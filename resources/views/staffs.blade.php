@extends('layouts.dashboard')

@section('title')
    Staffs
@endsection

@section('body-title')
    Staffs
@endsection

@section('body')
    <staff-page :data="{{ json_encode($data) }}" :roles="{{ json_encode($roles) }}" />
@endsection
