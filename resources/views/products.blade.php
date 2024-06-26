@extends('layouts.dashboard')

@section('title')
    Products
@endsection

@section('body-title')
    Products
@endsection

@section('content')
    <app-header title="Products" :auth="{{ json_encode(auth()->user()) }}"></app-header>

    <product-page :data="{{ json_encode($data) }}" :categories="{{ json_encode($categories) }}" />
@endsection
