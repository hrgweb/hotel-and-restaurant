@extends('layouts.dashboard')

@section('title')
    Tables
@endsection

@section('body-title')
    Tables
@endsection

@section('content')
    <app-header title="Tables" :auth="{{ json_encode(auth()->user()) }}"></app-header>

    <table-page :data="{{ json_encode($data) }}" />
@endsection
