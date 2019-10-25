<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Bakery - @yield('title')</title>
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	@stack('styles')
</head>

<body>
	<div id="main-app">
		<v-app>
			@include('common.error-snackbar')
			<v-container fluid>
				<v-navigation-drawer v-model="drawer" app clipped>
					<v-list dense>
						<v-list-item href="/">
							<v-list-item-action>
								<v-icon>mdi-view-dashboard</v-icon>
							</v-list-item-action>
							<v-list-item-content>
								<v-list-item-title>Dashboard</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						<v-list-item href="/">
							<v-list-item-action>
								<v-icon>mdi-settings</v-icon>
							</v-list-item-action>
							<v-list-item-content>
								<v-list-item-title>Settings</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
						<v-list-item
							href="{{ route('auth.logout') }}"
							v-on:click.prevent="logout"
						>
							<form
								ref="logoutForm"
								action="{{ route('auth.logout') }}"
								method="POST"
								style="display: none"
							>
								{{ csrf_field() }}
							</form>
							<v-list-item-action>
								<v-icon>mdi-logout</v-icon>
							</v-list-item-action>
							<v-list-item-content>
								<v-list-item-title>Logout</v-list-item-title>
							</v-list-item-content>
						</v-list-item>
					</v-list>
				</v-navigation-drawer>

				<v-app-bar app clipped-left color="primary" dark>
					<v-app-bar-nav-icon v-on:click.stop="drawer = !drawer"></v-app-bar-nav-icon>
					<v-toolbar-title>{{ env('APP_NAME') }}</v-toolbar-title>
				</v-app-bar>

				<v-content>
					<v-container fluid fill-height>
						@yield('content')
					</v-container>
				</v-content>

				<v-footer app>
					<span>&copy; {{ date('Y') }}</span>
				</v-footer>
			</v-container>
		</v-app>
	</div>

	<script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
