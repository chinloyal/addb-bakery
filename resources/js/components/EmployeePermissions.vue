<template>
	<v-card width="100%" :loading="loading">
		<v-card-title>
			Employee Permissions
		</v-card-title>
		<v-divider></v-divider>
		<v-card-text>
			<v-row>
				<v-col
					v-for="permission in userPermissionsData"
					:key="permission.id"
					cols="4"
				>
					<v-switch
						color="purple"
						:label="permission.name"
						v-model="permission.cando"
						@change="togglePermission(permission)"
						inset
					>
					</v-switch>
				</v-col>
			</v-row>
		</v-card-text>
	</v-card>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import axios from 'axios';

@Component
export default class EmployeePermissions extends Vue {
	@Prop(Array) readonly userPermissions;
	@Prop(Number) readonly userId;

	private userPermissionsData = [];
	private loading: boolean | string = false;

	created() {
		this.init();
	}

	init() {
		this.userPermissionsData = this.userPermissions;
	}

	togglePermission(permission) {
		const vm = this;
		vm.loading = 'primary';

		axios
			.put(`/api/permission/toggle/${permission.id}`, {
				user_id: vm.userId,
			})
			.then(res => {
				vm.loading = false;
			})
			.catch(err => {
				vm.$dialog.show({
					title: 'Error',
					message: err.response.data.message,
					dialogType: 'error',
				});

				vm.loading = false;
			});
	}
}
</script>
