@extends('layouts.dashboard')

@section('title')
    Tables
@endsection

@section('body-title')
    Tables
@endsection

@section('body')
    <table-page :data="{{ json_encode($data) }}" />
@endsection
