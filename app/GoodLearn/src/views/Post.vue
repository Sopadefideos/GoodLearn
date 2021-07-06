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

    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title size="large">Blank</ion-title>
        </ion-toolbar>
      </ion-header>

      <div id="container">
        <form @submit.prevent="post">
          <ion-item>
            <ion-label position="floating" style="color: #c99255 !important"
              >Titulo</ion-label
            >
            <ion-input
              name="titulo"
              v-model="form.titulo"
              id="email"
              type="text"
              required
            ></ion-input>
          </ion-item>

          <ion-item>
            <ion-label position="floating" style="color: #c99255 !important"
              >Imagen</ion-label
            >
            <ion-input
              name="img"
              @change="previewFiles"
              type="file"
              required
              accept="image/*"
            ></ion-input>
          </ion-item>
          <ion-button
            expand="block"
            type="submit"
            fill="outline"
            color="priamry"
            >Publicar</ion-button
          >
        </form>
      </div>

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
import { mail, person, call, home, pin, school, send } from "ionicons/icons";
import { camera, trash, close } from 'ionicons/icons';
import { usePhotoGallery } from '../composables/usePhotoGallery';

import {
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,
  IonButton,
  IonIcon,
  IonTabBar,
  IonTabButton,
  IonTabs,
  IonFooter,
  IonItem,
  IonInput,
  IonLabel,
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
    IonButton,
    IonIcon,
    IonTabBar,
    IonTabButton,
    IonTabs,
    IonFooter,
    IonItem,
    IonInput,
    IonLabel,
  },
  mounted() {
    console.log("Estamos en perfil");
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
    } else {
      this.credentials = {};
      this.$router.push("login");
    }
  },

  created() {
    localStorage.removeItem("reloaded");
    console.log("Estamos en perfil Created");
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
    } else {
      this.credentials = {};
      window.location.href = "/login";
    }
  },

  methods: {
    post: function () {
      console.log(this.form);
      const data = JSON.parse(JSON.stringify(this.credentials));
      console.log(this.file);
      const post = new FormData();
      post.append('titulo', this.form.titulo);
      post.append('img', this.file);
      new FormData()
      axios.post('https://good-learn-jjrdb.ondigitalocean.app/api/publicacion/'+data.usuario.id, post,
      {
          headers: {
            'Content-Type': 'multipart/form-data' ,
          },
        })
        .then((response) => location.reload());
    },

    previewFiles(event: any) {
      this.file = event.target.files[0];
      this.form.img = event.target.files[0];
    }

  },
  data() {
    return {
      file: '',
      form: {
        titulo: "",
        img: '',
      },
      data: {},
      credentialStatus: {},
      credentials: {},
    };
  },
  setup() {
    const { photos, takePhoto } = usePhotoGallery();

    return {
      photos,
      takePhoto,
      camera, trash, close,
      mail, person, call, home, pin, school, send
    }
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