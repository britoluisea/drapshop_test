import { createRouter, createWebHistory } from "vue-router";
import home from "../views/home.vue";
import account from "../views/account.vue";
import security from "../views/security.vue";
import customer from "../views/customer.vue";
import sales from "../views/sales.vue";

const routes = [
	{
		path: '/',
		name: 'home',
		component: home,
	},
	{
		path: '/home',
		name: 'home',
		component: home,
	},
	{
		path: '/account',
		name: 'account',
		component: account,
	},
	{
		path: '/security',
		name: 'security',
		component: security,
	},
	{
		path: '/customer',
		name: 'customer',
		component: customer,
	},
	{
		path: '/sales',
		name: 'sales',
		component: sales,
	},
]; 
const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes
});

export default router;