@extends('layouts.landing')

@section('title', 'Login')

@section('content')
<v-layout align-center justify-center>
	<v-flex xs12 sm8 md4>
		<login-form action="{{ route('auth.login.post') }}">
			{{ csrf_field() }}
		</login-form>
	</v-flex>
</v-layout>
@endsection
