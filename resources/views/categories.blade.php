@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')
    <app-header title="Categories"></app-header>

    <category-page :data="{{ json_encode($data) }}" />
@endsection
