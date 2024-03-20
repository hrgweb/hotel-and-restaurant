@extends('layouts.pos')

@section('title')
    POS
@endsection

@section('body-title')
    POS
@endsection

@section('body')
    <pos-page :tables="{{ json_encode($tables) }}" />
@endsection
