import Layout from './Layout.vue'
import Home   from './Home.vue'
import Edit   from './Edit.vue'

export const routes = {
    path: '/adm/modal',
    component: Layout,
    meta: {
        displayName: 'Modal',
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