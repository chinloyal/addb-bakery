import Vue, { VueConstructor } from 'vue';
import { AxiosInstance } from '$axios';

declare global {
	interface Window {
		axios: AxiosInstance;
		Vue: any;
	}
}

declare module 'vue/types/vue' {
	interface Vue {
		$axios: AxiosInstance;
	}
	interface VueConstructor {
		$axios: AxiosInstance;
	}
}
