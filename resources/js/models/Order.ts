import { Product } from '@/models/Product';

export class Order {
	constructor(
		public delivery_date: Date,
		public cost: number,
		public gct: number,
		public status?: boolean,
		public products?: Product[],
		public id: number = 0 // tslint:disable-line: trailing-comma
	) {}
}
