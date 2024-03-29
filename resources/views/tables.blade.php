@extends('layouts.dashboard')

@section('title')
    Tables
@endsection

@section('body-title')
    Tables
@endsection

@section('content')
    <app-header title="Tables"></app-header>

    <table-page :data="{{ json_encode($data) }}" />
@endsection
