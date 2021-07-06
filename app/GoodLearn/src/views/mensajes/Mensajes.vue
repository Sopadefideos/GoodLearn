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
              <ion-label style="font-size: 70%; font-weight: 700; color: blue">{{usuario.name}} - {{usuario.email}}</ion-label>
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
            ><ion-item v-if="noLeido(mensajesRecibidos, usuario.id) == false">
              <ion-label style="font-size: 70%;">{{usuario.name}} - {{usuario.email}}</ion-label>
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

  async created() {
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

      this.leer(data.usuario.id);
      
      if(data.usuario.rol_id.id == 1){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios')
          .then((response) => {
            this.agenda = response.data;
          });
      }

      if(data.usuario.rol_id.id == 3){
        let cursoId = "";
        await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/cursos_alumnos/show?text=' + data.usuario.id )
          .then(async (response) => {
            for(let i = 0; i < Object.keys(response.data).length; i++){
              if(response.data[i].usuario_id.id == data.usuario.id){
                cursoId = response.data[i].curso_id.id;
               }
            }
            await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas_cursos')
              .then((response) => {
                const profesores = [];
                axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios')
                  .then((response) => {
                    for(let i = 0; i < Object.keys(response.data).length; i++){
                    if(response.data[i].rol_id.id == 1){
                      profesores.push(response.data[i]);
                    }
                  }
                });

                for(let i = 0; i < Object.keys(response.data).length; i++){
                  if(response.data[i].curso_id.id == cursoId){
                    profesores.push(response.data[i].asignatura_id.usuario_id);
                  }
                } 
                this.agenda = profesores;
              });
          });
      }

      if(data.usuario.rol_id.id == 4){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/padres')
          .then(async (response) => {
            const hijos = [];
            for(let i = 0; i < Object.keys(response.data).length; i++){
              if(response.data[i].padre_id.id == data.usuario.id){
                hijos.push(response.data[i].alumno_id);
              }
            }
            this.hijos = hijos;
            const datosHijos = JSON.parse(JSON.stringify(this.hijos));
            const cursos: any = [];
            for(let i = 0; i < datosHijos.length; i++){
              console.log(datosHijos[i].id);
              await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/cursos_alumnos/show?text=' + datosHijos[i].id)
                .then((response) => {
                  for(let j = 0; j < Object.keys(response.data).length; j++){
                    if(response.data[j].usuario_id.id == datosHijos[i].id){
                      cursos.push(response.data[j].curso_id.id);
                    }
                  }
                });
            }
            const profesores: any = [];
            await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios')
              .then((response) => {
                for(let i = 0; i < Object.keys(response.data).length; i++){
                if(response.data[i].rol_id.id == 1){
                  profesores.push(response.data[i]);
                }
              }
            });
            
            for(let i = 0; i < cursos.length; i++){
              await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas_cursos')
                .then((response) => {
                  for(let j = 0; j < Object.keys(response.data).length; j++){
                    if(response.data[j].curso_id.id == cursos[i]){
                      profesores.push(response.data[j].asignatura_id.usuario_id);
                    }
                  }
                });
            }
            const cleanAgenda = [ ...new Set(profesores) ]
            this.agenda = cleanAgenda;
          });
      }


      if(data.usuario.rol_id.id == 2){
        axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/asignaturas_cursos')
          .then((response) => {
            const ids = [];
            for(let i = 0; i < Object.keys(response.data).length; i++){
              if(response.data[i].asignatura_id.usuario_id.id == data.usuario.id){
                ids.push(response.data[i].curso_id.id);
              }
            }
            this.cursosId = ids;
            axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/cursos_alumnos')
              .then(async (response) => {
                const alumnos: any = [];
                const aux = [this.cursosId];
                axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios')
                  .then((response) => {
                    for(let i = 0; i < Object.keys(response.data).length; i++){
                    if(response.data[i].rol_id.id == 1){
                      alumnos.push(response.data[i]);
                    }
                  }
                });

                for(let i = 0; i < aux.length; i++){
                  for(let j = 0; j < Object.keys(response.data).length; j++){
                    if(response.data[j].curso_id.id == aux[i]){
                     await alumnos.push(response.data[j].usuario_id);
                    }
                  }
                }
                
                for(let i = 0; i < alumnos.length; i++){
                  await axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/padres')
                    .then((response) => {
                      for(let h = 0; h < Object.keys(response.data).length; h++){
                        if(response.data[h].alumno_id.id == alumnos[i].id){
                          alumnos.push(response.data[h].padre_id);
                        }
                      }
                    });
                }
                const cleanAgenda = [ ...new Set(alumnos) ]
                this.agenda = cleanAgenda;
                console.log(this.agenda);
              });
          });
      }

      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/mensajes/show?text='+data.usuario.id)
        .then((response) => {
          const recibido = [];
          console.log(response.data);
          for(let i = 0; i < Object.keys(response.data).length; i++){
            if(response.data[i].receptor_id.id == data.usuario.id && response.data[i].estado == 0){
              recibido.push(response.data[i].emisor_id.id);
            }
          }
          console.log(recibido);
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
      },

    leer: async function(usuarioId: any){
      axios.get('https://good-learn-jjrdb.ondigitalocean.app/api/notificaciones')
        .then(async (response) => {
          for(let i = 0; i < Object.keys(response.data).length; i++){
            if(response.data[i].tipo_id.id == 1 && response.data[i].usuario_id.id == usuarioId){
              await axios.delete('https://good-learn-jjrdb.ondigitalocean.app/api/notificacion/' + response.data[i].id);
            }
          }
        });
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
      mensajesRecibidos: {},
      cursosId: {},
      alumnosId: {},
      hijos: {},
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