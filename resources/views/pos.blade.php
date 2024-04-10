@extends('layouts.pos')

@section('title')
    POS
@endsection

@section('body-title')
    POS
@endsection

@section('body')
    <pos-page :tables="{{ json_encode($tables) }}" :categories="{{ json_encode($categories) }}"
        :products="{{ json_encode($products) }}" />
@endsection
