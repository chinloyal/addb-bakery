@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
Welcome, {{ auth()->user()->first_name }}
@endsection
