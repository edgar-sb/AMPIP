<template>
  <componen>
    <v-card v-if="type == null">
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-text-field
              v-model="email"
              Usuario     label="Correo"
              outlined
              type="email"
              :rules="[rules.required, rules.email]"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-select
              :items="typeOfUser"
              label="Tipo de usuario"
              outlined
              :rules="[rules.required]"
              v-model="typeuser"
              @change="getAllCorp"
            ></v-select>
          </v-col>
          <v-col v-if="typeuser == 'Administrador'">
            <v-select
              :items="allCorp"
              label="Administra a "
              outlined
              :rules="[rules.required]"
              v-model="setCorp"
              item-text="nombre_es"
              item-value="id"
            ></v-select>
          </v-col>
        </v-row>
      </v-container>
      <v-card-actions>
        <v-btn @click="upUser">Alta</v-btn>
      </v-card-actions>
    </v-card>

    <!-- admin help -->
    <v-card v-if="type == 'admin_help'">
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-text-field
              v-model="email"
              label="Correo"
              outlined
              type="email"
              :rules="[rules.required, rules.email]"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              v-model="pass"
              label="Contraseña"
              outlined
              type="password"
              :rules="[rules.required, rules.counterThre]"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-select
              :items="typeOfUserHelp"
              label="Tipo de usuario"
              outlined
              :rules="[rules.required]"
              v-model="typeuser"
              @change="getAllCorp"
            ></v-select>
          </v-col>
         
        </v-row>
      </v-container>
      <v-card-actions>
        <v-btn @click="upUser">Alta</v-btn>
      </v-card-actions>
    </v-card>
  </componen>
</template>
<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      rules: {
        required: (value) => !!value || "Required.",
        counter: (value) => value.length >= 8 || "Minimo 8 characters",
        email: (value) => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Invalid e-mail.";
        },
        counterThre: (value) => value.length >= 3 || "Minimo 3 caracteres",
        phone: (value) => value.length <= 10 || "maximo 10 numeros",
        cp: (value) => value.length <= 5 || "maximo 5 numeros",
      },
      menu: false,
      typeOfUser: ["Administrador", "Patrocinador"],
      typeOfUserHelp:["Administrador de parque", "Administrador de nave", "Administrador"],
      allCorp: [],
      setCorp: 0,
      email: "",
      pass: "",
      typeuser: "",
    };
  },
  props: ["type", "id_corp"],
  computed: {
    edo() {
      if (this.addr.cpResult.length > 0) {
        return this.addr.cpResult[0].response.estado;
      } else {
        return "Sin datos";
      }
    },
    mun() {
      if (this.addr.cpResult.length > 0) {
        return this.addr.cpResult[0].response.municipio;
      } else {
        return "Sin datos";
      }
    },
  },

  methods: {
    getAllCorp() {
      axios
        .post(`${this.$store.state.url}/getallcorp`)
        .then((res) => (this.allCorp = res.data))
        .catch((e) => console.log(e));
    },

    upUser() {
      if (this.typeuser != "" && this.email != "" && this.pass != "") {
        let params = new URLSearchParams();
        params.append("email", this.email);
        params.append("pass", this.pass);
        params.append("status", 1);
        axios
          .post(`${this.$store.state.url}/createuser`, params)
          .then((res) => {
            if (res.data.message == 1) {
              axios
                .post(`${this.$store.state.url}/getuseridlogin`, params)
                .then((resDos) => {
                  console.log(resDos.data);
                  if (resDos.data[0].id) {
                    this.upData(resDos.data[0].id);
                  } else {
                    Swal.fire({
                      icon: "error",
                      title: "Ooops ...",
                      text: resDos.data[0].error,
                      backdrop: `
                        rgba(255,0,0,0.1)
                        url("/images/nyan-cat.gif")
                        left top
                        no-repeat
                        `,
                    });
                  }
                })
                .catch((e) => {
                  Swal.fire({
                    icon: "error",
                    title: "Ooops ...",
                    text: e,
                    backdrop: `
                  rgba(255,0,0,0.1)
                  url("/images/nyan-cat.gif")
                  left top
                  no-repeat
                `,
                  });
                });
            } else {
              Swal.fire({
                icon: "error",
                title: "Ooops ...",
                text: res.data.message,
                backdrop: `
                  rgba(255,0,0,0.1)
                  url("/images/nyan-cat.gif")
                  left top
                  no-repeat
                `,
              });
            }
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({
          position: "center",
          icon: "error",
          title: "Datos faltantes",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    },

    upData(id) {
      alert("Hi")
      var params = new URLSearchParams();
      params.append("id", id);
      params.append("key_corp", this.setCorp);
      params.append("charge", this.typeuser);
      var ctx = this;
      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then((res) => {
          if (res.data.message == "creado") {
            Swal.fire({
              icon: "success",
              title: "Listo",
              text: res.data.message,
              backdrop: `
                  rgba(0,255,0,0.1)
                  left top
                  no-repeat
                `,
            });
            //http://localhost:8000/mailler?email=edgar.edgarroman@gmail.com&name=edgar&link=1
            axios.get(`${this.$store.state.url}/mailler?email=${ctx.email}&name=${ctx.name}&link=${id}`)
            this.$router.push("/dasshboard");
          } else {
            Swal.fire({
              icon: "error",
              title: "Opps",
              text: res.data.message,
              backdrop: `
                  rgba(0,255,0,0.1)
                  url("/images/nyan-cat.gif")
                  left top
                  no-repeat
                `,
            });
          }
        })
        .catch((e) => console.log(e));
    },
  },
};
</script>
