<template>
	<v-form id="signup-form" :action="action" @submit="submit" method="POST">
		<slot></slot>
		<input type="hidden" name="user_type" :value="userType" />
		<v-text-field
			required
			prepend-icon="mdi-account-badge-horizontal"
			label="First Name"
			v-model="fname"
			name="first_name"
			:error-messages="fnameErrors"
			@input="$v.fname.$touch()"
			@blur="$v.fname.$touch()"
		></v-text-field>
		<v-text-field
			required
			prepend-icon="mdi-account-badge-horizontal"
			label="Last Name"
			v-model="lname"
			name="last_name"
			:error-messages="lnameErrors"
			@input="$v.lname.$touch()"
			@blur="$v.lname.$touch()"
		></v-text-field>
		<v-text-field
			required
			prepend-icon="mdi-email"
			label="E-mail"
			v-model="email"
			name="email"
			:error-messages="emailErrors"
			@input="$v.email.$touch()"
			@blur="$v.email.$touch()"
		></v-text-field>
		<v-menu
			v-model="dateMenu"
			:close-on-content-click="false"
			:nudge-right="40"
			transition="scale-transition"
			offset-y
			min-width="290px"
			v-if="userType == 'individual'"
		>
			<template v-slot:activator="{ on }">
				<v-text-field
					required
					v-model="dob"
					name="dob"
					label="Date Of Birth"
					prepend-icon="mdi-calendar"
					:error-messages="dobErrors"
					readonly
					v-on="on"
					hint="Click to activate datepicker"
					@input="$v.dob.$touch()"
					@blur="$v.dob.$touch()"
					@focus="dateMenu = true"
				></v-text-field>
			</template>
			<v-date-picker v-model="dob" @input="dateMenu = false" />
		</v-menu>
		<v-text-field
			required
			prepend-icon="mdi-office-building"
			label="Business Name"
			v-model="bname"
			name="business_name"
			:error-messages="bnameErrors"
			@input="$v.bname.$touch()"
			@blur="$v.bname.$touch()"
			v-if="userType == 'corporate'"
		></v-text-field>
		<v-text-field
			required
			prepend-icon="mdi-office-building"
			label="TRN"
			hint="Tax Registration Number"
			v-model="trn"
			name="trn"
			:error-messages="trnErrors"
			@input="$v.trn.$touch()"
			@blur="$v.trn.$touch()"
			v-if="userType == 'corporate'"
			v-mask="'###-###-###'"
		></v-text-field>
		<v-text-field
			required
			prepend-icon="mdi-lock"
			name="password"
			label="Password"
			id="password"
			type="password"
			:error-messages="passwordErrors"
			@input="$v.password.$touch()"
			@blur="$v.password.$touch()"
			v-model="password"
		></v-text-field>
		<v-text-field
			required
			prepend-icon="mdi-lock"
			name="password_confirmation"
			label="Confirm Password"
			type="password"
			:error-messages="cPasswordErrors"
			@input="$v.confirm_password.$touch()"
			@blur="$v.confirm_password.$touch()"
			v-model="confirm_password"
		></v-text-field>
		<p>Already have an account? <a href="/login">Login</a></p>
		<v-btn type="submit" color="primary">sign up</v-btn>
	</v-form>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'vue-property-decorator';
import { mask } from 'vue-the-mask';
import { validationMixin } from 'vuelidate';
import {
	required,
	email,
	minLength,
	sameAs,
	CustomRule,
} from 'vuelidate/lib/validators';

const validTrn = value => /^[0-9]{3}-[0-9]{3}-[0-9]{3}$/.test(value);

@Component({
	directives: {
		mask,
	},
	mixins: [validationMixin],
	validations: {
		fname: {
			required,
			minLength: minLength(2),
		},
		lname: {
			required,
			minLength: minLength(2),
		},
		email: {
			required,
			email,
		},
		dob: {
			required,
		},
		bname: {
			required,
			minLength: minLength(2),
		},
		trn: {
			required,
			validTrn,
		},
		password: {
			required,
			minLength: minLength(6),
		},
		confirm_password: {
			sameAs: sameAs('password'),
		},
	},
})
export default class SignUpForm extends Vue {
	private fname: string = '';
	private lname: string = '';
	private email: string = '';
	private dob: Date = null;
	private bname: string = '';
	private trn: string = '';
	private password: string = '';
	private confirm_password: string = '';

	private dateMenu: boolean = false;

	@Prop(String) private action: string;
	@Prop(String) private readonly userType: string;

	@Emit() submit() {
		return true;
	}

	get fnameErrors() {
		const errors = [];

		if (!this.$v.fname.$dirty) return errors;

		if (!this.$v.fname.required) errors.push('First Name is required');

		if (!this.$v.fname.minLength)
			errors.push(
				`First Name must be at least ${this.$v.fname.$params.minLength.min} characters long.`
			);

		return errors;
	}

	get lnameErrors() {
		const errors = [];

		if (!this.$v.lname.$dirty) return errors;

		if (!this.$v.lname.required) errors.push('Last Name is required');

		if (!this.$v.lname.minLength)
			errors.push(
				`Last Name must be at least ${this.$v.lname.$params.minLength.min} characters long.`
			);

		return errors;
	}

	get emailErrors() {
		const errors = [];

		if (!this.$v.email.$dirty) {
			return errors;
		}

		if (!this.$v.email.required) {
			errors.push('Email is required.');
		}

		if (!this.$v.email.email) {
			errors.push('Please enter a valid email.');
		}

		return errors;
	}

	get dobErrors() {
		const errors = [];

		if (!this.$v.dob.$dirty) return errors;

		if (!this.$v.dob.required) errors.push('Date Of Birth is required.');

		return errors;
	}

	get bnameErrors() {
		const errors = [];

		if (!this.$v.bname.$dirty) return errors;

		if (!this.$v.bname.required) errors.push('Business Name is required');

		if (!this.$v.bname.minLength)
			errors.push(
				`Business Name must be at least ${this.$v.bname.$params.minLength.min} characters long.`
			);

		return errors;
	}

	get trnErrors() {
		const errors = [];

		if (!this.$v.trn.$dirty) return errors;

		if (!this.$v.trn.required) errors.push('TRN is required');

		if (!this.$v.trn.validTrn)
			errors.push('Invalid TRN, format (XXX-XXX-XXX).');

		return errors;
	}

	get passwordErrors() {
		const errors = [];

		if (!this.$v.password.$dirty) return errors;

		if (!this.$v.password.required) errors.push('Password is required.');

		if (!this.$v.password.minLength)
			errors.push(
				`Password must be at least ${this.$v.password.$params.minLength.min} characters.`
			);

		return errors;
	}

	get cPasswordErrors() {
		const errors = [];

		if (!this.$v.confirm_password.$dirty) return errors;

		if (!this.$v.confirm_password.sameAs)
			errors.push('This does not match the password field.');

		return errors;
	}
}
</script>
