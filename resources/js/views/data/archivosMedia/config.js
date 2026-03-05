import Layout from './Layout.vue'
import Home   from './Home.vue'
import Add    from './Add.vue'
import Edit   from './Edit.vue'

export const routes = {
    path:      'archivosmedia',
    component: Layout,
    children: [
        { path: '',         component: Home },
        { path: 'add',      component: Add  },
        { path: ':id/edit', component: Edit },
    ],
}