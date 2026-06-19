import Layout from './Layout.vue'
import Home   from './Home.vue'

export const routes = {
    path: 'postulaciones',
    name: 'postulaciones',
    meta: {
        displayName: 'CVs Recibidos',
    },
    component: Layout,
    children: [
        {
            path: '',
            name: 'postulaciones-home',
            component: Home,
        },
    ],
}