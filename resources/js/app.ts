import '@babel/polyfill';
import Vue from 'vue';
import '@/plugins/axios';
import vuetify from '@/plugins/vuetify';
// import App from '@/App.vue';
import components from '@/components';
import store from '@/store';
import Vuelidate from 'vuelidate';

Vue.use(Vuelidate);

Vue.config.productionTip = false;

window.Vue = Vue;

const VueApp: any = Vue;

new VueApp({
	store,
	vuetify,
	components,
	// render: (h: any) => h(App),
	data() {
		return {
			snackbar: true,
			drawer: true,
		};
	},
	methods: {
		logout() {
			this.$refs.logoutForm.submit();
		},
	},
}).$mount('#main-app');
