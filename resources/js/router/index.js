import { createRouter, createWebHistory } from 'vue-router'
import HomeView  from '../views/HomeView.vue'
import Login     from '../views/login/Home.vue'
import Upload     from '../views/upload/Home.vue'
import NotFound from '../views/NotFound.vue'
import { routes as configurationsRoutes } from '../views/configurations/config'
import { routes as dataRoutes } from '../views/data/main/config'
import { routes as stockRoutes } from '../views/stock/config'

window.base_url = document.head.querySelector('meta[name="base-url"]')
if (window.base_url) {
    window.base_url = window.base_url.content.replace(/\/$/, '')
} else {
    window.base_url = ''
}

const router = createRouter({
  history: createWebHistory(window.base_url + '/'),
  // history: createWebHistory('/osole/habasit/public/'),
  routes: [
    {
      path: '/adm',
      name: 'home',
      component: HomeView
    },
    {
      path: '/adm/login',
      name: 'login',
      component: Login
    },
    {
      path: '/adm/upload',
      name: 'upload',
      component: Upload
    },
    configurationsRoutes,
    dataRoutes,
    stockRoutes,
    {
      // path: "*",
      path: "/adm/:catchAll(.*)",
      name: "NotFound",
      component: NotFound,
    }
  ]
})
router.afterEach((to, from) => {
  // console.log('afterEach', to, from)
    if ( window.$globalState.sidebar.position.value == 'side-bar__wrapper--absolute' ) {
      // console.log('va a cerrar')
      // console.log(window.$globalState.sidebar.show.value)
      window.$globalState.sidebar.show.value = 'side-bar__wrapper--hide'
      // console.log(window.$globalState.sidebar.show.value)
    }
})
export default router
