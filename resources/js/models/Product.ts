export class Product {
	constructor(
		public code: string,
		public name: string,
		public current_quantity: number,
		public unit_cost: number,
		public id: number = 0
	) {}
}
