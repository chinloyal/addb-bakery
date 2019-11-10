import { Product } from '@/models/Product';

export interface CartState {
	items: Product[];
	loading: boolean | string;
}
