import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import Home from '../views/Home.vue'
import Clases from '../views/Clases/Clases.vue'

import Contenidos from '../views/Clases/Contenidos/Contenidos.vue'
import FrameContenido from '../views/Clases/Contenidos/FrameContenido.vue'

import Calificaciones from '../views/Clases/Contenidos/Calificaciones.vue'
import Autorizaciones from '../views/Clases/Contenidos/Autorizaciones.vue'
import Asistencias from '../views/Clases/Contenidos/Asistencias.vue'

import Asignaturas from '../views/Clases/Asignaturas.vue'
import ContenidoClases from '../views/Clases/ContenidoClases.vue'
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
    path: '/clases/contenido',
    name: 'ContenidoClases',
    component: ContenidoClases
  },
  {
    path: '/asignaturas',
    name: 'Asignaturas',
    component: Asignaturas
  },
  {
    path: '/asignaturas/contenido',
    name: 'Contenidos',
    component: Contenidos
  },
  {
    path: '/asignaturas/contenido/content',
    name: 'FrameContenido',
    component: FrameContenido
  },
  {
    path: '/asignaturas/calificacion',
    name: 'Calificaciones',
    component: Calificaciones
  },
  {
    path: '/asignaturas/autorizacion',
    name: 'Autorizaciones',
    component: Autorizaciones
  },
  {
    path: '/asignaturas/asistencia',
    name: 'Asistencias',
    component: Asistencias
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
