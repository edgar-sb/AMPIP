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
        <plus-card :dialogs="2" :id="id.id"></plus-card>
      </v-dialog>
    </v-card-title>

    <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
      <v-tab v-if="id.tipoDeSocio != 'Patrocinador'">
        Parques
      </v-tab>
      <v-tab>
        Informacion
      </v-tab>
    </v-tabs>

    <!-- Items -->
    <v-tabs-items v-model="tab">
      <!--Parques listo-->
      <v-tab-item v-if="id.tipoDeSocio != 'Patrocinador'">
        <v-container>
          <v-row>
            <v-col sm="12" md="4" v-for="i in parks" :key="i.id">
              <v-card>
                <v-card-title v-text="i.nombre_es"></v-card-title>

                <v-card-actions>
                  <v-btn icon @click="infoParkAction(i.id)">
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>
                  <v-btn icon>
                    <v-icon @click="inactive('i', 'p', i.id)"
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
            <v-col sm="12">
              <UploadImages
                @change="handleImages"
                :max="1"
                maxError="Solamente una imagen"
                style="color:#fff"
              />
            </v-col>
            <v-col sm="12" md="6">
              <v-text-field
                v-model="id.corporativo"
                label="Corporativo"
                outlined
              >
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.nombre_es" label="Nombre" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field
                v-model="id.nombre_en"
                label="Nombre ingles"
                outlined
              >
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.rfc" label="RFC" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.direccion" label="Direccion" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.cp" label="C.P" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.colonia" label="Colonia" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.estado" label="Estado" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field
                v-model="id.municipio"
                label="municipio/alcaldía"
                outlined
              >
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field v-model="id.celular" label="Celular" outlined>
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field
                v-model="id.inversionAnualSiguiente"
                label="Inversión anual programada (pipeline año siguiente) MXN"
                outlined
              >
              </v-text-field>
            </v-col>

            <v-col sm="12" md="6">
              <v-text-field
                v-model="id.inversionRealizadaActual"
                label="Inversión anual realizada (año en curso) MXN"
                outlined
              >
              </v-text-field>
            </v-col>

            <v-col sm="12">
              <v-text-field
                v-model="id.inversionRealizadaAnterior"
                label="Inversión anual realizada (año anterior) MXN"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-card-actions>
              <v-btn @click="updatecorpAction">Guardar Informacion</v-btn>
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
      let params = new URLSearchParams();
      params.append("type", type);
      params.append("table", table);
      params.append("id", id);
      axios
        .post(`${this.$store.state.url}/activeinactive`, params)
        .then((res) => console.log(res.data))
        .catch((e) => console.log(e));
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
      params.append(
        "inversionRealizadaActual",
        this.id.inversionRealizadaActual
      );
      params.append(
        "inversionRealizadaAnterior",
        this.id.inversionRealizadaAnterior
      );
      params.append("habilitar", 0);

      axios
        .post(`${this.$store.state.url}/updatecorp`, params)
        .then((res) => {
          console.log(res.data);
        })
        .catch((e) => console.log(e));
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
  },
};
</script>
