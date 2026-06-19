import Layout from './Layout.vue'
import Home   from './Home.vue'
import Add    from './Add.vue'
import Edit   from './Edit.vue'

export const routes = {
    path: 'empleos',
    name: 'empleos',
    meta: {
        displayName: 'Empleos',
    },
    component: Layout,
    children: [
        {
            path: '',
            name: 'empleos-home',
            component: Home,
        },
        {
            path: 'add',
            name: 'empleos-add',
            component: Add,
        },
        {
            path: ':id/edit',
            name: 'empleos-edit',
            component: Edit,
        },
    ],
}