@extends('layouts.landing')

@section('title', 'Home')

@push('styles')
<style type="text/css">
#welcome-text, #app-name {
    display: inline;
    color: white;
    text-shadow: 0 2px 1px rgba(0, 0, 0, 0.4);
}

#welcome-text {
    font-size: 35px;
}

#app-name {
    font-size: 40px;
}

.r-text {
    align-items: center
}
</style>
@endpush

@section('content')
<v-layout row wrap style="position: absolute; top: 20px; right: 20px; height: auto">
    <v-btn color="white" outlined>Login</v-btn>&nbsp;&nbsp;
	<v-btn color="primary" outlined href="{{ route('auth.register') }}">Sign up</v-btn>
</v-layout>
<v-layout justify-center align-center>
    <v-flex xs12 sm8 text-center id="landing-title">
        <p id="welcome-text">Welcome to</p><br />
        <h1 id="app-name">{{ env('APP_NAME') }}</h1><br />
    </v-flex>
</v-layout>
@endsection
