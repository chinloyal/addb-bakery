<template>
	<v-data-table
		:headers="headers"
		:items="orders"
		class="elevation-1"
		:loading="loadingTable"
	>
		<template v-slot:item.completed="{ item }">
			<v-chip
				v-if="item.completed == 1"
				color="success"
				text-color="white"
				small
			>
				<v-avatar left>
					<v-icon small>mdi-checkbox-marked-circle</v-icon>
				</v-avatar>
				Complete
			</v-chip>
			<v-chip v-else color="error" text-color="white" small>
				<v-avatar left>
					<v-icon small>mdi-close-circle</v-icon>
				</v-avatar>
				Incomplete
			</v-chip>
		</template>
		<template v-slot:item.action="{ item }">
			<v-btn color="info" icon small @click.stop="viewProducts(item)">
				<v-icon small>mdi-eye</v-icon>
			</v-btn>
		</template>
		<template v-slot:footer>
			<v-dialog
				v-model="dialog"
				scrollable
				transition="dialog-transition"
				max-width="500px"
			>
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
										{{
											product.unit_cost
												| gct(selectedOrder)
										}}
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
	</v-data-table>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { CustomerOrder } from '@/models/CustomerOrder';
import { Product } from '@/models/Product';

@Component({
	filters: {
		gct(cost, order: CustomerOrder) {
			const gctToBeAdded = ((order.gct / 100) * cost).toFixed(2);
			return `$${cost} (+ $${gctToBeAdded})`;
		},
	},
})
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
		{
			text: 'Actions',
			value: 'action',
		},
	];

	private orders: Array<CustomerOrder> = [];
	private loadingTable: boolean | string = false;
	private dialog: boolean = false;
	private selectedProducts: Product[] = [];
	private selectedOrder: CustomerOrder = null;
	private totalCost: number = 0;

	created() {
		this.init();
	}

	init() {
		const vm = this;
		vm.loadingTable = 'info';

		vm.$axios
			.get('/api/customer/orders')
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

	viewProducts(order: CustomerOrder) {
		this.selectedOrder = order;
		this.selectedProducts = order.products;
		this.totalCost = order.cost;
		this.dialog = true;
	}
}
</script>
