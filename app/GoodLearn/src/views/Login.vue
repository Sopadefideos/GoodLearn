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
          <ion-button
            expand="block"
            type="submit"
            fill="outline"
            color="priamry"
            >Iniciar sesion</ion-button
          >
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

  mounted() {
    console.log("pagina login");
    if (localStorage.session) {
      this.$router.push("home");
    } else {
      this.credentials = {};
    }
  },

  methods: {
    login: async function () {
      localStorage.clear();
      console.log(this.form);
      const url =
        "https://good-learn-jjrdb.ondigitalocean.app/api/usuarios/show?text=" +
        this.form.email;

      fetch(url)
        .then((response) => response.json())
        .then((data) => {
          this.data = data;
          console.log("1");
          const usuario = JSON.parse(JSON.stringify(this.data));
          console.log("2");
          axios
            .post(
              "https://good-learn-jjrdb.ondigitalocean.app/api/usuario/credentials",
              {
                email: this.form.email,
                password: this.form.password,
              }
            )
            .then((response) => {
              this.credentialStatus = response.data;
              console.log("3");
              const credencialesValue = JSON.parse(
                JSON.stringify(this.credentialStatus)
              );
              if (credencialesValue.error == false) {
                const session = {
                  email: usuario[0].email,
                  nombre: usuario[0].name,
                  rol: usuario[0].rol_id.id,
                  usuario: usuario[0],
                };
                console.log(session);
                localStorage.setItem("session", JSON.stringify(session));
                this.$router.push("home");
              }
            });
        });
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