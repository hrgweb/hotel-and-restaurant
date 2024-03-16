@extends('layouts.dashboard')

@section('title')
    Categories
@endsection

@section('body-title')
    Categories
@endsection

@section('body')
    <category-page :data="{{ json_encode($data) }}" />
@endsection
