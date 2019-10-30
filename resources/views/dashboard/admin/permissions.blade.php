@extends('layouts.app')

@section('title', 'Manage Employee Permission')

@section('content')
<employee-permissions
	:user-permissions="{{ $user_permissions->toJson() }}"
	:user-id="{{ $user_id }}"
></employee-permissions>
@endsection
