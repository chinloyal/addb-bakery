<template>
	<v-data-table
		:headers="headers"
		:items="employees"
		class="elevation-1"
		:loading="loadingTable"
	>
		<template v-slot:item.action="{ item }">
			<v-btn
				@click="edit(item)"
				icon
				color="info"
				small
				class="mr-2"
				title="Edit"
			>
				<v-icon small>mdi-pencil</v-icon>
			</v-btn>
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

	edit(employee: Employee) {}

	deleteItem(employee: Employee) {}
}
</script>
