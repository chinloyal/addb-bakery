export class User {
	constructor(
		public first_name: string,
		public last_name: string,
		public email: number,
		// tslint:disable-next-line: trailing-comma
		public id: number = 0
	) {}
}
