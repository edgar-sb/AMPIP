<template>
  <content>
    <!-- Header -->
    <headerAmpip> </headerAmpip>
    <!-- END Header -->
    <!-- La app-bar se mostrara en todos los usuarios sin importar su acceso -->
    <v-toolbar>
      <v-toolbar-title small>
        <label>{{ saludo }}</label>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <v-text-field
        hide-details
        label="Buscador"
        placeholder="Buscar"
        filled
        rounded
        app-bar
        dense
        single-line
        append-icon="mdi-magnify"
        class="shrink mx-4"
        v-model="keysearch"
        @keyup="key_search"
        v-if="userType == 'AdministradorGlobal'"
      >
      </v-text-field>
      <v-btn text @click="setProfileActionModel" class="perfil_space" id="more">
        Perfil
        <v-dialog
          v-model="getProfileActionModel"
          width="700"
          persistent
          :retain-focus="false"
        >
          <profile :type="userType" />
        </v-dialog>
      </v-btn>
      <v-btn text @click="getEventsButton" id="more">
        Eventos
        <v-dialog v-model="getEvents" width="80%" :retain-focus="false" class="iframes">
          <GoogleCalendar />
        </v-dialog>
      </v-btn>
    </v-toolbar>
    <v-container>
      <v-col sm="12">
        <v-tabs
          v-model="tab"
          background-color="transparent"
          color="basil"
          grow
          v-if="userType == 'AdministradorGlobal'"
        >
          <v-tab v-for="item in retItem" :key="item.id">
            {{ item.title }}
          </v-tab>
        </v-tabs>

        <!-- administracion global -->
        <v-tabs-items v-model="tab" v-if="userType == 'AdministradorGlobal'">
          <v-tab-item>
            <v-container>
              <v-row>
                <v-col sm="12">
                  <v-card-actions class="conte_masgen_space">
                    <v-btn class="conte_mas_space" @click="addNewCorp = true" icon
                      ><v-icon class="ico_mas_space">mdi-plus</v-icon> Agregar</v-btn
                    >
                    <v-dialog
                      v-model="addNewCorp"
                      width="700"
                      :retain-focus="false"
                    >
                      <plusCard
                        :dialogs="4"
                        :type_society="'Desarrollador'"
                        @close="closePlusCard"
                      ></plusCard>
                    </v-dialog>
                  </v-card-actions>
                  <v-container>
                    <v-row class="content">
                      <v-col sm="12" md="4" v-for="i in allCorp" :key="i.id">
                        <v-card>
                          <v-card-actions>
                          <v-icon>mdi-account-star</v-icon>
                          <v-spacer></v-spacer>
                            <span
                              ><b>Última actualización:</b><br />
                              {{ i.fechaDeValidacion }}</span
                            >
                            <v-spacer></v-spacer>
                            <v-btn
                              icon
                              @click="getInfoCorpAction(i.id)"
                              v-if="i.habilitar == 0"
                            >
                              <v-badge
                                content="1"
                                value="1"
                                color="green"
                                overlap
                              >
                                <v-icon large>
                                  mdi-eye
                                </v-icon>
                              </v-badge>
                            </v-btn>
                            <v-btn
                              icon
                              @click="getInfoCorpAction(i.id)"
                              v-if="i.habilitar != 0"
                            >
                              <v-icon large>
                                mdi-eye
                              </v-icon>
                            </v-btn>
                          </v-card-actions>
                          <v-img
                            :src="imgRoute + 'logos/' + i.nombre_es + '.jpg'"
                            class="white--text align-end img_space"
                            height="200px"
                            @click="getInfoCorpAction(i.id)"
                          >
                            <v-card-title class="titu-imagen-space">{{ i.corporativo }}</v-card-title>
                          </v-img>
                          <v-card-actions>
                            <v-list class="lista-space-card" style="text-align: left;">
                              <v-list-item-group
                                v-model="selectedItem"
                                color="primary"
                              >
                                <v-list-item class="item_space">
                                  <v-list-item-content>
                                    <v-list-item-title class="lista-space-nombre">
                                      ID-{{ i.id }}</v-list-item-title
                                    >
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item class="item_space">
                                  <v-list-item-content>
                                    <v-list-item-title class="lista-space-ciudad">
                                      {{ i.estado }}</v-list-item-title
                                    >
                                  </v-list-item-content>
                                </v-list-item>
                                <v-list-item class="item_space">
                                  <v-list-item-content>
                                    <v-list-item-title v-if="i.fechaDeValidacion != null" class="lista-space-ultima"><b>Última actualización:</b> {{
                                      i.fechaDeValidacion
                                    }}</v-list-item-title>
                                  </v-list-item-content>
                                </v-list-item>
                              </v-list-item-group>
                            </v-list>

                            <v-spacer></v-spacer>
                          </v-card-actions>
                          <v-dialog
                            v-model="getCorpInfo"
                            persistent
                            :retain-focus="false"
                          >
                            <getCorpInfo :id="infoToCorp" :users="users" />
                          </v-dialog>

                          <v-btn @click="deleteSocio(i.id)"
                            ><v-icon>mdi-delete</v-icon></v-btn
                          >
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-col>
              </v-row>
            </v-container>
          </v-tab-item>
          <!-- patrocinador -->
          <v-tab-item>
            <v-container>
              <v-row>
                <v-col sm="12">
                  <v-card-actions>
                    <v-btn @click="addNewPat = true" icon>
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                    <v-dialog
                      v-model="addNewPat"
                      width="700"
                      :retain-focus="false"
                    >
                      <plusCard
                        :dialogs="4"
                        :type_society="'Patrocinador'"
                        @close="closePlusCard"
                      ></plusCard>
                    </v-dialog>
                  </v-card-actions>
                  <v-container>
                    <v-row>
                      <v-col sm="12" md="4" v-for="i in allPat" :key="i">
                        <v-card>
                          <v-card-actions>
                          <v-icon>mdi-account-star</v-icon>
                          <v-spacer></v-spacer>
                            <span
                              ><b>Última actualización:</b><br />
                              {{ i.fechaDeValidacion }}</span
                            >

                            <v-spacer></v-spacer>
                          </v-card-actions>
                          {{ i.tipoDeSocio }} / {{ i.tipoDeSocio2 }}
                          <v-img
                            :src="imgRoute + '/logos/' + i.nombre_es + '.jpg'"
                            class="white--text align-end img_space"
                            height="200px"
                            @click="getInfoCorpAction(i.id)"
                          >
                            <v-card-title class="titu-imagen-space">{{ i.corporativo }}</v-card-title>
                          </v-img>
                          <v-card-actions>
                            <span
                              >Última actualización:<br />
                              {{ i.fechaDeValidacion }}</span
                            >

                            <v-spacer></v-spacer>
                          </v-card-actions>
                          <v-dialog
                            v-model="getCorpInfo"
                            persistent
                            :retain-focus="false"
                          >
                            <getCorpInfo
                              :id="infoToCorp"
                              :users="users"
                              :type="''"
                            />
                          </v-dialog>
                          <v-btn @click="deleteSocio(i.id)"
                            ><v-icon>mdi-delete</v-icon></v-btn
                          >
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-col>
              </v-row>
            </v-container>
          </v-tab-item>
        </v-tabs-items>

        <!-- administracion de corporativo socio/patrocinador-->
        <v-tabs-items
          v-model="tab"
          v-if="userType == 'Administrador' && corpOfUser != null"
        >
          <v-tab-item>
            <v-container>
              <v-row justify="center" align="center" align-content="center">
                {{ corpOfUser.corporativo }}
                <v-col sm="12">
                  <admin-corp :id_corp="corpOfUser.id" />
                </v-col>
              </v-row>
            </v-container>
          </v-tab-item>
        </v-tabs-items>

        <!-- administrador de parque -->
        <adminPark
          v-if="userType == 'AdministradorParque' && corpOfUser != null"
        />

        <!-- administrador de nave -->
        <adminNave
          v-if="userType == 'AdministradorDeNave' && corpOfUser != null"
        />
      </v-col>
    </v-container>
  </content>
