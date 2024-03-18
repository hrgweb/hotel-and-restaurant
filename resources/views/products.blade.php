@extends('layouts.dashboard')

@section('title')
    Products
@endsection

@section('body-title')
    Products
@endsection

@section('body')
    <product-page :data="{{ json_encode($data) }}" />
@endsection
