<template>
  <componen>
    <v-card-title>
      <v-btn
        icon
        @click="getTabId"
        v-if="tab != 1 && id.tipoDeSocio != 'Patrocinador'"
      >
        <v-icon>
          mdi-plus
        </v-icon>
      </v-btn>

      <!-- Parque nuevo-->
      <v-dialog v-model="addPark" width="700">
        <plusCard :dialogs="2" :id="id.id" @close="x"></plusCard>
      </v-dialog>
    </v-card-title>

    <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
      <v-tab v-if="id.tipoDeSocio != 'Patrocinador'">
        Parques
      </v-tab>
      <v-tab>
        Información
      </v-tab>
    </v-tabs>

    <!-- Items -->
    <v-tabs-items v-model="tab">
      <!--Parques listo-->
      <v-tab-item v-if="id.tipoDeSocio != 'Patrocinador'">
        <v-container>
          <v-row>
            <v-col cols="12" sm="12" md="4" v-for="i in parks" :key="i.id">
              <v-card>
                <v-card-title
                  v-if="i.nombre_es != 'Naves sin parques'"
                  v-text="i.nombre_es"
                ></v-card-title>
                <v-card-title v-if="i.nombre_es == 'Naves sin parques'"
                  >Naves Stand Alone</v-card-title
                >
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn icon @click="infoParkAction(i.id)">
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>
                  <v-btn icon v-if="i.nombre_es != 'standalone'" @click="inactive('i', 'p', i.id)">
                    <v-icon
                      >mdi-delete</v-icon
                    >
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-tab-item>
      <!--Info-->
      <v-tab-item>
        <v-container>
          <v-row>
            <v-col cols="12" sm="12" class="my-4">
              <span style="color : red" v-if="id.habilitar == 0"
                >Este cambio debe ser aprobado por el administrador. Te notificaremos cuando tus cambios hayan sido aprobados.</span>
              <span style="color : green" v-if="id.habilitar != 0"
                > Última actualización autorizada</span
              >
              <UploadImages
                @change="handleImages"
                :max="1"
                maxError="Solamente una imagen"
                style="color:#fff"
              />
            </v-col>
            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.corporativo"
                label="Corporativo"
                outlined
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.nombre_es"
                label="Nombre de Corporativo (Español)"
                outlined
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.nombre_en"
                label="Nombre de Corporativo (Ingles)"
                outlined
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.rfc"
                label="RFC"
                outlined
                :rules="[rules.required, rules.rfcMin]"
              >
              </v-text-field>
            </v-col>
            <v-col sm="12" class="titulo_form_space">
              <span>Dirección / Contacto</span>
            </v-col>
            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.direccion"
                label="Calle y Número"
                outlined
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <v-text-field
                outlined
                label="Código Postal"
                v-model="id.cp"
                @keyup="watchCp"
                :rules="[rules.required, rules.number]"
              ></v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <span> Datos previamente registrados : {{ id.colonia }}</span>
              <v-select
                :items="cp"
                label="Colonia"
                placeholder="Colonia"
                outlined
                v-model="id.colonia"
                item-text="d_asenta"
                item-value="d_asenta"
                :rules="[rules.required]"
              ></v-select>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <span>Datos previamente registrados : {{ id.estado }}</span>
              <v-text-field
                v-model="edo"
                label="Estado"
                :rules="[rules.required]"
                outlined
                disabled
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <spam>Datos previamente registrados : {{ id.municipio }}</spam>
              <v-text-field
                v-model="mun"
                label="municipio/alcaldía"
                outlined
                disabled
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="6">
              <span>Datos previamente registrados : {{id.celular}}</span>
              <v-text-field
                v-model="id.celular"
                label="Celular"
                outlined
                :rules="[rules.required, rules.phone, rules.number]"
              >
              </v-text-field>
            </v-col>
            <v-col sm="12" class="titulo_form_space">
              <span>Inversión: </span>
            </v-col>
            <v-col cols="12" sm="12" md="12">
              <v-text-field
                v-model="id.inversionAnualSiguiente"
                label="Inversión anual programada (pipeline año siguiente) MXN"
                outlined
                :rules="[rules.required, rules.number]"
                prepend-inner-icon="$"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.inversionRealizadaActual"
                label="Inversión anual programada (pipeline año actual) MXN"
                outlined
                :rules="[rules.required, rules.number]"
                prepend-inner-icon="$"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" sm="12" md="6">
              <v-text-field
                v-model="id.inversionRealizadaAnterior"
                label="Inversión anual programada (pipeline año anterior) MXN"
                outlined
                :rules="[rules.required, rules.number]"
                prepend-inner-icon="$"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" sm="12" class="titulo_form_space">
              <span>Social: </span>
            </v-col>
            <v-col sm="12" md="12">
              <v-text-field
                v-model="social.facebook"
                label="Facebook"
                outlined
                :rules="[rules.required, rules.link]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="12">
              <v-text-field
                v-model="social.twiter"
                label="Twitter"
                outlined
                :rules="[rules.required, rules.link]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="12">
              <v-text-field
                v-model="social.instagram"
                label="Instagram"
                outlined
                :rules="[rules.required, rules.link]"
              >
              </v-text-field>
            </v-col>

            <v-col cols="12" sm="12" md="12">
              <v-text-field
                v-model="social.linkdin"
                label="Linkedin"
                outlined
                :rules="[rules.required, rules.link]"
              >
              </v-text-field>
            </v-col>
            <v-card-actions>
              <v-btn @click="updatecorpAction" class="card_space_general">Guardar Información</v-btn>
            </v-card-actions>
          </v-row>
        </v-container>
      </v-tab-item>
    </v-tabs-items>
  </componen>
