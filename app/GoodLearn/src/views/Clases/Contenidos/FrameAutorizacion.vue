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
      
      <ion-list lines="full">
        <a
          @click="$router.go(-1)"
          style="text-decoration: none"
        >
          <ion-item>
            <i class="material-icons" style="color: black">arrow_back</i>
            <ion-label class="ion-text-center" style="font-size: 120%; color: #0D2F58">{{$route.query.name}}</ion-label>
          </ion-item>
        </a>
      </ion-list>

      <ion-list lines="full" v-if="credentials.usuario.rol_id.id <= 2">
        <a
          style="text-decoration: none"
        >
          <router-link
            :to="'/asignaturas/autorizacion/content/alumnos?name=' + $route.query.name"
            style="text-decoration: none"
            ><ion-item>
              <ion-label>Alumnos</ion-label>
              <i class="material-icons" style="color: black">arrow_forward</i>
            </ion-item></router-link
          >
        </a>
      </ion-list>

      <ion-list lines="full" v-if="credentials.usuario.rol_id.id > 2">
              <ion-button expand="block" @click="editar('1', autorizacion.id)" fill="outline" v-if="autorizacion.estado == 0" color="primary"
              >Aceptar</ion-button>
          <ion-button expand="block" @click="editar('0', autorizacion.id)" fill="outline" v-if="autorizacion.estado == 1" color="danger"
              >Cancelar</ion-button>
      </ion-list>

      <embed
        :src="'https://good-learn-jjrdb.ondigitalocean.app/autorizaciones/'+$route.query.name"
        type="application/pdf"
        width="100%"
        height="100%"
      />
      
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
      if(data.usuario.rol_id.id > 2){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/autorizaciones/id/'+ this.$route.query.id)
          .then((response) => {
            console.log(response.data);
            this.autorizacion = response.data;
          });
      }
    } else {
      this.credentials = {};
      this.$router.push("login");
    }
  },

  methods: {
    editar: async function (estado: any, autorizacion: any){
      const url = 'https://good-learn-jjrdb.ondigitalocean.app/api/autorizacion/'+autorizacion;
      console.log(url);
      axios.put(url, {'estado': estado})
        .then((response) => {
          console.log(response.data);
          location.reload()
        });
    }
  },
  data() {
    return {
      data: {},
      credentialStatus: {},
      credentials: {},
      autorizacion: {},
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