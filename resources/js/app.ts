import '@babel/polyfill';
import Vue from 'vue';
import Vuex from 'vuex';
import '@/plugins/axios';
import vuetify from '@/plugins/vuetify';
import Dialog from '@/plugins/app-dialog';
import components from '@/components';
import store from '@/store';
import Vuelidate from 'vuelidate';
import { SecureStorage } from '@/utils/secure-storage';

Vue.use(Vuelidate);
Vue.use(Dialog);

Vue.config.productionTip = false;

window.Vue = Vue;

const VueApp: any = Vue;
const storage = SecureStorage.getInstance();

const app: Vue = new VueApp({
	vuetify,
	components,
	store,
	// render: (h: any) => h(App),
	data() {
		return {
			snackbar: true,
			drawer: true,
		};
	},
	methods: {
		logout() {
			storage.clear();
			this.$refs.logoutForm.submit();
		},
	},
});

app.$mount('#main-app');

Vuex.Store.prototype.$dialog = app.$dialog;
