@extends('layouts.app')

@section('title', 'Manage Employees')

@section('content')
<div id="test-vue">
	<v-btn color="blue">@{{ 'hello' }}</v-btn>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	// var vm = Vue.extend({
	// 	el: '#test-vue',
	// 	data: function () {
	// 		return {
	// 			hello: 'test'
	// 		}
	// 	}
	// });
	console.log(app);

</script>
@endpush
