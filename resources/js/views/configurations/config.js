import Layout from './Layout.vue'
import Home   from './Home.vue'
import { routes as permissionRoutes } from '../permission/config'
import { routes as groupRoutes } from '../group/config'
import { routes as userRoutes } from '../user/config'

export const routes = {
    path: '/configurations',
    name: 'configurations',
    meta: {
        displayName: 'Configuraciones',
    },
    component: Layout,
    children: [
        {
            path: '',
            name: 'configurations-home',
            component: Home
        },
        permissionRoutes,
        groupRoutes,
        userRoutes,
    ],
}