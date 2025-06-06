import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/vue',
            name: 'App',
            component: () => import('./components/App.vue'),
            children: [
                {
                    path: 'products',
                    name: 'Products',
                    component: () => import('./components/pages/Product.vue')
                },
                {
                    path: 'categories',
                    name: 'Categories',
                    component: () => import('./components/pages/ProductCategory.vue')
                },
            ]
        },
    ]
});

export default router;
