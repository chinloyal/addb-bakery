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
					v-model="productDialog"
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
					<v-card :loading="loadingProductForm">
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
			<v-btn
				icon
				color="purple"
				title="Edit Ingredients"
				small
				@click.stop="editIngredients(item)"
			>
				<v-icon small>mdi-grain</v-icon>
			</v-btn>
		</template>
		<template v-slot:footer>
			<v-dialog
				v-model="ingredientsDialog"
				scrollable
				max-width="500px"
				transition="dialog-transition"
			>
				<v-card :loading="loadingIngredientsForm">
					<v-card-title>
						<span class="headline">Edit Ingredients</span>
					</v-card-title>
					<v-card-text>
						<v-container>
							<v-autocomplete
								v-model="selectedIngredients"
								name="ingredient"
								:items="ingredients"
								item-text="name"
								item-value="id"
								chips
								deletable-chips
								multiple
								return-object
								label="Ingredients"
								hint="Click to select ingredients."
								persistent-hint
							></v-autocomplete>
						</v-container>
					</v-card-text>
					<v-divider></v-divider>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn
							color="primary"
							@click="ingredientsDialog = false"
							text
							>Close</v-btn
						>
						<v-btn
							color="primary"
							@click="saveProductIngredients()"
							text
							>Save</v-btn
						>
					</v-card-actions>
				</v-card>
			</v-dialog>
		</template>
	</v-data-table>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Product } from '@/models/Product';
import { Ingredient } from '@/models/Ingredient';
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
	private ingredients: Array<Ingredient> = [];

	private loadingTable: string | boolean = false;
	private loadingProductForm: string | boolean = false;
	private loadingIngredientsForm: string | boolean = false;
	private productDialog: boolean = false;
	private ingredientsDialog: boolean = false;

	private formTitle: string = '';
	private formAction: string = '';
	private selectedProduct: Product = new Product('', 0);
	private selectedIngredients: Array<Ingredient> = [];

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

				axios
					.get('/api/ingredients')
					.then(response => {
						vm.ingredients = response.data;
					})
					.catch(err => {
						const message =
							err.response.data.message ||
							'Unknown error occured.';
						vm.$dialog.show({
							title: 'Error',
							message,
							dialogType: 'error',
						});
					});
			})
			.catch(err => {
				vm.$dialog.show({
					title: 'Error',
					message: err.response.data.message,
					dialogType: 'error',
				});
				vm.loadingTable = false;
			});
	}

	close() {
		this.productDialog = false;
	}

	open(title: string, action: string, product: Product = new Product('', 0)) {
		this.productDialog = true;
		this.formTitle = title;
		this.formAction = action;
		this.selectedProduct = product;
	}

	save() {
		let vm = this;

		vm.loadingProductForm = 'primary';

		axios
			.post('/api/products/store', this.selectedProduct)
			.then(res => {
				vm.loadingProductForm = false;
				vm.close();
				vm.init();

				vm.selectedProduct = new Product('', 0);
			})
			.catch(err => {
				vm.loadingProductForm = false;
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
		vm.loadingProductForm = 'primary';

		axios
			.post(
				`/api/products/update/${vm.selectedProduct.id}`,
				vm.selectedProduct
			)
			.then(res => {
				vm.loadingProductForm = false;
				vm.close();
				vm.init();
			})
			.catch(err => {
				vm.$dialog.show({
					title: 'Error',
					message: err.response.data.message,
					dialogType: 'error',
				});
				vm.loadingProductForm = false;
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

	editIngredients(product: Product) {
		this.selectedProduct = product;
		this.selectedIngredients = product.ingredients;
		this.ingredientsDialog = true;
	}

	saveProductIngredients() {
		const ingredientsIds = this.selectedIngredients.map(el => {
			return el.id;
		});

		this.loadingIngredientsForm = 'info';

		axios
			.put(
				`/api/products/update/ingredients/${this.selectedProduct.id}`,
				ingredientsIds
			)
			.then(res => {
				this.$dialog.show({
					title: 'Success',
					message: 'Ingredients saved to product successfully.',
				});

				this.loadingIngredientsForm = false;
				this.ingredientsDialog = false;
				this.init();
			})
			.catch(err => {
				const message =
					err.response.data.message || 'Unknown server error.';

				this.$dialog.show({
					title: 'Error',
					message,
					dialogType: 'error',
				});
			});
	}
}
</script>
