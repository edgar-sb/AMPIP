<template>
  <content>
    <v-card-actions>
      <v-btn icon @click="getTab" v-if="tab != 2">
        <v-icon>mdi-plus</v-icon>
        <v-dialog width="500" v-model="addUser">
          <v-card>
            <v-card-title>
              Usuario
            </v-card-title>
            <v-container>
              <v-row>
                <v-col sm="12">
                  <v-text-field
                    outlined
                    label="Nombre"
                    v-model="dataUser.name"
                  ></v-text-field>
                </v-col>
                <v-col sm="12">
                  <v-text-field
                    outlined
                    label="Apellido Paterno"
                    v-model="dataUser.lastName"
                  ></v-text-field>
                </v-col>
                <v-col sm="12">
                  <v-text-field
                    outlined
                    label="Apellido Materno"
                    v-model="dataUser.last"
                  ></v-text-field>
                </v-col>
                <v-col sm="12">
                  <v-text-field
                    outlined
                    label="Correo"
                    v-model="dataUser.email"
                  ></v-text-field>
                </v-col>
                <v-col sm="12">
                  <v-select
                    outlined
                    v-model="permiso"
                    :items="permisos"
                    label="Seleccionar permisos"
                    multiple
                    hint="Permisos de informacion en el parque"
                    persistent-hint
                  ></v-select>
                </v-col>
              </v-row>
            </v-container>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="red" @click="closeAction" text>Cerrar</v-btn>
              <v-btn color="green darken-1" text @click="addUserAction">
                Agregar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog width="700" persistent v-model="addNave">
          <plusCard
            dialogs="1"
            @close="closePlusCard"
            :id="parque.id"
          ></plusCard>
        </v-dialog>
      </v-btn>
    </v-card-actions>
    <v-card-text>
      <v-tabs v-model="tab">
        <v-tab>
          Usuarios
        </v-tab>
        <v-tab>
          Inquilinos
        </v-tab>
        <v-tab>
          Informacion
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-container>
            <v-row>
              <v-col sm="12" md="3" v-for="(i, key) in users_parqs" :key="key">
                <v-card>
                  <v-card-title>{{ i.fullName }}</v-card-title>
                  <v-card-text>
                    {{ i.email }}
                  </v-card-text>
                  <v-card-actions>
                    <v-btn icon @click="openDialog(i)">
                      <v-icon>
                        mdi-eye
                      </v-icon>
                    </v-btn>
                    <v-dialog width="300" persistent v-model="data_user">
                      <infoCard
                        :type="'user_from_parq'"
                        :id="data_to_info"
                        @close="closePlusCard"
                      ></infoCard>
                    </v-dialog>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-tab-item>
        <v-tab-item>
          <v-container>
            <v-row>
              <v-col sm="12" md="3" v-for="(i, k) in naves" :key="k">
                <v-card>
                  <v-card-title>
                    {{ i.name }}
                  </v-card-title>
                  <v-card-actions>
                    <v-btn icon @click="viewNave(i.id)">
                      <v-icon>mdi-eye</v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-tab-item>
        <v-tab-item>
          <v-container>
            <v-row>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Nombre del parque en (Español)"
                  outlined
                  v-model="parque.nombre_es"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Nombre del parque en (Ingles)"
                  outlined
                  v-model="parque.nombre_es"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Administrador del parque"
                  outlined
                  v-model="parque.adminParq"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Propietario del parque"
                  outlined
                  v-model="parque.parqProp"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Ubicacion"
                  outlined
                  v-model="parque.parqIntoParq"
                  @focus="focs"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6" v-if="editUb">
                <v-text-field
                  label="Ubicacion"
                  outlined
                  v-model="parque.parqIntoParq"
                  @focus="focs"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Region"
                  outlined
                  v-model="parque.region"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Mercado"
                  outlined
                  v-model="parque.mercado"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Tipo de industria"
                  outlined
                  v-model="parque.tipoDeIndustria"
                ></v-text-field>
              </v-col>
              <v-col sm="12">
                <span>Superficies</span>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Superficie total"
                  outlined
                  v-model="parque.superficieTotal"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Superficie urbanizada"
                  outlined
                  v-model="parque.superficieUrban"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Superficie ocupada"
                  outlined
                  v-model="parque.superficieOcup"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Superficie disponible"
                  outlined
                  v-model="parque.superficieDisp"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Tipo de propiedad"
                  outlined
                  v-model="parque.tipoDePropiedad"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Inicio de operaciones"
                  outlined
                  v-model="parque.inicioOperaciones"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Numero de empleados"
                  outlined
                  v-model="parque.numEmpleados"
                ></v-text-field>
              </v-col>
              <v-col sm="12">
                <span>Detalles</span>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Reconocimientos"
                  outlined
                  v-model="parque.reconocimientoPracticas"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Infraestructura"
                  outlined
                  v-model="parque.ifraestructura"
                ></v-text-field>
              </v-col>
              <v-col sm="12">
                <span>Contacto</span>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Nombre de contacto"
                  outlined
                  v-model="parque.contactName"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-text-field
                  label="Email"
                  outlined
                  v-model="parque.contactEmail"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-btn @click="updatePark">Guardar Informacion</v-btn>
            </v-card-actions>
          </v-container>
        </v-tab-item>
      </v-tabs-items>
    </v-card-text>
  </content>
