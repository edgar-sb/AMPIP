<template>
  <v-card>
    <v-card-actions>
      <v-card-title>Perfil de usuario</v-card-title>
      <v-spacer></v-spacer>
      <v-btn @click="setProfileActionModel" icon color="red">
        <v-icon>mdi-window-close</v-icon>
      </v-btn>
    </v-card-actions>
    <v-card-text>
      <v-row>
        <v-col cols="12" sm="12">
          <UploadImages
            @change="handleImages"
            :max="1"
            maxError="Solamente una imagen"
            style="color:#fff"
          />
        </v-col>
        <v-col cols="12" sm="12" md="6">
          <v-text-field outlined label="Nombre completo" v-model="name">
          </v-text-field>
        </v-col>
        <v-col cols="12" sm="12" md="6">
          <v-text-field outlined label="email" v-model="email"> </v-text-field>
        </v-col>
        <v-col cols="12" sm="12">
          <span>Direccion:</span> <br />
          <span> {{ dataUser.direccionDeOfficina }}</span>
          <v-switch
            label="¿Deseas modificar tu Direccion?"
            v-model="changeAddres"
            :value="changeAddres"
          ></v-switch>
        </v-col>
        <v-col cols="12" sm="12" md="12" v-if="changeAddres">
          <v-text-field
            label="Calle y Número"
            v-model="address_street"
            outlined
          >
          </v-text-field>
        </v-col>

        <v-col cols="12" md="6" v-if="changeAddres">
          <v-text-field
            outlined
            label="Codigo postal"
            v-model="cpUser"
            @keyup="watchCp"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="6" v-if="changeAddres">
          <v-select
            :items="cp"
            label="Colonia"
            placeholder="Colonia"
            outlined
            v-model="col"
            item-text="d_asenta"
            item-value="d_asenta"
          ></v-select>
        </v-col>
        <v-col cols="12" md="6" v-if="changeAddres">
          <v-text-field
            outlined
            label="Estado"
            v-model="edo"
            disabled
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="6" v-if="changeAddres">
          <v-text-field
            outlined
            label="Municipio/Alcaldía"
            v-model="mun"
            disabled
          ></v-text-field>
        </v-col>

        <v-col cols="12" sm="12">
          <span>Contacto:</span>
        </v-col>
        <v-col cols="12" sm="12" md="6">
          <v-text-field
            label="Teléfono de oficina"
            v-model="dataUser.telefonoOfficina"
            outlined
          >
          </v-text-field>
        </v-col>
        <v-col cols="12" sm="12" md="6">
          <v-text-field
            label="Teléfono personal"
            outlined
            v-model="dataUser.celular"
          >
          </v-text-field>
        </v-col>

        <v-col cols="12" v-if="dataUser.key_corp != 0">
          <v-dialog
            ref="dialog"
            v-model="modal"
            :return-value.sync="dataUser.cumpleanios"
            persistent
            width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="dataUser.cumpleanios"
                label="Fecha de nacimiento"
                readonly
                v-bind="attrs"
                v-on="on"
                outlined
              ></v-text-field>
            </template>
            <v-date-picker v-model="date" scrollable>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="modal = false">
                Cancel
              </v-btn>
              <v-btn text color="primary" @click="$refs.dialog.save(date)">
                OK
              </v-btn>
            </v-date-picker>
          </v-dialog>
        </v-col>
        <v-col cols="12" sm="12">
          <span>Seguridad:</span>
        </v-col>
        <v-col cols="12" sm="12">
          <v-switch
            label="¿Deseas modificar tu contraseña?"
            v-model="changePass"
            :value="changePass"
          ></v-switch>
        </v-col>
        <v-col cols="12" sm="12" md="6" v-if="changePass">
          <v-text-field
            type="password"
            label="Nueva contraseña"
            v-model="newPass"
            outlined
          >
          </v-text-field>
        </v-col>

        <v-col cols="12" sm="12" md="6" v-if="changePass">
          <v-text-field
            type="password"
            label="Confirma tu nueva contraseña"
            v-model="newPassConfirm"
            :rules="[filters.pass]"
            outlined
          >
          </v-text-field>
        </v-col>
        <v-col cols="12" sm="12">
          <v-text-field
            type="password"
            label="Confirma tu contraseña actual"
            v-model="pass"
            :rules="[rules.required]"
            outlined
          >
          </v-text-field>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn @click="logout" text color="yellow">
        Cerrar sesion
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn @click="setProfileActionModel" text color="red">
        Cerrar
      </v-btn>
      <v-btn @click="save" text color="green">
        Guardar
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import UploadImages from "vue-upload-drop-images";
import Swal from "sweetalert2";
import VueCookies from "vue-cookies";
import axios from "axios";
var CryptoJS = require("crypto-js");
export default {
  props: ["id"],

  data() {
    return {
      dataUser: null,
      name: null,
      email: null,
      idUser: null,
      pass: null,
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false,
      imgProfile: [],
      rules: {
        required: (value) => !!value || "Valor requerido.",
      },
      newPass: "",
      confirmPass: "",
      changePass: false,
      changeAddres: false,
      cp: [],
      cpUser: "",
      col: "",
      address_street: "",
      newPassConfirm: "",
      filters: {
        pass: () =>
          this.newPass == this.newPassConfirm || "Las contraseñas no coinsiden",
      },
    };
  },

  methods: {
    getid() {
      console.log(this.$store.state.data.id);
    },
    logout() {
      this.$store.commit("changeProfileDialog");
      VueCookies.remove("user_type");
      VueCookies.remove("id");
      VueCookies.remove("name");
      VueCookies.remove("email");
      VueCookies.remove("key_corp");
      this.$router.push("/");
    },
    save() {
      var key = VueCookies.get("id");
      var decripts = CryptoJS.AES.decrypt(key, "ampip");
      var originalText = decripts.toString(CryptoJS.enc.Utf8);
      var ids = originalText;
      if (this.pass != null) {
        let params = new URLSearchParams();
        params.append("id", this.idUser);
        params.append("password", this.pass);
        params.append("email", this.email);
        params.append("full_name", this.name);
        params.append("status", 1);
        axios
          .post(`${this.$store.state.url}/updateuser`, params)
          .then((res) => {
            if (res.data.message == 1) {
              let pars = new URLSearchParams();
              pars.append("id", ids);
              pars.append("telefonoOfficina", this.dataUser.telefonoOfficina);
              pars.append("celular", this.dataUser.celular);
              pars.append("direccionDeOfficina",`${this.address_street}  ${this.cpUser}  ${this.col} ${this.edo} ${this.mun}`);
              pars.append("cumpleanios", this.dataUser.cumpleanios);
              axios.post(`${this.$store.state.url}/updatedatauser`, pars).then(() => {
                  let timerInterval;
                  Swal.fire({
                    title: "Datos guardados",
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      timerInterval = setInterval(() => {
                        const content = Swal.getHtmlContainer();
                        if (content) {
                          const b = content.querySelector("b");
                          if (b) {
                            b.textContent = Swal.getTimerLeft();
                          }
                        }
                      }, 100);
                    },
                    willClose: () => {
                      let data = new FormData();
                      data.append("query", "perfil");
                      data.append("uniqueName", this.$store.state.data.id);
                      data.append("fichero_usuario", this.imgProfile);
                      var config = {
                        method: "post",
                        url: `${this.$store.state.baseUrl}/api/uploadfiles`,
                        headers: { "Content-Type": "image/jpeg" },
                        data: data,
                      };
                      axios(config)
                        .then(function(response) {
                          console.log(JSON.stringify(response.data));
                        })
                        .catch(function(error) {
                          console.log(error);
                        });

                      clearInterval(timerInterval);
                    },
                  }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                      console.log("I was closed by the timer");
                    }
                  });
                }).catch((e) => console.log(e));
            } else{
              Swal.fire({icon: "error",
          title: "Oops...",
          text: "Contraseña incorrecta",})
            }
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Porfavor ingresa tu contraseña",
        });
      }

      if (this.newPass != "") {
        if (this.newPass === this.newPassConfirm) {
          let params = new URLSearchParams();
          params.append("id", this.idUser);
          params.append("email", this.email);
          params.append("newPass", this.newPass);
          params.append("pass", this.pass);

          axios
            .post(`${this.$store.state.url}/updatepass`, params)
            .then((res) => {
              this.logout();
              console.log(res.data);
            })
            .catch((e) => console.log(e));
        } else {
          alert("Las contraseñas nuevas no coinsiden");
        }
      }
    },
    setProfileActionModel() {
      this.$store.commit("changeProfileDialog");
    },
    handleImages(value) {
      this.imgProfile = value[0];
    },
    watchCp() {
      if (this.cpUser.length > 4) {
        axios
          .get(
            `http://sepomex.icalialabs.com/api/v1/zip_codes?zip_code=${this.cpUser}`
          )
          .then((res) => {
            this.cp = res.data.zip_codes;
          })
          .catch((e) => {
            console.log(e);
          });
      }
    },
  },

  beforeMount() {
    var key = VueCookies.get("id");
    var decripts = CryptoJS.AES.decrypt(key, "ampip");
    var originalText = decripts.toString(CryptoJS.enc.Utf8);
    var ids = originalText;
    let params = new URLSearchParams();
    params.append("id", ids);
    axios
      .post(`${this.$store.state.url}/getdatauser`, params)
      .then((resGet) => {
        this.dataUser = resGet.data;
      })
      .catch((e) => console.log(e));
    var name = CryptoJS.AES.decrypt(VueCookies.get("name"), "ampip");
    this.name = name.toString(CryptoJS.enc.Utf8);

    var email = CryptoJS.AES.decrypt(VueCookies.get("email"), "ampip");
    this.email = email.toString(CryptoJS.enc.Utf8);

    var id = CryptoJS.AES.decrypt(VueCookies.get("id"), "ampip");
    this.idUser = id.toString(CryptoJS.enc.Utf8);

    console.log(this.dataUser);
  },

  components: {
    UploadImages,
  },

  computed: {
    edo() {
      if (this.cp.length > 0) {
        return this.cp[0].d_estado;
      } else {
        return "Sin datos";
      }
    },
    mun() {
      if (this.cp.length > 0) {
        return this.cp[0].d_mnpio;
      } else {
        return "Sin datos";
      }
    },
  },
};
</script>
