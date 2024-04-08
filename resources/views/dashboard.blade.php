@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('body-title', 'Dashboard')

@section('content')
    {{-- <app-header title="Dashboard" :auth="{{ json_encode(auth()->user()) }}"></app-header> --}}

    {{-- <div>
        <p>lorem ipsum</p>
    </div> --}}

    {{-- tmp --}}
    <app-for-test></app-for-test>
@endsection
