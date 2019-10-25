@if($errors->count() > 0)
	<v-snackbar
		v-model="snackbar"
		color="error"
		multi-line
		top
		right
		:timeout="10000"
	>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
		<v-btn v-on:click="snackbar = false" text>Close</v-btn>
	</v-snackbar>
@endif
