import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import Home from '../views/Home.vue'
import Clases from '../views/Clases.vue'
import Perfil from '../views/Perfil.vue'
import Login from '../views/Login.vue'
import Comentarios from '../views/Comentarios.vue'

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/home',
    name: 'Home',
    component: Home
  },
  {
    path: '/clases',
    name: 'Clases',
    component: Clases
  },
  {
    path: '/perfil',
    name: 'Perfil',
    component: Perfil
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/comentarios',
    name: 'Comentarios',
    component: Comentarios
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
