import Layout from './Layout.vue'
import Home   from './Home.vue'
import Add    from './Add.vue'
import UpdateProducts from './UpdateProducts.vue'
import Edit   from './Edit.vue'

export const routes = {
    path: '/adm/articulo',
    component: Layout,
    meta: {
        displayName: 'Articulos',
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
            path: 'updateProducts',
            component: UpdateProducts,
            meta: {
                displayName: 'updateProducts'
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