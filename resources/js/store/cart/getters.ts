import { GetterTree } from 'vuex';
import { RootState } from '@/store/types';
import { CartState } from '@/store/cart/types';
import { Product } from '@/models/Product';

export const getters: GetterTree<CartState, RootState> = {
	items: state => state.items,
	count: state => state.items.length,
	inCart: state => (product: Product) => {
		const result = state.items.find(prod => {
			return prod.id === product.id;
		});

		if (result === undefined) {
			return false;
		}

		return true;
	},
	request: state =>
		state.items.map((product: Product) => {
			return product.id;
		}),
};
