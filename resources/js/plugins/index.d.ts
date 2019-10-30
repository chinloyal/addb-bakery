import Vue, { VueConstructor } from 'vue';
import { AxiosInstance } from '$axios';
import { AppDialogInstance } from './types';

declare global {
	interface Window {
		axios: AxiosInstance;
		Vue: any;
	}
}

declare module 'vue/types/vue' {
	interface Vue {
		$axios: AxiosInstance;
		$dialog: AppDialogInstance;
	}
	interface VueConstructor {
		$axios: AxiosInstance;
		$dialog: AppDialogInstance;
	}
}
