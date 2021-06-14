<template>
  <v-app>
    <v-container>
      <v-row justify="center" align="center" class="all">
        <v-col sm="9">
          <v-card>
            <v-card-title>Genera una contraseña</v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col sm="12" md="6">
                    <v-text-field
                      solo
                      placeholder="Nueva contraseña"
                      type="password"
                      v-model="pass"
                      :rules="[
                        rules.passLengt,
                        rules.passLengtminor,
                        rules.secure,
                      ]"
                      helper-text="Hola"
                      hint="
                      
                        Minimo 8 caracteres
                        Maximo 15
                        Al menos una letra mayúscula
                        Al menos una letra minucula 
                        Al menos un dígito
                        No espacios en blanco
                        Al menos 1 caracter especial
                  "
                    ></v-text-field>
                  </v-col>

                  <v-col sm="12" md="6">
                    <v-text-field
                      solo
                      placeholder="Confirma tu contraseña"
                      type="password"
                      v-model="confirmPass"
                      :rules="[rules.pass]"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green" text @click="updatePass">Guardar</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import axios from "axios";
import VueCookies from "vue-cookies";
export default {
  name: "password",
  data() {
    return {
      user: null,
      pass: null,
      confirmPass: null,
      secureTest: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/,
      rules: {
        pass: (i) => this.pass === i || "Las contraseñas no coinsiden",
        passLengt: (i) => i.length >= 8 || "Minimo 8 caracteres",
        passLengtminor: (i) => i.length <= 19 || "Maximo 19 caracteres",
        secure: (i) => this.secureTest.test(i) || "ContraseñaInsegura",
      },
    };
  },
  beforeMount() {
    var location = window.location.href;
    var user = location.split("?id=");
    if (user[1]) {
      this.user = user[1];
    } else {
      this.$router.push("/");
    }
  },
  methods: {
    updatePass() {
      let params = new URLSearchParams();
      if (this.pass != null && this.confirmPass != null) {
        params.append("id", this.user);
        params.append("type", 1);
        params.append("pass", this.pass);
        axios
          .post(`${this.$store.state.url}/reset`, params)
          .then(() => {
            VueCookies.remove("id");
            VueCookies.remove("email");
            VueCookies.remove("name");
            this.$router.push("/");
          })
          .catch((e) => console.log(e));
      } else {
        alert("No puede quedar nulo");
      }
    },
  },
};
</script>

<style scoped>
.all {
  height: 90vh;
}
</style>
