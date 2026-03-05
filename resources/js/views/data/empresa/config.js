import Layout from './Layout.vue'
import Home   from './Home.vue'
import Add    from './Add.vue'
import Edit   from './Edit.vue'

import HomeSlider   from './HomeSlider.vue'
import AddSlider    from './AddSlider.vue'
import EditSlider   from './EditSlider.vue'

export const routes = {
    path: '/adm/empresa',
    component: Layout,
    meta: {
        displayName: 'Empresa',
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
        },
        {
            path: 'slider',
            component: HomeSlider
        },
        {
            path: 'slider/add',
            component: AddSlider,
            meta: {
                displayName: 'Agregar'
            }
        },
        {
            path: 'slider/:id/edit',
            component:EditSlider,
            meta: {
                displayName: 'Editar'
            }
        },
        {
            path: 'slider/:id/copy',
            component:EditSlider,
            meta: {
                displayName: 'Agregar',
                copy: true
            }
        }
    ]
}