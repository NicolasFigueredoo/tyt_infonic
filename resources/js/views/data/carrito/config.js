import Layout from './Layout.vue'
import Home   from './Home.vue'
import Edit   from './Edit.vue'

export const routes = {
    path: '/adm/carrito',
    component: Layout,
    meta: {
        displayName: 'Carrito',
    },
    children: [
        {
            path: '',
            component: Home
        },        
        {
            path: 'edit',
            component:Edit,
            meta: {
                displayName: 'Editar'
            }
        }        
    ]
}