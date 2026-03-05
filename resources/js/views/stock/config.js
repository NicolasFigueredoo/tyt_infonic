import Layout from './Layout.vue'
import Home   from './Home.vue'
import Show   from './Show.vue'

export const routes = {
    path: '/stock',
    name: 'stock',
    meta: {
        displayName: 'Stock',
    },
    component: Layout,
    children: [
        {
            path: '',
            name: 'stock-home',
            component: Home
        },
        {
            path: ':id/show',
            component: Show,
            meta: {
                displayName: 'Ver'
            }
        },
    ],
}