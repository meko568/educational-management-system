@extends('layouts.app')

@section('title')
    {{ $title ?? config('app.name', 'Laravel') }}
@endsection

@section('header')
    {{ $header ?? '' }}
@endsection

@section('content')
    {{ $slot }}
@endsection
