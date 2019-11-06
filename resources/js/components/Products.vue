<template>
	<v-row>
		<v-col md="3" v-for="product in products" :key="product.id">
			<v-card>
				<v-card-title>
					{{ product.name }}
				</v-card-title>
				<v-card-subtitle> ${{ product.unit_cost }} </v-card-subtitle>
				<v-divider></v-divider>
				<v-card-actions>
					<v-btn v-if="inCart(product)" disabled text>
						<v-icon>mdi-plus</v-icon>
						Added
					</v-btn>
					<v-btn v-else color="info" text @click="addToCart(product)">
						<v-icon>mdi-plus</v-icon>
						Add to Cart
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-col>
	</v-row>
</template>
<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, Getter } from 'vuex-class';
import { Product } from '@/models/Product';
import axios from 'axios';
import { SecureStorage } from '@/utils/secure-storage';

@Component
export default class Products extends Vue {
	private products: Array<Product> = [];

	created() {
		this.init();
	}

	init() {
		const vm = this;

		axios
			.get('api/products')
			.then(res => {
				vm.products = res.data;
			})
			.catch(err => {
				let message =
					err.response.data.message || 'Unable to load products.';

				vm.$dialog.show({
					title: 'Error',
					message,
				});
			});
	}

	@Action('addToCart', { namespace: 'cart' })
	private addToCart: Function;

	@Getter('inCart', { namespace: 'cart' })
	inCart: any;
}
</script>
