<template>
  <ion-page>
    <ion-header :translucent="true">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            <ion-label class="ion-text-center" style="font-size: 120%; color: #0D2F58">{{receptor.name}}</ion-label>
          </ion-item>
        </a>
      </ion-list>
      <ion-card v-for="mensaje in conversacion"
        :key="mensaje.fecha_creacion">
        <ion-card-header>
          <ion-card-title>{{mensaje.texto}}</ion-card-title>
        </ion-card-header>
        <ion-card-content
          ><ion-card-subtitle>{{mensaje.emisor_id.name}}</ion-card-subtitle>
        </ion-card-content>
        <div class="btn-group d-flex align-items-end" v-if="credentials.rol == 1 || credentials.usuario.id == mensaje.emisor_id.id">
          <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="material-icons" style="color: black">more_horiz</i>
          </button>
          <ul class="dropdown-menu">
            <a class="dropdown-item" style="color: red" v-on:click="eliminar(mensaje.id)">Eliminar</a>
          </ul>
        </div>
        
      </ion-card>
    </ion-content>
    <ion-footer>
      <form @submit.prevent="mensaje" method="POST">
        <ion-item>
          <ion-label position="floating">Mensaje</ion-label>
          <ion-input
            name="texto"
            v-model="form.texto"
            id="texto"
            type="text"
            required
          ></ion-input>
        </ion-item>

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
              <ion-tab-button tab="Clases">
                <ion-button type="submit"
                  ><ion-icon :icon="add"></ion-icon
                ></ion-button>
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
      </form>
    </ion-footer>
  </ion-page>
</template>
<script lang="ts">
import { send, person, school, home, add } from "ionicons/icons";

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
  IonButton,
  IonItem,
  IonInput,
  IonLabel,
  IonCardContent,
  IonCard,
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
    IonButton,
    IonItem,
    IonInput,
    IonLabel,
    IonCardContent,
    IonCard,
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
    localStorage.removeItem("reloaded");
    const reloaded = localStorage.getItem("reloadedComentario");
    console.log(reloaded);
    if (reloaded !== "true") {
      localStorage.setItem("reloadedComentario", "true");
      location.reload();
    }
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
      const data = JSON.parse(JSON.stringify(this.credentials));
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios/id/'+this.$route.query.id)
        .then((response) => {
          this.receptor = response.data;
        });
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/mensajes/show?text='+data.usuario.id)
        .then((response) => {
          const conversacion = [];
          for (let i = 0; i < Object.keys(response.data).length; i++){
            if(response.data[i].emisor_id.id == data.usuario.id && response.data[i].receptor_id.id == this.$route.query.id){
              conversacion.push(response.data[i]);
            }
            if(response.data[i].receptor_id.id == data.usuario.id && response.data[i].emisor_id.id == this.$route.query.id){
              conversacion.push(response.data[i]);
            }
          }
          this.conversacion = conversacion;
          console.log(this.conversacion);
          this.leer(this.conversacion);
        });
    } else {
      this.credentials = {};
      this.$router.push("login");
    }
  },

  methods: {
    mensaje: async function () {
      axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
      const datos = JSON.parse(JSON.stringify(this.credentials));
      const postQuery = {
        'emisor_id': datos.usuario.id,
        'receptor_id': this.$route.query.id,
        'texto': this.form.texto,
      };
      console.log(postQuery);
      await axios.post(
        "https://good-learn-jjrdb.ondigitalocean.app/api/mensaje",
        postQuery,
        {
          headers: {
            Accept: "application/json",
          },
        }
      ).then((response) => location.reload());
      
    },

    eliminar: async function(id: any){
      await axios.delete(
        "https://good-learn-jjrdb.ondigitalocean.app/api/mensaje/"+id,
        {
          headers: {
            Accept: "application/json",
          },
        }
      );
      location.reload();
    },

    leer: async function(conversacion: any){
      const data = JSON.parse(JSON.stringify(this.credentials));
      const lectura = {
        estado: 1
      };
      for (let i = 0; i < conversacion.length; i++){
        if(conversacion[i].receptor_id.id == data.usuario.id){
          axios.put('https://good-learn-jjrdb.ondigitalocean.app/api/mensaje/'+conversacion[i].id, lectura);
        }
      }
    }
  },
  data() {
    return {
      form: {
        texto: "",
      },
      comentarios: {},
      credentialStatus: {},
      credentials: {},
      receptor: {},
      conversacion: {},
    };
  },
  setup() {
    return { send, person, school, home, add };
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