</template>
<script>
import axios from "axios";
import plusCard from "../components/plusCard";
import UploadImages from "vue-upload-drop-images";
import Swal from "sweetalert2";
import VueCookies from "vue-cookies";
var CryptoJS = require("crypto-js");
export default {
  data() {
    return {
      tab: 0,
      corp: [],
      parks: [],
      navs: [],
      tabs: [
        { title: "Corporativo", id: 1 },
        { title: "Usuarios", id: 2 },
        { title: "Parques", id: 3 },
        { title: "Naves", id: 4 },
      ],
      id: null,
      users: null,
      addUser: false,
      addPark: false,
      addNav: false,
      cards: {
        infoUser: false,
        infoPark: false,
        infoNave: false,
      },
      propsToComponents: {
        user: 0,
        park: 0,
        nave: 0,
      },
      social: {
        facebook: "",
        twiter: "",
        instagram: "",
        linkdin: "",
      },
      cp: [],
      logo: null,
      rules: {
        rfc: (i) => i.length > 11 || "RFC no valido",
        rfcMin: (i) => i.length <= 13 || "RFC no valido",
        required: (value) => !!value || "Requerido.",
        phone: (i) => i.length == 10 || "Número de teléfono no valido",
        number: (i) => {
          const pattern = /^([0-9])*$/;
          return pattern.test(i) || "Número no valido";
        },
        link: (i) => {
          let pattern = /^https?:\/\/[\w-]+(\.[\w-]+)+[/#?]?.*$/;
          return pattern.test(i) || "Link no valido";
        },
      },
    };
  },
  props: ["id_corp"],
  components: {
    plusCard,
    UploadImages,
  },
  methods: {
    close() {
      this.$router.push("/");
    },

    getInfoCorpAction() {
      let params = new URLSearchParams();
      params.append("id", this.id_corp);
      axios
        .post(`${this.$store.state.url}/corp`, params)
        .then((res) => {
          this.id = res.data;
          const ctx = this;
          let params = new URLSearchParams();
          params.append("id", res.data.id);
          console.log(res.data.id);
          console.log(this.id.id);
          axios
            .post(`${this.$store.state.url}/getuserbykeycorp`, params)
            .then((res) => {
              ctx.users = res.data;
            })
            .catch((e) => console.log(e));
          let paramsExtra = new URLSearchParams();
          paramsExtra.append("query", 1);
          paramsExtra.append("id", this.id.id);
          axios
            .post(`${this.$store.state.url}/extras`, paramsExtra)
            .then((res) => (this.social = JSON.parse(res.data.data)))
            .catch((e) => console.log(e));
        })
        .catch((e) => console.log(e));
      this.getCorpInfo = true;
    },

    getTabId() {
      switch (this.tab) {
        case 0:
          this.addPark = true;
          break;
      }
    },

    getParks() {
      let params = new URLSearchParams();
      params.append("id", this.$store.state.data.key_corp);
      axios
        .post(`${this.$store.state.url}/getallpark`, params)
        .then((res) => (this.parks = res.data))
        .catch((e) => console.log(e));
    },

    getAllNaves() {
      let params = new URLSearchParams();
      params.append("id", this.$store.state.data.key_corp);
      axios
        .post(`${this.$store.state.url}/getallnave`, params)
        .then((res) => (this.navs = res.data))
        .catch((e) => console.log(e));
    },

    inactive(type, table, id) {
      Swal.fire({
        title: "¿Esta seguro de esta acción?",
        text: "Esta apunto de elimiar",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          let params = new URLSearchParams();
          params.append("type", type);
          params.append("table", table);
          params.append("id", id);
          axios
            .post(`${this.$store.state.url}/activeinactive`, params)
            .then(() => {
              this.getParks();
            })
            .catch((e) => console.log(e));
        }
      });
    },

    infoUserAction(id) {
      let params = new URLSearchParams();
      params.append("id", id);
      axios
        .post(`${this.$store.state.url}/getdatauser`, params)
        .then((res) => {
          this.propsToComponents.user = res.data;
        })
        .catch((e) => console.log(e));
      this.cards.infoUser = true;
    },

    infoParkAction(id) {
      this.$store.commit("setParque", id);
      this.$router.push("/parque");
    },

    closeInfo() {
      this.cards.infoPark = false;
      this.cards.infoUser = false;
      this.cards.infoNave = false;
    },

    infoNaveAction(id) {
      let params = new URLSearchParams();
      params.append("id", id);
      axios
        .post(`${this.$store.state.url}/getinquilino`, params)
        .then((res) => {
          this.propsToComponents.nave = res.data[0];
        })
        .catch((e) => console.log(e));
      this.cards.infoNave = true;
    },

    updatecorpAction() {
      var emals = CryptoJS.AES.decrypt(VueCookies.get("email"), "ampip");
      let  email = emals.toString(CryptoJS.enc.Utf8);
      let status = {
        email:email,
        status:"evaluacion en espera", 
        comments:null
      };
      let params = new URLSearchParams();
      params.append("id", this.id.id);
      params.append("nombre_es", this.id.nombre_es);
      params.append("nombre_en", this.id.nombre_en);
      params.append("direccion", this.id.direccion);
      params.append("rfc", this.id.rfc);
      params.append("cp", this.id.cp);
      params.append("colonia", this.id.colonia);
      params.append("estado", this.id.estado);
      params.append("municipio", this.id.municipio);
      params.append("telefono", this.id.celular);
      params.append("inversionAnualSiguiente", this.id.inversionAnualSiguiente);
      params.append("inversionAnualActual", this.id.inversionRealizadaActual);
      params.append(
        "inversionAnualAnterior",
        this.id.inversionRealizadaAnterior
      );
      params.append("status", JSON.stringify(status));
      params.append("habilitar", 0);

      if (
        this.id.nombre_es != "" &&
        this.id.nombre_en != "" &&
        this.id.rfc != ""
      ) {
        axios
          .post(`${this.$store.state.url}/updatecorp`, params)
          .then(() => {
            this.extrasAction();
            Swal.fire(
              "Este cambio debe ser aprobado por el administrador. Te notificaremos cuando tus cambios hayan sido aprobados."
            );
          })
          .catch((e) => console.log(e));
        let data = new FormData();
        data.append("query", "logo");
        data.append("uniqueName", this.id.nombre_es);
        data.append("fichero_usuario", this.logo);
        var config = {
          method: "post",
          url: `${this.$store.state.baseUrl}/api/uploadfiles`,
          headers: { "Content-Type": "image/jpeg" },
          data: data,
        };
        let ctx = this;
        axios(config)
          .then(function(response) {
            ctx.$router.push("/");
            console.log(JSON.stringify(response.data));
          })
          .catch(function(error) {
            console.log(error);
          });
      } else {
        Swal.fire({
          text: "No se puede guardar la información sin (Nombre de corporativo Ingles y Espáñol y RFC) asegurate de haberlos llenado",
        });
      }
    },

    extrasAction() {
      let params = new URLSearchParams();
      params.append("query", 2);
      params.append("id", this.id.id);
      params.append("data", JSON.stringify(this.social));
      axios
        .post(`${this.$store.state.url}/extras`, params)
        .then((res) => console.log(res))
        .catch((e) => console.log(e));
    },
    x() {
      this.addPark = false;
      this.getInfoCorpAction();
      this.getParks();
    },
    handleImages(files) {
      this.logo = files[0];
    },
    watchCp() {
      if (this.id.cp.length > 4) {
        axios
          .get(
            `http://sepomex.icalialabs.com/api/v1/zip_codes?zip_code=${this.id.cp}`
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
    this.getInfoCorpAction();
    this.getParks();
    this.getAllNaves();
  },
  computed: {
    imgRoute() {
      return `${this.$store.state.img}/`;
    },
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
