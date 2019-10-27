export class Ingredient {
	constructor(
		public name: string,
		public measurement_unit: string,
		public current_quantity: number,
		public id: number = 0,
		public reorder_level: string = ''
	) {}
}
