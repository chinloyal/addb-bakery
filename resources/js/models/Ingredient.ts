export class Ingredient {
	constructor(
		public name: string,
		public measurement_unit: string,
		public current_quantity: number,
		public id: number = 0,
		// tslint:disable-next-line: trailing-comma
		public reorder_level: string = ''
	) {}
}
