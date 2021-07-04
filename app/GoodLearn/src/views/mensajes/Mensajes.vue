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

    <ion-content :fullscreen="true" style="text-align: center">
      <ion-list lines="full">
      <a
          style="text-decoration: none"
          v-for="usuario in agenda"
          :key="usuario.id"
        >
          <router-link v-if="credentials.usuario.id != usuario.id"
            :to="'/mensajes/chat?id='+ usuario.id"
            style="text-decoration: none"
            ><ion-item v-if="noLeido(mensajesRecibidos, usuario.id) == true">
              <ion-label style="font-size: 70%; font-weight: 700;">{{usuario.name}} - {{usuario.email}}</ion-label>
              <i class="material-icons" style="color: black">arrow_forward</i>
            </ion-item></router-link
          >
        </a>
        <a
          style="text-decoration: none"
          v-for="usuario in agenda"
          :key="usuario.id"
        >
          <router-link v-if="credentials.usuario.id != usuario.id"
            :to="'/mensajes/chat?id='+ usuario.id"
            style="text-decoration: none"
            ><ion-item>
              <ion-label v-if="noLeido(mensajesRecibidos, usuario.id) == false" style="font-size: 70%;">{{usuario.name}} - {{usuario.email}}</ion-label>
              <i class="material-icons" style="color: black">arrow_forward</i>
            </ion-item></router-link
          >
        </a>
      </ion-list>
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


import { send, person, school, home, add, chatbubbles } from "ionicons/icons";
import axios from "axios";
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
      this.credentials = {};
      this.$router.push("login");
    }
  },

  created() {
    localStorage.removeItem("reloadedComentario");
    const reloaded = localStorage.getItem("reloaded");
    console.log(reloaded);
    if (reloaded !== "true") {
      localStorage.setItem("reloaded", "true");
      location.reload();
    }
    console.log("Estamos en perfil");
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
      const data = JSON.parse(JSON.stringify(this.credentials));
      if(data.usuario.rol_id.id == 1){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios')
          .then((response) => {
            this.agenda = response.data;
          });
      }
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/mensajes/show?text='+data.usuario.id)
        .then((response) => {
          const recibido = [];
          for(let i = 0; i < Object.keys(response.data).length; i++){
            if(response.data[i].receptor_id == data.usuario.id && response.data[i].estado == 1){
              recibido.push(response.data[i].emisor_id.id);
            }
          }

          const senders = [ ...new Set(recibido) ]
          this.mensajesRecibidos = senders;

        });
    } else {
      this.credentials = {};
      this.$router.push("login");
    }
  },


  methods: {
    noLeido: function (noRead: any, id: any){
        for(let i = 0; i < noRead.length; i++){
          if(noRead == id){
            return true;
          }
        }
        return false;
      }
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      data: {},
      credentialStatus: {},
      credentials: {},
      publicaciones: {},
      agenda: {},
      mensajesRecibidos: {}
    };
  },
  setup() {
    return { send, person, school, home, add, chatbubbles };
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