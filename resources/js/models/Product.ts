import { Ingredient } from '@/models/Ingredient';

export class Product {
	constructor(
		public name: string,
		public unit_cost: number,
		public code?: string,
		public current_quantity?: number,
		public ingredients?: Ingredient[],
		// tslint:disable-next-line: trailing-comma
		public id: number = 0
	) {}
}
