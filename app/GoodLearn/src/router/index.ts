import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';
import Home from '../views/Home.vue'
import Clases from '../views/Clases/Clases.vue'

import Mensajes from '../views/mensajes/Mensajes.vue'
import Chat from '../views/mensajes/Chat.vue'

import Contenidos from '../views/Clases/Contenidos/Contenidos.vue'
import FrameContenido from '../views/Clases/Contenidos/FrameContenido.vue'

import Calificaciones from '../views/Clases/Contenidos/Calificaciones.vue'
import AlumnoCalificacion from '../views/Clases/Contenidos/AlumnoCalificacion.vue'

import Autorizaciones from '../views/Clases/Contenidos/Autorizaciones.vue'
import FrameAutorizacion from '../views/Clases/Contenidos/FrameAutorizacion.vue'
import AutorizacionesAlumnos from '../views/Clases/Contenidos/AutorizacionesAlumnos.vue'

import Asistencias from '../views/Clases/Contenidos/Asistencias.vue'
import AlumnoAsistencias from '../views/Clases/Contenidos/AlumnoAsistencias.vue'

import Asignaturas from '../views/Clases/Asignaturas.vue'
import ContenidoClases from '../views/Clases/ContenidoClases.vue'
import Perfil from '../views/Perfil.vue'
import Login from '../views/Login.vue'
import Comentarios from '../views/Comentarios.vue'

import Post from '../views/Post.vue'

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
    path: '/post',
    name: 'Post',
    component: Post
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
    path: '/asignaturas/autorizacion/content',
    name: 'FrameAutorizacion',
    component: FrameAutorizacion
  },
  {
    path: '/asignaturas/calificacion',
    name: 'Calificaciones',
    component: Calificaciones
  },
  {
    path: '/asignaturas/calificacion/content/alumno',
    name: 'AlumnoCalificacion',
    component: AlumnoCalificacion
  },
  {
    path: '/asignaturas/autorizacion/content/alumnos',
    name: 'AutorizacionesAlumnos',
    component: AutorizacionesAlumnos
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
    path: '/asignaturas/asistencia/alumno',
    name: 'AlumnoAsistencias',
    component: AlumnoAsistencias
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
  {
    path: '/mensajes',
    name: 'Mensajes',
    component: Mensajes
  },
  {
    path: '/mensajes/chat',
    name: 'Chat',
    component: Chat
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
