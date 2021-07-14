<template>
  <v-card>
    <v-card-title>Nuevo usuario ampip {{ type }}</v-card-title>
    <v-card-body>
      <v-container>
        <v-row>
          <v-col sm="6"
            ><v-text-field
              placeholder="Nombre"
              solo
              label="Nombre"
              v-model="addUser.name"
              :rules="[rules.required]"
            ></v-text-field
          ></v-col>
          <v-col sm="6"
            ><v-text-field
              placeholder="Apellido paterno"
              solo
              label="Apellido paterno"
              :rules="[rules.required]"
              v-model="addUser.lastname"
            ></v-text-field
          ></v-col>
          <v-col sm="6"
            ><v-text-field
              placeholder="Apellido materno"
              solo
              label="Apellido materno"
              :rules="[rules.required]"
              v-model="addUser.last"
            ></v-text-field
          ></v-col>
          <v-col sm="6"
            ><v-text-field
              placeholder="Correo"
              solo
              label="Correo"
              :rules="[rules.required, rules.email]"
              v-model="addUser.email"
            ></v-text-field
          ></v-col>
        </v-row>
      </v-container>
    </v-card-body>
    <v-card-actions>
      <v-btn text color="primary" @click="addUserAction">Alta</v-btn>
      <v-btn text color="red" @click="closeAction">Cancelar</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "Hola mundo",
  data() {
    return {
      addUser: {
        name: "",
        lastname: "",
        email: "",
        last: "",
      },
      rules: {
          required: (value) => !!value || "Requerido.",
          email: (value) => {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(value) || "Ingresa un correo valido.";
          },
        },
    };
  },

  methods: {
    addUserAction() {
      let params = new URLSearchParams();
      params.append("email", this.addUser.email);
      params.append(
        "fullname",
        this.addUser.name +
          " " +
          this.addUser.lastname +
          " " +
          this.addUser.last
      );
      params.append("status", 1);
      var ctx = this;
      if (
        ctx.addUser.email != "" &&
        ctx.addUser.name != "" &&
        ctx.addUser.lastname != ""
      ) {
        axios
          .post(`${this.$store.state.url}/createuser`, params)
          .then((res) => {
            if (res.data.message == 1) {
              let par = new URLSearchParams();
              par.append("email", ctx.addUser.email);
              par.append("pass", ctx.addUser.pass);
              par.append(
                "fullname",
                `${ctx.addUser.name} ${ctx.addUser.lastname} ${ctx.addUser.last}`
              );
              axios
                .post(`${this.$store.state.url}/getuseridlogin`, par)
                .then((res) => {
                  ctx.createdataUser(res.data);
                })
                .catch((e) => console.log(e));
            } else {
              Swal.fire({
                text: "El correo electronico ya esta en uso",
                icon: "error",
              });
            }
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({text:`Porfavor llena todos los campos`, icon: "error"})
      }
    },
    createdataUser(id) {
      let params = new URLSearchParams();
      params.append("id", id[0].id);
      params.append("charge", this.type);
      params.append("habilitar", 1);
      params.append("key_corp", this.key);
      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then(() => {
          this.closeAction();
        })
        .catch((e) => console.log(e));
      axios.get(
        `${this.$store.state.baseUrl}/mailler?email=${this.addUser.email}&name=${this.addUser.name}&link=${id[0].id}`
      );
    },
    closeAction() {
      this.$store.commit("newUserAdmin", false);
    },
  },

  computed: {
    key() {
      if (this.$store.state.data.key_corp != null) {
        return this.$store.state.data.key_corp;
      } else {
        return 0;
      }
    },
  },

  props: ["type"],
};
</script>
