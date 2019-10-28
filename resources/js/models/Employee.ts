import { User } from '@/models/User';

export class Employee {
	constructor(
		public trn: string,
		public address: string,
		public user: User,
		// tslint:disable-next-line: trailing-comma
		public id: number = 0
	) {}
}
