<template>
  <v-app>
    <v-container>
      <v-row justify="center" align="center" class="all">
        <v-col sm="9">
          <v-card>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <img
                      src="data:image/png;base64,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"
                    />
                  </v-col>
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
                      hint=""
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
                   <v-col cols="12">
                    <v-checkbox label="¿Autorizo que mis datos sean compartidos con NAIOP?" v-model="naiop"></v-checkbox>
                  </v-col>
                  <v-col cols="12">
                    <p>
                      Recomendamos como mínimo 8 caracteres, máximo 15. Usar al
                      menos una letra mayúscula, una letra minúscula, un número,
                      un caracter especial (!, #, $, %, &, ?, /) y sin espacios
                      en blanco.
                    </p>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn @click="updatePass">Guardar</v-btn>
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
import Swal from "sweetalert2";
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
        secure: (i) => this.secureTest.test(i) || "Contraseña Insegura",
      },
      naiop: false,
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
      if (this.pass != null && this.confirmPass != null, this.naiop == true) {
        if (this.pass.length > 7) {
          if (this.pass === this.confirmPass) {
            params.append("id", this.user);
            params.append("type", 1);
            params.append("pass", this.pass);
            axios
              .post(`${this.$store.state.url}/reset`, params)
              .then((res) => {
                Swal.fire({ text: res.data.message });
                VueCookies.remove("id");
                VueCookies.remove("email");
                VueCookies.remove("name");
                this.$router.push("/");
              })
              .catch((e) => console.log(e));
          } else {
            Swal.fire({
              text: "Asegurate de que las contraseñas coinsidan",
            });
          }
        } else {
          Swal.fire({
            text: "Como minimo 8 caracteres",
          });
        }
      } else {
        Swal.fire({
          text: "Asegurate de haber llenado correctamente los campos y aurorizar NAIOP",
        });
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
