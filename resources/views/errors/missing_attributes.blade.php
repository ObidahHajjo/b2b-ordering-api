@extends('errors.layout')

@section('title', 'Missing Attributes')

@section('content')
    <h1>Missing Required Attributes</h1>
    <p>{{ $message }}</p>
@endsection
