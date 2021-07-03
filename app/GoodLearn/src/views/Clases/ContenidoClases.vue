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
            <ion-label class="ion-text-center" style="font-size: 120%; color: #0D2F58">{{curso.name}}</ion-label>
          </ion-item>
        </a>
      </ion-list>
      <ion-card>
    <ion-card-header>
      <ion-card-title class="ion-text-center">ASIGNATURAS</ion-card-title>
    </ion-card-header>

    <ion-card-content>
     <ion-list lines="full">
       <a
          v-for="asignatura in asignaturas"
          :key="asignatura.id"
          style="text-decoration: none"
        >
          <router-link
            :to="'/asignaturas?id=' + asignatura.asignatura_id.id + '&curso=' + asignatura.curso_id.id"
            style="text-decoration: none"
            ><ion-item>
              <ion-label class="ion-text-left" style="color: #0D2F58; font-size: 80%;">{{asignatura.asignatura_id.nombre}}</ion-label>
              <i class="material-icons" style="color: black">arrow_forward</i>
            </ion-item></router-link
          >
        </a>
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
            <ion-tab-button tab="Mensajes">
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
  IonCardTitle,
  IonCardHeader,
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
    IonCardTitle,
    IonCardHeader,
  },

  mounted() {
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
      const datos = JSON.parse(JSON.stringify(this.credentials));
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas_cursos')
      .then((response) => {
        const asignaturasCursos = [];
        for(let i = 0; i < Object.keys(response.data).length; i++){
          if(response.data[i].curso_id.id == this.$route.query.id){
            asignaturasCursos.push(response.data[i]);
          }
        }

        if(datos.usuario.rol_id.id != 2){
          this.asignaturas = asignaturasCursos;
        }else{
          const asignaturaProfesor: any[] = [];
          const auxAsignaturas = asignaturasCursos; 
          for(let i = 0; i < auxAsignaturas.length; i++){
            axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas/id/' + auxAsignaturas[i].asignatura_id.id)
            .then((response) => {
              if(response.data.usuario_id.id == datos.usuario.id){
                asignaturaProfesor.push(auxAsignaturas[i]);
              }
            });
          }
          this.asignaturas = asignaturaProfesor;
        }
      });
    } else {
      console.log("He entrado");
      this.credentials = {};
      this.$router.push("login");
    }
  },

  created() {
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/cursos/id/'+this.$route.query.id)
        .then((response) => {
          this.curso = response.data;
        });
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
      asignaturas: {},
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