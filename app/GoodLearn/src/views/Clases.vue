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

      <div id="container">
        <ion-button router-link="/home">{{
          credentials.usuario.name
        }}</ion-button>
      </div>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { send, person, school, home } from "ionicons/icons";

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
    IonButton,
    IonIcon,
    IonTabBar,
    IonTabButton,
    IonTabs,
  },

  mounted() {
    console.log("Estamos en clases");
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
    } else {
      console.log("He entrado");
      this.credentials = {};
      this.$router.push("login");
    }
  },

  created() {
    console.log("Estamos en perfil");
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
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
    };
  },
  setup() {
    return { send, person, school, home };
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