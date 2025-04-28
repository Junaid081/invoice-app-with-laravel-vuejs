import {createRouter, createWebHistory} from 'vue-router';
import InvoiceIndex from '../components/invoices/index.vue';
import NotFound from '../components/NotFound.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: InvoiceIndex
        },
        {
            path: '/:pathMatch(.*)*',
            name: 'not-found',
            component: NotFound
        }
    ]
})

export default router