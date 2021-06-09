import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import dasshboard from '../views/dasshboard.vue'
import password from "../views/password";
import corporativos from "../views/corpsInfo";
import parques from '../views/parkInfo'
import nave from '../views/naveInfo'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path:'/dasshboard',
    name:'dasshboard',
    component:dasshboard
  },
  {
    path: '/corporativos',
    name: 'corporativos',
    component: corporativos
  },
  {
    path: '/password',
    name: 'password',
    component: password
  },
  {
    path: '/parque',
    name: 'parque',
    component: parques
  },
  {
    path: '/nave',
    name: 'nave',
    component: nave
  },
]

const router = new VueRouter({
  base: process.env.BASE_URL,
  routes
})

export default router
