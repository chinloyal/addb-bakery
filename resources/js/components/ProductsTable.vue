<template>
	<v-data-table
		:headers="headers"
		:items="products"
		class="elevation-1"
		:loading="loadingTable"
	>
		<template v-slot:top>
			<v-toolbar color="primary" dark flat>
				<v-toolbar-title>Products</v-toolbar-title>
				<v-spacer></v-spacer>
				<v-dialog
					v-model="dialog"
					max-width="500px"
					transition="dialog-transition"
				>
					<template v-slot:activator="{ on }">
						<v-btn
							color="white"
							light
							class="mb-2"
							v-on="on"
							@click="open('New Prodct', 'store')"
							>Add Product</v-btn
						>
					</template>
					<v-card :loading="loadingForm">
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<v-card-text>
							<v-container>
								<v-text-field
									name="code"
									label="Product Code"
									v-model="selectedProduct.code"
								></v-text-field>
								<v-text-field
									name="name"
									label="Product Name"
									v-model="selectedProduct.name"
								></v-text-field>
								<v-text-field
									name="current_quantity"
									label="Quantity"
									type="number"
									v-model="selectedProduct.current_quantity"
								></v-text-field>
								<v-text-field
									name="unit_cost"
									type="number"
									label="Unit Cost ($)"
									v-model="selectedProduct.unit_cost"
								></v-text-field>
							</v-container>
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn text color="primary darken-1" @click="close"
								>Close</v-btn
							>
							<v-btn
								v-if="formAction == 'store'"
								text
								color="primary darken-1"
								@click="save"
								>Save</v-btn
							>
							<v-btn
								v-else-if="formAction == 'edit'"
								text
								color="primary darken-1"
								@click="update"
								>Update</v-btn
							>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-toolbar>
		</template>
		<template v-slot:item.action="{ item }">
			<v-btn
				color="info"
				icon
				small
				class="mr-2"
				@click="edit(item)"
				title="Edit"
			>
				<v-icon small>mdi-pencil</v-icon>
			</v-btn>
			<v-btn
				color="error"
				icon
				small
				class="mr-2"
				@click="deleteItem(item)"
				title="Delete"
			>
				<v-icon small>mdi-delete</v-icon>
			</v-btn>
		</template>
	</v-data-table>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Product } from '@/models/Product';
import axios from 'axios';

@Component
export default class ProductsTable extends Vue {
	private headers: Array<Object> = [
		{
			text: 'Product Code',
			value: 'code',
		},
		{
			text: 'Product',
			value: 'name',
		},
		{
			text: 'Current Quantity',
			value: 'current_quantity',
		},
		{
			text: 'Unit Cost ($)',
			value: 'unit_cost',
		},
		{
			text: 'Actions',
			value: 'action',
			sortable: false,
		},
	];

	private products: Array<Product> = [];

	private loadingTable: string | boolean = false;
	private loadingForm: string | boolean = false;
	private dialog: boolean = false;

	private formTitle: string = '';
	private formAction: string = '';
	private selectedProduct: Product = new Product('', '', 0, 0);

	created() {
		this.init();
	}

	init() {
		let vm = this;

		vm.loadingTable = 'primary';

		axios
			.get('/api/products')
			.then(res => {
				vm.products = res.data;
				vm.loadingTable = false;
			})
			.catch(err => {
				vm.$dialog.show({
					title: 'Error',
					message: err,
					dialogType: 'error',
				});
				vm.loadingTable = false;
			});
	}

	close() {
		this.dialog = false;
	}

	open(
		title: string,
		action: string,
		product: Product = new Product('', '', 0, 0)
	) {
		this.dialog = true;
		this.formTitle = title;
		this.formAction = action;
		this.selectedProduct = product;
	}

	save() {
		let vm = this;

		vm.loadingForm = 'primary';

		axios
			.post('/api/products/store', this.selectedProduct)
			.then(res => {
				vm.loadingForm = false;
				vm.close();
				vm.init();

				vm.selectedProduct = new Product('', '', 0, 0);
			})
			.catch(err => {
				vm.loadingForm = false;
				vm.$dialog.show({
					title: 'Error',
					message: err.response.data.message,
					dialogType: 'error',
				});
			});
	}

	edit(product: Product) {
		this.open('Edit Product', 'edit', product);
	}

	update() {
		const vm = this;
		vm.loadingForm = 'primary';

		axios
			.post(
				`/api/products/update/${vm.selectedProduct.id}`,
				vm.selectedProduct
			)
			.then(res => {
				vm.loadingForm = false;
				vm.close();
				vm.init();
			})
			.catch(err => {
				vm.$dialog.show({
					title: 'Error',
					message: err.response.data.message,
					dialogType: 'error',
				});
				vm.loadingForm = false;
			});
	}

	deleteItem(product) {
		const vm = this;

		vm.$dialog.show({
			title: 'Confirm Delete',
			message: `Are you sure you want to delete "${product.name}"`,
			showCancelBtn: true,
			onConfirm() {
				axios
					.delete(`/api/products/delete/${product.id}`)
					.then(res => {
						vm.init();
					})
					.catch(err => {
						vm.$dialog.show({
							title: 'Error',
							message: err.response.data.message,
							dialogType: 'error',
						});
					});
			},
		});
	}
}
</script>
