// Vuex structure based on https://codeburst.io/vuex-and-typescript-3427ba78cfa8
import Vue from 'vue';
import Vuex, { StoreOptions } from 'vuex';
import { RootState } from '@/store/types';
import { mutations } from '@/store/mutations';
import { cart } from '@/store/cart/index';

Vue.use(Vuex);

const store: StoreOptions<RootState> = {
	state: {
		version: '1.0.0',
		cartMenu: false,
	},
	mutations,
	modules: {
		cart,
	},
};

export default new Vuex.Store(store);
