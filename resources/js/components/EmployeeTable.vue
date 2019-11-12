<template>
	<v-data-table
		:headers="headers"
		:items="employees"
		class="elevation-1"
		:loading="loadingTable"
	>
		<template v-slot:top>
			<v-toolbar color="primary" dark flat>
				<v-toolbar-title>Employees</v-toolbar-title>
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
							@click="open('New Employee', 'store')"
							>Add Employee</v-btn
						>
					</template>
					<v-card :loading="loadingForm">
						<v-card-title>
							<span class="headline">{{ formTitle }}</span>
						</v-card-title>
						<v-card-text>
							<v-container>
								<v-text-field
									name="first_name"
									label="First Name"
									v-model="selectedEmployee.user.first_name"
								></v-text-field>
								<v-text-field
									name="last_name"
									label="Last Name"
									v-model="selectedEmployee.user.last_name"
								></v-text-field>
								<v-text-field
									name="email"
									label="E-mail Address"
									v-model="selectedEmployee.user.email"
								></v-text-field>
								<v-text-field
									name="trn"
									label="TRN"
									v-model="selectedEmployee.trn"
								></v-text-field>
								<v-text-field
									name="address"
									label="Address"
									v-model="selectedEmployee.address"
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
			<!-- <v-btn
				@click="edit(item)"
				icon
				color="info"
				small
				class="mr-2"
				title="Edit"
			>
				<v-icon small>mdi-pencil</v-icon>
			</v-btn> -->
			<v-btn
				@click="deleteItem(item)"
				icon
				color="error"
				small
				class="mr-2"
				title="Delete"
			>
				<v-icon small>mdi-delete</v-icon>
			</v-btn>
			<v-btn
				:href="`/manage/employees/${item.user.id}/permissions`"
				icon
				color="success"
				small
				class="mr-2"
				title="Manage Permissions"
			>
				<v-icon small>mdi-lock</v-icon>
			</v-btn>
		</template>
	</v-data-table>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Employee } from '@/models/Employee';
import { User } from '@/models/User';
import axios from 'axios';

@Component
export default class EmployeeTable extends Vue {
	private headers: Array<Object> = [
		{
			text: 'First Name',
			value: 'user.first_name',
		},
		{
			text: 'Last Name',
			value: 'user.last_name',
		},
		{
			text: 'E-mail Address',
			value: 'user.email',
		},
		{
			text: 'TRN',
			value: 'trn',
		},
		{
			text: 'Address',
			value: 'address',
		},
		{
			text: 'Actions',
			value: 'action',
		},
	];

	private employees: Array<Employee> = [];
	private loadingTable: boolean | string = false;
	private loadingForm: boolean | string = false;
	private selectedEmployee: Employee = new Employee(
		'',
		'',
		new User('', '', '')
	);
	private dialog: boolean = false;
	private formTitle: string = '';
	private formAction: string = '';

	created() {
		this.init();
	}

	init() {
		const vm = this;

		vm.loadingTable = 'primary';

		axios
			.get('/api/employees')
			.then(res => {
				vm.employees = res.data;
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

	open(
		title: string,
		action: string,
		employee: Employee = new Employee('', '', new User('', '', ''))
	) {
		this.dialog = true;
		this.formTitle = title;
		this.formAction = action;
		this.selectedEmployee = employee;
	}

	close() {
		this.dialog = false;
	}

	// edit(employee: Employee) {
	// 	this.open('Edit Employee', 'edit', employee);
	// }

	// update() {
	// 	const vm = this;
	// 	vm.loadingForm = 'primary';

	// 	axios
	// 		.post(
	// 			`/api/ingredients/update/${vm.selectedEmployee.id}`,
	// 			vm.selectedEmployee
	// 		)
	// 		.then(res => {
	// 			vm.loadingForm = false;
	// 			vm.close();
	// 			vm.init();
	// 		})
	// 		.catch(err => {
	// 			vm.$dialog.show({
	// 				title: 'Error',
	// 				message: err.response.data.message,
	// 				dialogType: 'error',
	// 			});
	// 			vm.loadingForm = false;
	// 		});
	// }

	save() {
		let vm = this;

		vm.loadingForm = 'primary';

		axios
			.post('/api/employee/create', this.selectedEmployee)
			.then(res => {
				vm.loadingForm = false;
				vm.close();
				vm.init();

				vm.selectedEmployee = new Employee(
					'',
					'',
					new User('', '', '')
				);
			})
			.catch(err => {
				vm.loadingForm = false;
				let message =
					err.response.data.message ||
					err.response.data.messages.join(', ');
				vm.$dialog.show({
					title: 'Error',
					message: message,
					dialogType: 'error',
				});
			});
	}

	deleteItem(employee: Employee) {}
}
</script>
