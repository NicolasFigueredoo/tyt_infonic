import Layout from './Layout.vue'
import Home   from './Home.vue'
import Add    from './Add.vue'
import Edit   from './Edit.vue'

export const routes = {
    path: '/adm/clientestemp',
    component: Layout,
    meta: {
        displayName: 'Clientestemp',
    },
    children: [
        {
            path: '',
            component: Home
        },
        {
            path: 'add',
            component: Add,
            meta: {
                displayName: 'Agregar'
            }
        },
        {
            path: ':id/edit',
            component:Edit,
            meta: {
                displayName: 'Editar'
            }
        },
        {
            path: ':id/copy',
            component:Edit,
            meta: {
                displayName: 'Agregar',
                copy: true
            }
        }
    ]
}