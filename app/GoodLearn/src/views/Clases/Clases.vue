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

      <!-- List Full Lines -->
      <ion-list lines="full">
        <a
          v-for="curso in cursos"
          :key="curso.id"
          style="text-decoration: none"
        >
          <router-link
            :to="'/clases/contenido?id=' + curso.id"
            style="text-decoration: none"
            ><ion-item>
              <ion-label>{{ curso.name }}</ion-label>
              <i class="material-icons" style="color: black">arrow_forward</i>
            </ion-item></router-link
          >
        </a>
      </ion-list>
      <embed
        src="https://good-learn-jjrdb.ondigitalocean.app/autorizaciones/1625176800TEMA1.pdf"
        type="application/pdf"
        width="100%"
        height="600px"
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
  IonLabel,
  IonItem,
  IonList,
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
    IonLabel,
    IonItem,
    IonList,
  },

  mounted() {
    if (localStorage.session) {
      this.credentials = JSON.parse(localStorage.session);
      const datos = JSON.parse(JSON.stringify(this.credentials));
      axios
        .get("https://good-learn-jjrdb.ondigitalocean.app/api/cursos/show")
        .then((response) => {
          const allCursos = response.data;
          //SI ES ADMINISTRADOR TODOS LOS CURSOS
          if (datos.usuario.rol_id.id == 1) {
            this.cursos = response.data;
            console.log(this.cursos);
          }

          //SI ES PROFESOR SELECCIONAR LOS CURSOS EN LOS QUE IMPARTE CLASES
          if (datos.usuario.rol_id.id == 2) {
            axios
              .get(
                "https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas/show?text=" +
                  datos.usuario.id
              )
              .then((response) => {
                const asignaturas = [];
                for (let i = 0; i < Object.keys(response.data).length; i++) {
                  if (response.data[i].usuario_id.id == datos.usuario.id) {
                    asignaturas.push(response.data[i]);
                  }
                }
                const aux = asignaturas;
                axios
                  .get(
                    "https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas_cursos"
                  )
                  .then((response) => {
                    const cursosasign = [];
                    for (
                      let i = 0;
                      i < Object.keys(response.data).length;
                      i++
                    ) {
                      for (let j = 0; j < aux.length; j++) {
                        if (response.data[i].asignatura_id.id == aux[j].id) {
                          cursosasign.push(response.data[i]);
                        }
                      }
                    }

                    const cursos = [];
                    const auxCursos = cursosasign;
                    for (let i = 0; i < allCursos.length; i++) {
                      for (let j = 0; j < auxCursos.length; j++) {
                        if (allCursos[i].id == auxCursos[j].curso_id.id) {
                          cursos.push(allCursos[i]);
                        }
                      }
                    }
                    this.cursos = cursos;
                  });
              });
          }
        });
    } else {
      console.log("He entrado");
      this.credentials = {};
      this.$router.push("login");
    }
  },

  created() {
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
      cursos: {},
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