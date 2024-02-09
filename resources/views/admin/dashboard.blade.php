@extends('admin.layouts.navbar')

@section('content-with-nav')
    <h1>Dashboard Main {{ Auth::user()->name }}</h1>
@endsection
