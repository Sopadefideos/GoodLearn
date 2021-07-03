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
        <ion-card>
          <ion-item>
            <ion-icon :icon="person" slot="start"></ion-icon>
            <ion-label>{{ credentials.usuario.name }}</ion-label>
          </ion-item>
          <ion-item>
            <ion-icon :icon="mail" slot="start"></ion-icon>
            <ion-label>{{ credentials.usuario.email }}</ion-label>
          </ion-item>
          <ion-item>
            <ion-icon :icon="call" slot="start"></ion-icon>
            <ion-label>{{ credentials.usuario.telefono }}</ion-label>
          </ion-item>
          <ion-item>
            <ion-icon :icon="home" slot="start"></ion-icon>
            <ion-label>{{ credentials.usuario.direccion }}</ion-label>
          </ion-item>
          <ion-card-content> </ion-card-content>
          <ion-button
            expand="block"
            fill="outline"
            color="danger"
            @click="logout()"
            >Logout</ion-button
          >
        </ion-card>
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
import { mail, person, call, home, pin, school, send } from "ionicons/icons";

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
  IonLabel,
  IonItem,
  IonCardContent,
  IonCard,
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
    IonButton,
    IonIcon,
    IonTabBar,
    IonTabButton,
    IonTabs,
    IonLabel,
    IonItem,
    IonCard,
    IonCardContent,
    IonFooter,
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
    console.log("Estamos en perfil Created");
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
    } else {
      this.credentials = {};
      window.location.href = "/login";
    }
  },

  methods: {
    logout: function () {
      localStorage.clear();
      console.log("holaaaa");
      this.credentials = {};
      location.reload();
    },
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
    };
  },
  setup() {
    return { mail, person, call, home, pin, school, send };
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