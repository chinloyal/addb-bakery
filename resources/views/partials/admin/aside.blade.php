<v-list-item href="{{ route('admin.employees') }}">
	<v-list-item-action>
		<v-icon>mdi-briefcase-account</v-icon>
	</v-list-item-action>
	<v-list-item-content>
		<v-list-item-title>Manage Employees</v-list-item-title>
	</v-list-item-content>
</v-list-item>
<v-list-item href="{{ route('employee.products') }}">
	<v-list-item-action>
		<v-icon>mdi-cupcake</v-icon>
	</v-list-item-action>
	<v-list-item-content>
		<v-list-item-title>Manage Products</v-list-item-title>
	</v-list-item-content>
</v-list-item>
<v-list-item href="{{ route('employee.ingredients') }}">
	<v-list-item-action>
		<v-icon>mdi-grain</v-icon>
	</v-list-item-action>
	<v-list-item-content>
		<v-list-item-title>Manage Ingredients</v-list-item-title>
	</v-list-item-content>
</v-list-item>
