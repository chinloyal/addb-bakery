import { Order } from '@/models/Order';
import { Product } from '@/models/Product';

export class EmployeeOrder extends Order {
	constructor(
		public delivery_date: Date,
		public cost: number,
		public gct: number,
		public customer_name: string,
		public status?: boolean,
		public products?: Product[],
		public id: number = 0 // tslint:disable-line: trailing-comma
	) {
		super(delivery_date, cost, gct, status, products, id);
	}
}
