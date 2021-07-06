<template>
  <ion-page>
    <ion-header :translucent="true">
      <ion-toolbar>
        <ion-title style="background: white; color: white"> d </ion-title>
        <img
          src="https://good-learn-jjrdb.ondigitalocean.app/img/logoLong.jpeg"
          alt=""
        />
      </ion-toolbar>
    </ion-header>
    
    <ion-fab vertical="top" horizontal="start" slot="fixed" v-if="lenghtNotificaciones > 0">
      <ion-fab-button>
        <ion-icon :icon="notifications"></ion-icon>
      </ion-fab-button>
      <ion-fab-list side="bottom">
        <ion-chip color="primary"
        v-for="notificacion in notificaciones"
        :key="notificacion.fecha_creacion">
          <ion-badge color="primary">{{notificacion.tipo_id.titulo}}</ion-badge>
        </ion-chip>
      </ion-fab-list>
    </ion-fab>

    <ion-content :fullscreen="true" style="text-align: center">
      <ion-card
        v-for="publicacion in publicaciones"
        :key="publicacion.fecha_creacion"
      >
        <img
          :src="
            'https://good-learn-jjrdb.ondigitalocean.app/publicaciones/' +
            publicacion.url_img
          "
          alt=""
        />
        <ion-card-header>
          <ion-card-subtitle>{{
            publicacion.usuario_id.name
          }}</ion-card-subtitle>
          <ion-card-title>{{ publicacion.titulo }}</ion-card-title>
        </ion-card-header>
        <ion-card-content>
          <router-link :to="'/comentarios?id=' + publicacion.id"
            ><ion-button expand="block" fill="outline" color="primary"
              ><ion-icon :icon="chatbubbles"></ion-icon></ion-button
          ></router-link>
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
            <ion-tab-button v-if="credentials.rol <= 2" tab="Post" href="/post">
              <router-link to="perfil"
                ><ion-button><ion-icon :icon="add"></ion-icon></ion-button
              ></router-link>
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
import { send, person, school, home, add, chatbubbles, notifications } from "ionicons/icons";
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
  IonCard,
  IonCardContent,
  IonCardSubtitle,
  IonCardTitle,
  IonCardHeader,
  IonFooter,
  IonButton,
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
    IonCard,
    IonCardContent,
    IonCardSubtitle,
    IonCardTitle,
    IonCardHeader,
    IonFooter,
    IonButton,
  },

  mounted() {
    axios
      .get("https://good-learn-jjrdb.ondigitalocean.app/api/publicaciones")
      .then((response) => {
        const orderPublicaciones = [];
        for (let i = Object.keys(response.data).length; i > 0; i--) {
          orderPublicaciones.push(response.data[i - 1]);
        }
        this.publicaciones = orderPublicaciones;
      });

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
      const notificaciones: any = [];
      if(data.usuario.rol_id.id < 4){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/notificaciones')
          .then((response) => {
            for(let i = 0; i < Object.keys(response.data).length; i++){
              if(response.data[i].usuario_id.id == data.usuario.id){
                notificaciones.push(response.data[i]);
              }
            }
            const cleanNotis = [ ...new Set(notificaciones) ];
            this.notificaciones = cleanNotis;
            this.lenghtNotificaciones = cleanNotis.length;
          });
      }

      if(data.usuario.rol_id.id == 4){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/notificaciones')
          .then(async (response) => {
            for(let i = 0; i < Object.keys(response.data).length; i++){
              if(response.data[i].usuario_id.id == data.usuario.id){
                notificaciones.push(response.data[i]);
              }
            }
            await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/padres')
              .then(async (response) => {
                const hijos: any = [];
                for(let i = 0; i < Object.keys(response.data).length; i++){
                  if(response.data[i].padre_id.id == data.usuario.id){
                    hijos.push(response.data[i].alumno_id);
                  }
                }
                
                for(let i = 0; i < hijos.length; i++){
                  await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/notificaciones')
                    .then((response) => {
                      for(let j = 0; j < Object.keys(response.data).length; j++){
                        if(response.data[j].usuario_id.id == hijos[i].id){
                          notificaciones.push(response.data[j]);
                        }
                      }
                    });
                }
              });
              const cleanNotis = [ ...new Set(notificaciones) ];
              this.notificaciones = cleanNotis;
              this.lenghtNotificaciones = cleanNotis.length;
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
      publicaciones: {},
      notificaciones: {},
      lenghtNotificaciones: 0,
    };
  },
  setup() {
    return { send, person, school, home, add, chatbubbles, notifications };
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