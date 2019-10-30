export class Order {
	constructor(
		public delivery_date: Date,
		public cost: number,
		public gct: number,
		public employee_name: string,
		public id: number = 0 // tslint:disable-line: trailing-comma
	) {}
}
