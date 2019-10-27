<template>
	<v-data-table
		:headers="headers"
		:items="items"
		:search="search"
		v-model="selected"
		item-key="name"
		select-all
		class="elevation-1"
	>
		<template slot="headerCell" slot-scope="props">
			<v-tooltip bottom>
				<span slot="activator">
					{{ props.header.text }}
				</span>
				<span>
					{{ props.header.text }}
				</span>
			</v-tooltip>
		</template>
		<template slot="items" slot-scope="props">
			<td>
				<v-checkbox
					primary
					hide-details
					v-model="props.selected"
				></v-checkbox>
			</td>
			<td>{{ props.item.key }}</td>
			<td class="text-xs-right">{{ props.item.key }}</td>
			<td class="text-xs-right">{{ props.item.key }}</td>
			<td class="text-xs-right">{{ props.item.key }}</td>
			<td class="text-xs-right">{{ props.item.key }}</td>
			<td class="text-xs-right">{{ props.item.key }}</td>
		</template>
	</v-data-table>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class EmployeeTable extends Vue {}
</script>
