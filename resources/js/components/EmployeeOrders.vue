<template>
	<v-data-table
		:headers="headers"
		:items="orders"
		class="elevation-1"
		:loading="loadingTable"
	>
		<template v-slot:item.action="{ item }">
			<v-dialog
				v-model="dialog"
				scrollable
				transition="dialog-transition"
				max-width="500px"
			>
				<template v-slot:activator="{ on }">
					<v-btn
						color="info"
						mr-2
						icon
						small
						v-on="on"
						@click="viewProducts(item)"
					>
						<v-icon small>mdi-eye</v-icon>
					</v-btn>
				</template>
				<v-card>
					<v-card-text>
						<v-list>
							<v-list-item
								two-line
								v-for="product in selectedProducts"
								:key="product.id"
							>
								<v-list-item-content>
									<v-list-item-title>
										{{ product.name }}
									</v-list-item-title>
									<v-list-item-subtitle>
										${{ product.unit_cost }}
									</v-list-item-subtitle>
								</v-list-item-content>
							</v-list-item>
							<v-list-item>
								<v-list-item-content>
									<v-list-item-title
										>Total Cost:
									</v-list-item-title>
									<span class="success--text"
										>${{ totalCost }}</span
									>
								</v-list-item-content>
							</v-list-item>
						</v-list>
					</v-card-text>
					<v-divider></v-divider>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn color="info" text @click="dialog = false"
							>Close</v-btn
						>
					</v-card-actions>
				</v-card>
			</v-dialog>
		</template>
		<template v-slot:item.status="{ item }">
			<v-switch
				label="Completed"
				v-model="item.status"
				small
				@change="toggleOrderStatus(item.id)"
			></v-switch>
		</template>
	</v-data-table>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import { EmployeeOrder } from '@/models/EmployeeOrder';
import { Product } from '@/models/Product';

@Component
export default class EmployeeOrders extends Vue {
	private headers: Array<Object> = [
		{
			text: 'Customer',
			value: 'customer_name',
		},
		{
			text: 'Time of Placement',
			value: 'time_of_placement',
		},
		{
			text: 'Cost (+ GCT)',
			value: 'cost',
		},
		{
			text: 'To Be Delivered By',
			value: 'delivery_date',
		},
		{
			text: 'Actions',
			value: 'action',
		},
		{
			text: 'Status',
			value: 'status',
		},
	];

	private loadingTable: boolean | string = false;
	private orders: Array<EmployeeOrder> = [];
	private dialog: boolean = false;
	private selectedProducts: Product[] = [];
	private totalCost: number = 0;

	created() {
		this.init();
	}

	init() {
		const vm = this;

		vm.loadingTable = 'info';

		vm.$axios
			.get('/api/employee/orders')
			.then(res => {
				vm.orders = res.data;
				vm.loadingTable = false;
			})
			.catch(err => {
				const message =
					err.response.data.message || 'Unknown server error.';

				vm.$dialog.show({
					title: 'Error',
					message,
					dialogType: 'error',
				});

				vm.loadingTable = false;
			});
	}

	viewProducts(order: EmployeeOrder) {
		this.selectedProducts = order.products;
		this.totalCost = order.cost;
	}

	toggleOrderStatus(order_id: number) {
		const vm = this;

		vm.loadingTable = 'info';

		vm.$axios
			.put(`/api/toggle/order/${order_id}`)
			.then(res => {
				vm.$dialog.show({
					title: 'Order Status',
					message: 'The order status has been updated.',
				});

				vm.loadingTable = false;
			})
			.catch(err => {
				const message =
					err.response.data.message || 'Unknown server error.';

				vm.$dialog.show({
					title: 'Error',
					message,
					dialogType: 'error',
				});

				vm.loadingTable = false;
			});
	}
}
</script>
