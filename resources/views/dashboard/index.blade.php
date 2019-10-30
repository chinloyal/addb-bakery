@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
Welcome, {{ auth()->user()->full_name }}
@endsection
