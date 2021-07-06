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

      <ion-card v-for="comentario in comentarios"
        :key="comentario.fecha_creacion">
        <ion-card-header>
          <ion-card-title>{{comentario.comentario}}</ion-card-title>
        </ion-card-header>
        <ion-card-content
          ><ion-card-subtitle>{{comentario.usuario_id.name}}</ion-card-subtitle>
        </ion-card-content>
        <div class="btn-group d-flex align-items-end" v-if="credentials.rol == 1 || credentials.usuario.id == comentario.usuario_id.id">
          <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="material-icons" style="color: black">more_horiz</i>
          </button>
          <ul class="dropdown-menu">
            <a class="dropdown-item" style="color: red" v-on:click="eliminar(comentario.id)">Eliminar</a>
          </ul>
        </div>
        
      </ion-card>
    </ion-content>
    <ion-footer>
      <form @submit.prevent="comentario" method="POST">
        <ion-item>
          <ion-label position="floating">Comentario</ion-label>
          <ion-input
            name="comentario"
            v-model="form.comentario"
            id="comentario"
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
    } else {
      this.credentials = {};
      this.$router.push("login");
    }
    axios
      .get(
        "https://good-learn-jjrdb.ondigitalocean.app/api/comentarios_publicacion/show?text=" +
          this.$route.query.id
      )
      .then((response) => {
        console.log(response.data);
        const comentarios = [];
        for (let i = 0; i < Object.keys(response.data).length; i++) {
          if (response.data[i].publicacion_id.id == this.$route.query.id) {
            comentarios.push(response.data[i]);
          }
        }
        this.comentarios = comentarios;
      });
  },

  methods: {
    comentario: async function () {
      axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
      const datos = JSON.parse(JSON.stringify(this.credentials));
      const postQuery = {
        'publicacion_id': this.$route.query.id,
        'usuario_id': datos.usuario.id,
        'comentario': this.form.comentario,
      };
      console.log(postQuery);
      await axios.post(
        "https://good-learn-jjrdb.ondigitalocean.app/api/comentario_publicacion",
        postQuery,
        {
          headers: {
            Accept: "application/json",
          },
        }
      ).then((response) => location.reload());
      
    },

    eliminar: async function(id: any){
      const datos = JSON.parse(JSON.stringify(this.credentials));
      await axios.delete(
        "https://good-learn-jjrdb.ondigitalocean.app/api/comentario_publicacion/"+ datos.usuario.id +"/"+ id,
        {
          headers: {
            Accept: "application/json",
          },
        }
      );
      location.reload();
    }
  },
  data() {
    return {
      form: {
        comentario: "",
      },
      comentarios: {},
      credentialStatus: {},
      credentials: {},
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