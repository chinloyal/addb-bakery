<template>
	<v-card :loading="loading">
		<v-toolbar color="primary" dark>
			<v-toolbar-title>Login</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-icon>mdi-account</v-icon>
		</v-toolbar>
		<v-card-text>
			<v-form method="POST" :action="action" @submit="submit">
				<slot></slot>
				<v-text-field
					required
					name="email"
					label="E-mail"
					v-model="email"
					prepend-icon="mdi-email"
					:error-messages="emailErrors"
					@input="$v.email.$touch()"
				></v-text-field>
				<v-text-field
					required
					type="password"
					name="password"
					label="Password"
					v-model="password"
					prepend-icon="mdi-lock"
					:error-messages="passwordErrors"
					@input="$v.password.$touch()"
				></v-text-field>
				<v-checkbox
					label="Remember Me"
					name="remember"
					v-model="remember"
				>
				</v-checkbox>
				<p>Don't have an account? <a href="/sign-up">Sign up</a></p>
				<v-btn type="submit" color="primary">log in</v-btn>
			</v-form>
		</v-card-text>
	</v-card>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';

@Component({
	mixins: [validationMixin],
	validations: {
		email: {
			required,
		},
		password: {
			required,
		},
	},
})
export default class LoginForm extends Vue {
	private email: string = '';
	private password: string = '';
	private remember: boolean = false;

	private loading: string | boolean = false;

	@Prop(String) readonly action: string;

	submit() {
		this.loading = 'info';
	}

	get emailErrors() {
		const errors = [];

		if (!this.$v.email.$dirty) return errors;

		if (!this.$v.email.required) errors.push('E-mail is required.');

		return errors;
	}

	get passwordErrors() {
		const errors = [];

		if (!this.$v.password.$dirty) return errors;

		if (!this.$v.password.required) errors.push('Password is required.');

		return errors;
	}
}
</script>
