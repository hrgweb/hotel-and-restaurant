@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')
    <app-header title="Categories" :auth="{{ json_encode(auth()->user()) }}"></app-header>

    <category-page :data="{{ json_encode($data) }}" />
@endsection
