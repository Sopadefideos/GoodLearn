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
        <form @submit.prevent="login">
          <ion-item>
            <ion-label position="floating" style="color: #c99255 !important"
              >Email</ion-label
            >
            <ion-input
              name="email"
              v-model="form.email"
              id="email"
              type="email"
              required
            ></ion-input>
          </ion-item>

          <ion-item>
            <ion-label position="floating" style="color: #c99255 !important"
              >Contraseña</ion-label
            >
            <ion-input
              name="password"
              v-model="form.password"
              type="password"
              required
            ></ion-input>
          </ion-item>

          <ion-item>
            <ion-button type="submit" shape="round">
              Iniciar sesion
              <ion-icon slot="end" :icon="logIn"></ion-icon>
            </ion-button>
          </ion-item>
        </form>
      </div>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import {
  IonContent,
  IonHeader,
  IonPage,
  IonTitle,
  IonToolbar,
  IonButton,
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
    IonItem,
    IonInput,
    IonLabel,
  },

  methods: {
    login: async function () {
      console.log(this.form);
      const url =
        "https://good-learn-jjrdb.ondigitalocean.app/api/usuarios/show?text=" +
        this.form.email;

      await fetch(url).then(async (response) => {
        this.data = await response.json();
      });

      console.log(JSON.stringify(this.data));
      alert(JSON.stringify(this.data));
    },
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      data: {},
    };
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