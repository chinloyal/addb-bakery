<template>
	<v-data-table
		:headers="headers"
		:items="orders"
		class="elevation-1"
		:loading="loadingTable"
	>
	</v-data-table>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Order } from '@/models/Order';

@Component
export default class CustomOrders extends Vue {
	private headers: Array<Object> = [
		{
			text: 'Delivery Date',
			value: 'delivery_date',
		},
		{
			text: 'Cost ($)',
			value: 'cost',
		},
		{
			text: 'GCT',
			value: 'gct',
		},
		{
			text: 'Employee Assigned',
			value: 'employee_name',
		},
		{
			text: 'Status',
			value: 'completed',
		},
	];

	private orders: Array<Order> = [];
	private loadingTable: boolean | string = false;
}
</script>
