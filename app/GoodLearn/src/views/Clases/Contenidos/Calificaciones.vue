<template>
  <ion-page>
    <ion-header :translucent="true">
      <link
        href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet"
      />
      <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous"
      />
      <ion-toolbar>
        <ion-title style="background: white; color: white"> d </ion-title>
        <img
          src="https://good-learn-jjrdb.ondigitalocean.app/img/logoLong.jpeg"
          alt=""
        />
      </ion-toolbar>
    </ion-header>

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Blank</ion-title>
        </ion-toolbar>
      </ion-header>

      <!-- List Full Lines -->
      <ion-list lines="full">
        <a
          @click="$router.go(-1)"
          style="text-decoration: none"
        >
          <ion-item>
            <i class="material-icons" style="color: black">arrow_back</i>
            <ion-label class="ion-text-center" style="font-size: 120%; color: #0D2F58">Calificaciones</ion-label>
          </ion-item>
        </a>
      </ion-list>
      <ion-card>

    <ion-card-content>
     <ion-list lines="full" v-if="credentials.usuario.rol_id.id <= 2">
      <a
          v-for="alumno in alumnos"
          :key="alumno.id"
          style="text-decoration: none"
        >
          <router-link
            :to="'/asignaturas/calificacion/content/alumno?id='+alumno.usuario_id.id+'&asignatura='+$route.query.id"
            style="text-decoration: none"
            ><ion-item>
              <ion-label style="font-size: 70%;">{{alumno.usuario_id.name}} - {{alumno.usuario_id.email}}</ion-label>
              <i class="material-icons" style="color: black">arrow_forward</i>
            </ion-item></router-link
          >
        </a>
      </ion-list>

      <ion-list lines="full" v-if="credentials.usuario.rol_id.id > 2">
      <ion-card
        v-for="nota in notas"
        :key="nota.fecha_creacion"
      >
        <ion-card-header>
          <ion-card-title>{{ nota.titulo }}</ion-card-title>
          <ion-card-subtitle>{{
            nota.cuerpo
          }}</ion-card-subtitle>
        </ion-card-header>
        <ion-card-content>
          <ion-button expand="block" fill="outline" color="primary">{{nota.nota}}</ion-button>
        </ion-card-content>
      </ion-card>
      </ion-list>
    </ion-card-content>
  </ion-card>
      
    </ion-content>

    <ion-footer>
      <ion-toolbar>
        <ion-tabs v-if="credentials">
          <!-- Tab bar -->
          <ion-tab-bar slot="bottom">
            <ion-tab-button tab="Home" href="/home">
              <ion-icon :icon="home"></ion-icon>
            </ion-tab-button>
            <ion-tab-button tab="Clases" href="/clases">
              <ion-icon :icon="school"></ion-icon>
            </ion-tab-button>
            <ion-tab-button tab="Mensajes" href="/mensajes">
              <ion-icon :icon="send"></ion-icon>
            </ion-tab-button>
            <ion-tab-button tab="Perfil" href="/perfil">
              <ion-icon :icon="person"></ion-icon>
            </ion-tab-button>
          </ion-tab-bar>
        </ion-tabs>
      </ion-toolbar>
    </ion-footer>
  </ion-page>
</template>

<script lang="ts">
import { send, person, school, home, star } from "ionicons/icons";

import {
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,
  IonIcon,
  IonTabBar,
  IonTabButton,
  IonTabs,
  IonFooter,
  IonLabel,
  IonItem,
  IonList,
  IonCard,
  IonCardContent,
} from "@ionic/vue";
import { defineComponent } from "vue";
import axios from "axios";

export default defineComponent({
  name: "Home",
  components: {
    IonContent,
    IonHeader,
    IonPage,
    IonTitle,
    IonToolbar,
    IonIcon,
    IonTabBar,
    IonTabButton,
    IonTabs,
    IonFooter,
    IonLabel,
    IonItem,
    IonList,
    IonCard,
    IonCardContent,
  },

  mounted() {
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
    } else {
      console.log("He entrado");
      this.credentials = {};
      this.$router.push("login");
    }
  },

  created() {
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
      const data = JSON.parse(JSON.stringify(this.credentials));
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas/id/'+this.$route.query.id)
        .then((response) => {
          this.asignatura = response.data;
        });
      if(data.usuario.rol_id.id <= 2){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas_cursos')
          .then((response) => {
            let cursoId: any;
            for(let i = 0; i < Object.keys(response.data).length; i++){
              if(response.data[i].asignatura_id.id == this.$route.query.id){
                cursoId = response.data[i].curso_id.id;
              }
            }
            console.log(cursoId);
            axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/cursos_alumnos/show?text='+cursoId)
              .then((response) => {
                const Alumnos = [];
                for(let i = 0; i < Object.keys(response.data).length; i++){
                  if(response.data[i].curso_id.id == cursoId){
                    Alumnos.push(response.data[i]);
                    this.alumnos = Alumnos;
                  }
                }
              });
          });
      }else{
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/notas/show?text='+this.$route.query.id)
        .then((response) => {
          const notas = [];
          for(let i = 0; i < Object.keys(response.data).length; i++){
            if(response.data[i].usuario_id.id == data.usuario.id){
              notas.push(response.data[i]);
            }
          }
          this.notas = notas;
        });
      }
    } else {
      this.credentials = {};
      this.$router.push("login");
    }
  },

  methods: {},
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      data: {},
      credentialStatus: {},
      credentials: {},
      curso: {},
      asignatura: {},
      alumnos: {},
      notas: {},
    };
  },
  setup() {
    return { send, person, school, home, star };
  },
});
</script>

<style scoped>
#container {
  text-align: center;

  position: absolute;
  left: 0;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}

#container strong {
  font-size: 20px;
  line-height: 26px;
}

#container p {
  font-size: 16px;
  line-height: 22px;

  color: #8c8c8c;

  margin: 0;
}

#container a {
  text-decoration: none;
}
</style>