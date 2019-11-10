import { Module } from 'vuex';
import { CartState } from '@/store/cart/types';
import { RootState } from '@/store/types';
import { SecureStorage } from '@/utils/secure-storage';
import { actions } from '@/store/cart/actions';
import { getters } from '@/store/cart/getters';
import { mutations } from '@/store/cart/mutations';

const namespaced: boolean = true;
const storage = SecureStorage.getInstance();

export const state: CartState = {
	items: storage.get('cartItems') || [],
	loading: false,
};

export const cart: Module<CartState, RootState> = {
	namespaced,
	state,
	actions,
	getters,
	mutations,
};