</template>
<script>
/*
 */
import infoCard from "../components/infoCard";
import axios from "axios";
import plusCard from "../components/plusCard";
import Swal from "sweetalert2";
export default {
  name: "parque",
  data() {
    return {
      tab: 0,
      parque: [],
      addUser: null,
      addNave: null,
      permisos: ["Eliminar", "Editar", "Agregar"],
      dataUser: {
        name: "",
        lastName: "",
        last: "",
        email: "",
      },
      users_parqs: "",
      data_to_info: "",
      data_user: false,
      naves: null,
      editUb: false,
    };
  },
  beforeMount() {
    let params = new URLSearchParams();
    params.append("id", this.$store.state.parque);
    axios
      .post(`${this.$store.state.url}/getpark`, params)
      .then((res) => {
        this.parque = res.data[0];
        this.getUserFromPark(res.data[0].id);
        this.getallnaves(res.data[0].key_corp);
      })
      .catch((e) => console.log(e));
  },
  methods: {
    getTab() {
      switch (this.tab) {
        case 0:
          this.addUser = true;
          break;
        case 1:
          this.addNave = true;
      }
    },
    closeAction() {
      this.addUser = false;
      this.addNave = false;
    },
    addUserAction() {
      let params = new URLSearchParams();
      params.append(
        "fullname",
        `${this.dataUser.name} ${this.dataUser.lastName} ${this.dataUser.last}`
      );
      params.append("email", this.dataUser.email);

      var ctx = this;
      axios
        .post(`${this.$store.state.url}/createuser`, params)
        .then((res) => {
          if (res.data.message) {
            let par = new URLSearchParams();
            par.append("email", ctx.dataUser.email);
            par.append("pass", ctx.dataUser.password);
            axios
              .post(`${this.$store.state.url}/getuseridlogin`, par)
              .then((res) => {
                ctx.createdataUser(res.data);
              })
              .catch((e) => console.log(e));
          }
        })
        .catch((e) => console.log(e));
    },
    createdataUser(id) {
      let params = new URLSearchParams();
      params.append("id", id[0].id);
      params.append("charge", "Administrador");
      params.append("habilitar", 1);
      params.append("key_corp", this.$store.state.data.key_corp);
      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then(() => {
          Swal.fire("Usuario agregado Puede cerrar esta pantalla");
        })
        .catch((e) => console.log(e));
      axios.get(
        `${this.$store.state.baseUrl}/mailler?email=${this.dataUser.email}&name=${this.dataUser.name}&link=${id[0].id}`
      );
      var paramsDos = new URLSearchParams();
      paramsDos.append("idUser", id[0].id);
      paramsDos.append("idParque", this.$store.state.parque);
      paramsDos.append("permiso", this.permiso);
      axios
        .post(`${this.$store.state.url}/setpermisos`, paramsDos)
        .then((res) => {
          console.log(res.data);
        })
        .catch((e) => console.log(e));
    },
    getUserFromPark(id) {
      let params = new URLSearchParams();
      params.append("query", 2);
      params.append("id_parque", id);
      axios
        .post(`${this.$store.state.url}/getparquesusuarios`, params)
        .then((res) => {
          this.users_parqs = res.data;
        })
        .catch((e) => console.log(e));
    },
    closePlusCard() {
      this.addNave = false;
      this.data_user = false;
    },
    openDialog(i) {
      this.data_user = true;
      this.data_to_info = i;
    },
    getallnaves(id) {
      let params = new URLSearchParams();
      params.append("id", id);
      axios
        .post(`${this.$store.state.url}/getallnaveforpark`, params)
        .then((res) => (this.naves = res.data))
        .catch((e) => console.log(e));
    },
    viewNave(id) {
      this.$store.commit("setNave", id);
      this.$router.push("/nave");
    },
    focs() {
      this.editUb = true;
    },
    updatePark() {
      let params = new URLSearchParams();
      params.append("nombre_es", this.parque.nombre_es);
      params.append("nombre_en", this.parque.nombre_es);
      params.append("adminParq", this.parque.adminParq);
      params.append("adminParq", this.parque.parqProp);
      params.append("adminParq", this.parque.parqIntoParq);
      params.append("adminParq", this.parque.region);
      params.append("adminParq", this.parque.mercado);
      params.append("adminParq", this.parque.tipoDeIndustria);
      params.append("adminParq", this.parque.adminParq);
      params.append("adminParq", this.parque.tipoDePropiedad);
      params.append("adminParq", this.parque.reconocimientoPracticas);
      params.append("adminParq", this.parque.ifraestructura);
      params.append("adminParq", this.parque.contactName);
      params.append("adminParq", this.parque.contactEmail);
    },
  },
  components: { plusCard, infoCard },
};
</script>
