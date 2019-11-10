<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>{{ env('APP_NAME') }} - @yield('title')</title>
	<link rel="stylesheet" href="{{ mix('/css/app.css') }}">
	@stack('styles')
</head>

<body>
	<div id="main-app">
		<v-app>
			@include('common.error-snackbar')
			<app-dialog></app-dialog>
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
						@role('admin')
							@include('partials.admin.aside')
						@elserole('employee')
							@include('partials.employee.aside')
						@elserole('customer')
							@include('partials.customer.aside')
						@endrole
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
					@role('customer')
					<v-spacer></v-spacer>
					@verbatim
					<v-menu
						v-model="$store.state.cartMenu"
						:close-on-content-click="false"
						offset-y
					>
						<template v-slot:activator="{ on }">
							<v-btn icon class="mr-2" v-on="on">
								<v-badge color="info" overlap>
									<template v-slot:badge>{{ $store.getters['cart/count'] }}</template>
									<v-icon>mdi-cart</v-icon>
								</v-badge>
							</v-btn>
						</template>
						<v-card>
							<v-list>
								<v-list-item>
									<v-list-item-content>
										<v-list-item-title>Overview of products</v-list-item-title>
									</v-list-item-content>
								</v-list-item>
							</v-list>
							<v-divider></v-divider>
							<v-list v-if="$store.getters['cart/count'] > 0">
								<v-list-item
									v-for="product in $store.getters['cart/items']"
									:key="product.id"
								>
									<v-list-item-content>
										<v-list-item-subtitle>
											x1 {{ product.name }} (${{ product.unit_cost }})
										</v-list-item-subtitle>
									</v-list-item-content>
								</v-list-item>
							</v-list>
							<v-card-text v-else>
								<v-card-subtitle>No products added.</v-card-subtitle>
							</v-card-text>
							<v-divider></v-divider>
							<v-card-actions>
								<v-btn
									color="primary"
									text
									v-on:click="$store.dispatch('cart/placeOrder')"
								>Place order</v-btn>
								<v-btn
									text
									color="error"
									v-on:click="$store.dispatch('cart/emptyCart')"
								><v-icon>mdi-delete</v-icon> Empty Cart</v-btn>
								<v-btn
									text
									color="info"
									v-on:click="$store.commit('setCartMenu', false)"
								>Cancel</v-btn>
							</v-card-actions>
						</v-card>
					</v-menu>
					@endverbatim
					@endrole
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
