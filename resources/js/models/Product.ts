export class Product {
	constructor(
		public code: string,
		public name: string,
		public current_quantity: number,
		public unit_cost: number,
		// tslint:disable-next-line: trailing-comma
		public id: number = 0
	) {}
}