</template>

<script>
import VueCookies from "vue-cookies";
import axios from "axios";
import headerAmpip from "../components/headerAmpip";
import Swal from "sweetalert2";
import getCorpInfo from "../components/corpinfo";
import adminPark from "../components/adminPark";
import adminNave from "../components/adminNave";
import profile from "../components/profile";
import plusCard from "../components/plusCard";
import adminCorp from "../components/adminCorp";
import GoogleCalendar from "../components/GoogleCalendar";

var CryptoJS = require("crypto-js");

export default {
  components: {
    plusCard,
    getCorpInfo,
    adminPark,
    adminNave,
    profile,
    adminCorp,
    headerAmpip,
    GoogleCalendar,
  },
  data() {
    return {
      update: 0,
      imgViewer: false,
      addNewCorp: false,
      config: false,
      getCorpInfo: false,
      infoToCorp: null,
      createCorpActive: false,
      datas: "",
      name: "",
      email: "",
      admin: false,
      date: null,
      menu: false,
      modal: false,
      tel: "",
      cel: "",
      addr: "",
      ex11: 0,
      userType: null,
      dialog: false,
      corp: {
        corp: "",
        name_es: "",
        name_en: "",
        rfc: "",
        address: "",
        cp: "",
        colonia: "",
        estado: "",
        municipio: "",
        tel: "",
        logo: "",
      },
      items: [
        { title: "Perfil", icon: "mdi-account" },
        { title: "parques", icon: "mdi-bank" },
        { title: "Naves", icon: " mdi-factory" },
      ],
      tab: 0,
      createUserActive: false,
      allCorp: {},
      allPat: [{ id: 1, nombre_es: "No hay nada por aqui" }],
      numberCorp: "",
      patro: "",
      corpOfUser: null,

      allParks: [],
      allNaves: [],
      allUser: [],
      createNaveActive: false,
      createParkActive: false,
      users: {},
      addNewPat: false,
      keysearch: "",
      getEvents: false,
    };
  },
  beforeCreate() {
    var key = VueCookies.get("id");
    if (key) {
      if (key != "") {
        var name = CryptoJS.AES.decrypt(VueCookies.get("name"), "ampip");
        this.name = name.toString(CryptoJS.enc.Utf8);

        var email = CryptoJS.AES.decrypt(VueCookies.get("email"), "ampip");
        this.email = email.toString(CryptoJS.enc.Utf8);

        var decripts = CryptoJS.AES.decrypt(key, "ampip");
        var originalText = decripts.toString(CryptoJS.enc.Utf8);
        this.id = originalText;
        var data = new URLSearchParams();
        data.append("id", this.id);

        axios
          .post(`${this.$store.state.url}/getdatauser`, data)
          .then((res) => {
            this.datas = res.data;
            this.$store.commit("adddata", res.data);
          })
          .catch((e) => console.log(e));

        data = new URLSearchParams();
        data.append("id", this.id);

        axios
          .post(`${this.$store.state.url}/getdatauser`, data)
          .then((res) => {
            this.admin = res.data.cargo;
            VueCookies.set(
              "user_type",
              CryptoJS.AES.encrypt(this.admin, "ampip").toString()
            );

            this.userType = res.data.cargo;
          })
          .catch((e) => console.log(e));

        let param = new URLSearchParams();
        param.append("id", originalText);
        axios
          .post(`${this.$store.state.url}/getparquesusuarios`, param)
          .then((res) => {
            let arr = [];
            for (let i = 0; i < res.data.length; i++) {
              arr.push(res.data[i].permiso);
            }
            this.$store.commit("addpermiso", arr);
          })
          .catch((e) => {
            console.log(e);
          });
      } else {
        this.$router.push("/Home");
      }
    } else {
      this.$router.push("/");
    }
  },
  beforeMount() {
    this.getAllCorp();
    this.getAllPat();
    let paramsCorps = new URLSearchParams();
    paramsCorps.append("query", "corp");

    setTimeout(() => {
      if (this.$store.state.data != null) {
        let params = new URLSearchParams();
        params.append("id", this.$store.state.data.key_corp);
        axios
          .post(`${this.$store.state.url}/corp`, params)
          .then((res) => {
            this.corpOfUser = res.data;
          })
          .catch((e) => console.log(e));
      } else {
        console.log("Vacio");
      }
    }, 1000);
  },
  methods: {
    getEventsButton() {
      this.getEvents = true;
    },
    adddataUser() {
      var id = CryptoJS.AES.decrypt(VueCookies.get("id"), "ampip");
      var params = new URLSearchParams();
      params.append("id", id.toString(CryptoJS.enc.Utf8));
      params.append("telefonoOfficina", this.tel);
      params.append("celular", this.cel);
      params.append("direccionDeOfficina", this.addr);
      params.append("cumpleanios", this.date);
      params.append("compartirDatos", this.ex11);

      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then((res) => console.log(res))
        .catch((e) => console.log(e));
    },
    closePlusCard() {
      this.addNewCorp = false;
      this.addNewPat = false;
    },

    addCorp() {
      var params = new URLSearchParams();
      params.append("corporativo", this.corp.corp);
      params.append("nombre_es", this.corp.name_es);
      params.append("nombre_en", this.corp.name_en);
      params.append("rfc", this.corp.rfc);
      params.append("direccion", this.corp.address);
      params.append("cp", this.corp.cp);
      params.append("colonia", this.corp.colonia);
      params.append("estado", this.corp.estado);
      params.append("municipio", this.corp.municipio);
      params.append("celular", this.corp.tel);
      params.append("logo", this.corp.logo);
      params.append("id", this.datas.id);

      if (
        this.corp.corp != "" &&
        this.corp.name_es != "" &&
        this.corp.name_en != "" &&
        this.corp.rfc != "" &&
        this.corp.address != "" &&
        this.corp.cp != "" &&
        this.corp.colonia != "" &&
        this.corp.estado != "" &&
        this.corp.municipio != "" &&
        this.corp.tel != "" &&
        this.corp.logo != ""
      ) {
        axios
          .post(`${this.$store.state.url}/createcorp`, params)
          .then((res) => {
            console.log(res);
          })
          .catch((e) => console.log(e));
      } else {
        alert("Por favor llene todos loc campos");
      }
    },

    getAllCorp() {
      let params = new URLSearchParams();
      params.append("query", 1);
      axios
        .post(`${this.$store.state.url}/getallcorp`, params)
        .then((res) => (this.allCorp = res.data))
        .catch((e) => console.log(e));
    },

    getAllPat() {
      let params = new URLSearchParams();
      params.append("query", 2);
      axios
        .post(`${this.$store.state.url}/getallcorp`, params)
        .then((res) => (this.allPat = res.data))
        .catch((e) => console.log(e));
    },

    logout() {
      VueCookies.remove("user_type");
      VueCookies.remove("id");
      VueCookies.remove("name");
      VueCookies.remove("email");
      VueCookies.remove("key_corp");
      this.$router.push("/");
    },

    getInfoCorpAction(id) {
      this.$store.commit("setIdCorp", id);
      this.$router.push("corporativos");
    },

    getallParks(id) {
      let paramsNaves = new URLSearchParams();
      paramsNaves.append("id", id);
      axios
        .post(`${this.$store.state.url}/getallpark`, paramsNaves)
        .then((res) => (this.allParks = res.data))
        .catch((e) => console.log(e));
    },

    getallNaves(id) {
      let paramsNaves = new URLSearchParams();
      paramsNaves.append("id", id);
      axios
        .post(`${this.$store.state.url}/getallnave`, paramsNaves)
        .then((res) => (this.allNaves = res.data))
        .catch((e) => console.log(e));
    },

    // eslint-disable-next-line vue/no-dupe-keys
    addNewCorps() {
      this.$store.commit("setTypeSociety", "Desarrollador");
    },

    addNewPats() {
      this.$store.commit("setTypeSociety", "Patrocinador");
    },

    setProfileActionModel() {
      this.$store.commit("changeProfileDialog");
    },

    key_search() {
      var corps = this.allCorp;
      this.allCorp = [];
      if (this.keysearch.length > 0) {
        corps.map((i) => {
          let name = i.nombre_es;
          if (name.search(this.keysearch) != -1) {
            console.log(i.nombre_es + "<-------------------------");
            this.allCorp.push(i);
          }
        });
      } else {
        this.getAllCorp();
      }
    },
    deleteSocio(id) {
      Swal.fire({
        title: "¿Estas seguro de esta accion?",
        showDenyButton: true,
        confirmButtonText: `Si`,
        denyButtonText: `No`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          var params = new URLSearchParams();
          params.append("id", id);
          params.append("type", "i");
          params.append("table", "c");
          axios
            .post(`${this.$store.state.url}/activeinactive`, params)
            .then((res) => {
              console.log(res);
              Swal.fire("Listo!", "", "success");
              this.$router.push("/");
            })
            .catch((e) => {
              console.log(e);
            });
        }
      });
    },
  },
  computed: {
    retItem() {
      if (this.userType == "AdministradorGlobal") {
        return [
          { title: "Socios", icon: "mdi-account" },
          { title: "Patrocinadores", icon: " mdi-factory" },
        ];
      } else if (this.userType == "Administrador") {
        return [{ title: "Corporativo", icon: "mdi-account" }];
      } else if (this.userType == "Administrador de nave") {
        return [{ title: "Nave", icon: "mdi-account" }];
      } else {
        return [{ title: "Parque", icon: "mdi-account" }];
      }
    },

    saludo() {
      var momentoActual = new Date();
      var hora = momentoActual.getHours();
      var user = CryptoJS.AES.decrypt(VueCookies.get("name"), "ampip").toString(
        CryptoJS.enc.Utf8
      );
      if (user != "") {
        if (hora > 13) {
          return "  Hola, " + user;
        } else if (hora > 19) {
          return "  Hola, " + user;
        } else {
          return "  Hola, " + user;
        }
      } else {
        return "Por favor da clic a la imagen y completa tus datos";
      }
    },

    imgRoute() {
      return `${this.$store.state.img}/`;
    },

    getProfileActionModel() {
      return this.$store.state.profileDialog;
    },

    getImageProfile() {
      return `${this.$store.state.img}/perfil/${this.$store.state.data.id}.jpg`;
    },
  },
};
</script>
<style scoped>
.saludo {
  margin-left: 0.5em;
}
.containerCon {
  height: 300px;
}
.containerCon::-webkit-scrollbar {
  width: 8px; /* Tamaño del scroll en vertical */
  height: 8px; /* Tamaño del scroll en horizontal */
  display: none; /* Ocultar scroll */
}

/* Ponemos un color de fondo y redondeamos las esquinas del thumb */
.containerCon::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 4px;
}

/* Cambiamos el fondo y agregamos una sombra cuando esté en hover */
.containerCon::-webkit-scrollbar-thumb:hover {
  background: #b3b3b3;
  box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
}

/* Cambiamos el fondo cuando esté en active */
.containerCon::-webkit-scrollbar-thumb:active {
  background-color: #999999;
}

/* Ponemos un color de fondo y redondeamos las esquinas del track */
.containerCon::-webkit-scrollbar-track {
  background: #e1e1e1;
  border-radius: 4px;
}

/* Cambiamos el fondo cuando esté en active o hover */
.containerCon::-webkit-scrollbar-track:hover,
.containerCon::-webkit-scrollbar-track:active {
  background: #d4d4d4;
}

.fixed-content {
  top: 0;
  bottom: 0;
  position: fixed;
  overflow-y: scroll;
  overflow-x: hidden;
}

.search {
  transform: scale(0.7);
}

.iframes{
    width: 100%;
    height: 10000px !important;
  }
</style>
