import { MutationTree } from 'vuex';
import { CartState } from '@/store/cart/types';
import { Product } from '@/models/Product';
import { SecureStorage } from '@/utils/secure-storage';

const storage = SecureStorage.getInstance();

export const mutations: MutationTree<CartState> = {
	addItemToCart(state, product: Product) {
		state.items.push(product);
		storage.set('cartItems', state.items);
	},

	setCartEmpty(state) {
		state.items = [];
		storage.remove('cartItems');
	},
};
