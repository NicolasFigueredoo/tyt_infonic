import Layout from './Layout.vue'
import Home   from './Home.vue'
import HomePedidos   from './HomePedidos.vue'
import HomeReferrer from './HomeReferrer.vue'

export const routes = {
    path: '/adm/metricas',
    component: Layout,
    meta: {
        displayName: 'metricas',
    },
    children: [
        {
            path: '',
            component: Home
        },
        {
            path: 'pedidos',
            component: HomePedidos
        },
        {
            path: 'referrer',
            component: HomeReferrer
        },
    ]
}