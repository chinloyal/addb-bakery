@extends('layouts.landing')

@section('title', 'Sign Up')

@section('content')
<v-layout align-center justify-center>
	<v-flex xs12 sm8 md4>
		<v-card id="signup-form-card" elevation-12>
			<v-toolbar color="primary">
				<v-toolbar-title>Customer Registration</v-toolbar-title>
				<v-spacer></v-spacer>
				<v-icon>mdi-account-plus</v-icon>
			</v-toolbar>
			<v-tabs vertical>
				<v-tab>
					<v-icon left>mdi-account</v-icon>
					Individual
				</v-tab>
				<v-tab>
					<v-icon left>mdi-office-building</v-icon>
					Corporate
				</v-tab>
				<v-tab-item>
					<v-card flat>
						<v-card-text>
							<sign-up-form
								{{-- v-on:submit="vm1.here" --}}
								action="{{ route('auth.register.post') }}"
								user-type="individual"
							>
								{{ csrf_field() }}
							</sign-up-form>
						</v-card-text>
					</v-card>
				</v-tab-item>
				<v-tab-item>
					<v-card flat>
						<v-card-text>
							<sign-up-form
								{{-- v-on:submit="vm1.here" --}}
								action="{{ route('auth.register.post') }}"
								user-type="corporate"
							>
								{{ csrf_field() }}
							</sign-up-form>
						</v-card-text>
					</v-card>
				</v-tab-item>
			</v-tabs>
		</v-card>
	</v-flex>
</v-layout>
@endsection

