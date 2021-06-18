<template>
  <content>
    <!-- La app-bar se mostrara en todos los usuarios sin importar su acceso -->
    <v-app-bar>
      <v-toolbar-title small>
        <label>{{ saludo }}</label>
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn text @click="setProfileActionModel" id="more">
        oPcIoNeS
        <v-dialog v-model="getProfileActionModel" width="700" persistent :retain-focus="false">
          <profile />
        </v-dialog>
      </v-btn>
    </v-app-bar>

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
                  <v-card-actions>
                    <v-btn @click="addNewCorp = true" icon
                      ><v-icon>mdi-plus</v-icon></v-btn
                    >
                    <v-dialog v-model="addNewCorp" width="700" :retain-focus="false">
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
                            <span
                              >Ultima actualizacion:<br />
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
                            class="white--text align-end"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                            height="200px"
                          >
                            <v-card-title>{{ i.corporativo }}</v-card-title>
                          </v-img>
                          <v-dialog v-model="getCorpInfo" persistent :retain-focus="false">
                            <getCorpInfo :id="infoToCorp" :users="users" />
                          </v-dialog>
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-col>
              </v-row>
            </v-container>
          </v-tab-item>
          <v-tab-item>
            <v-container>
              <v-row>
                <v-col sm="12">
                  <v-card-actions>
                    <v-btn @click="addNewPat = true" icon>
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                    <v-dialog v-model="addNewPat" width="700" :retain-focus="false">
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
                            <span
                              >Ultima actualizacion:<br />
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
                            :src="imgRoute + '/logos/' + i.nombre_es + '.jpg'"
                            class="white--text align-end"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                            height="200px"
                          >
                            <v-card-title>{{ i.corporativo }}</v-card-title>
                          </v-img>
                          <v-dialog v-model="getCorpInfo" persistent :retain-focus="false">
                            <getCorpInfo
                              :id="infoToCorp"
                              :users="users"
                              :type="''"
                            />
                          </v-dialog>
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

import getCorpInfo from "../components/corpinfo";
import adminPark from "../components/adminPark";
import adminNave from "../components/adminNave";
import profile from "../components/profile";
import plusCard from "../components/plusCard";
import adminCorp from "../components/adminCorp";
var CryptoJS = require("crypto-js");

export default {
  components: {
    plusCard,
    getCorpInfo,
    adminPark,
    adminNave,
    profile,
    adminCorp,
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
          return "  Buenas tardes, " + user;
        } else if (hora > 19) {
          return "  Buenas noches, " + user;
        } else {
          return "  Buenos dias, " + user;
        }
      } else {
        return "Por favor pincha la imagen y completa tus datos";
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
</style>
