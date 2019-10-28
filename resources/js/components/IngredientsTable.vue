<template>
	<v-data-table
		:headers="headers"
		:items="ingredients"
		class="elevation-1"
		:loading="loadingTable"
	>
		<template v-slot:top>
			<v-toolbar color="primary" dark flat>
				<v-toolbar-title>Ingedients</v-toolbar-title>
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
							@click="open('New Ingredient', 'store')"
							>Add Ingredient</v-btn
						>
					</template>
					<v-card :loading="loadingForm">
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<v-card-text>
							<v-container>
								<v-text-field
									name="name"
									label="Ingredient Name"
									v-model="selectedIngredient.name"
								></v-text-field>
								<v-text-field
									name="measurement_unit"
									label="Measurement Unit"
									v-model="
										selectedIngredient.measurement_unit
									"
								></v-text-field>
								<v-text-field
									name="current_quantity"
									label="Quantity"
									v-model="
										selectedIngredient.current_quantity
									"
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
								v-else-if="(formAction = 'edit')"
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
import { Ingredient } from '@/models/Ingredient';
import axios from 'axios';

@Component
export default class IngredientsTable extends Vue {
	private headers: Array<Object> = [
		{
			text: 'Ingredient',
			value: 'name',
		},
		{
			text: 'Measurement Unit',
			value: 'measurement_unit',
		},
		{
			text: 'Current Quantity',
			value: 'current_quantity',
		},
		{
			text: 'Reorder Level',
			value: 'reorder_level',
		},
		{
			text: 'Actions',
			value: 'action',
			sortable: false,
		},
	];

	private ingredients: Array<Ingredient> = [];

	private loadingTable: string | boolean = false;
	private loadingForm: string | boolean = false;
	private dialog: boolean = false;

	private formTitle: string = '';
	private formAction: string = '';
	private selectedIngredient: Ingredient = new Ingredient('', '', 0);

	created() {
		this.init();
	}

	init() {
		let vm = this;

		vm.loadingTable = 'primary';

		axios
			.get('/api/ingredients')
			.then(res => {
				vm.ingredients = res.data;
				vm.loadingTable = false;
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
		this.dialog = false;
	}

	open(
		title: string,
		action: string,
		ingredient: Ingredient = new Ingredient('', '', 0)
	) {
		this.dialog = true;
		this.formTitle = title;
		this.formAction = action;
		this.selectedIngredient = ingredient;
	}

	save() {
		let vm = this;

		vm.loadingForm = 'primary';

		axios
			.post('/api/ingredients/store', this.selectedIngredient)
			.then(res => {
				vm.loadingForm = false;
				vm.close();
				vm.ingredients.push(res.data);

				vm.selectedIngredient = new Ingredient('', '', 0);
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

	edit(ingredient: Ingredient) {
		this.open('Edit Ingredient', 'edit', ingredient);
	}

	update() {
		const vm = this;
		vm.loadingForm = 'primary';

		axios
			.post(
				`/api/ingredients/update/${vm.selectedIngredient.id}`,
				vm.selectedIngredient
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

	deleteItem(ingredient) {
		const vm = this;

		vm.$dialog.show({
			title: 'Confirm Delete',
			message: `Are you sure you want to delete "${ingredient.name}"`,
			showCancelBtn: true,
			onConfirm() {
				axios
					.delete(`/api/ingredients/delete/${ingredient.id}`)
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
