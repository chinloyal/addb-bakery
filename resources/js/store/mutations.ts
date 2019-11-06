import { MutationTree } from 'vuex';
import { RootState } from '@/store/types';

export const mutations: MutationTree<RootState> = {
	setCartMenu(state, value) {
		state.cartMenu = value;
	},
};
