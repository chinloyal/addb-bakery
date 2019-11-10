import { ActionTree } from 'vuex';
import { RootState } from '@/store/types';
import { CartState } from '@/store/cart/types';
import { Product } from '@/models/Product';
import axios from 'axios';

export const actions: ActionTree<CartState, RootState> = {
	addToCart({ commit }, product: Product) {
		commit('addItemToCart', product);
	},

	placeOrder({ getters, dispatch, commit }) {
		const dialog = this.$dialog;
		const store = this;
		commit('setLoading', 'info');

		axios
			.post('/api/order/place', getters.request)
			.then(res => {
				dialog.show({
					title: 'Order Placed',
					message: 'Your order has been placed success fully.',
				});

				dispatch('emptyCart');
				store.commit('setCartMenu', false);
				commit('setLoading', false);
			})
			.catch(err => {
				const message =
					err.response.data.message || 'Unable to place order';

				dialog.show({
					title: 'Error',
					message,
					dialogType: 'error',
				});
				commit('setLoading', false);
			});
	},

	emptyCart({ commit }) {
		commit('setCartEmpty');
	},
};
