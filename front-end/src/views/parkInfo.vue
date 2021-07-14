<template>
  <content>
    <v-card-actions>
      <v-btn @click="back" icon>
        <v-icon color="red">
          mdi-arrow-left-bold
        </v-icon>
      </v-btn>

      <v-btn icon @click="getTab" v-if="tab != 3">
        <v-icon>mdi-plus</v-icon>
        <v-dialog width="700" v-model="addUser" :retain-focus="false">
          <v-card>
            <v-card-title>
              Usuario
              <v-spacer></v-spacer>
              <v-btn icon @click="closeAction">
                <v-icon>mdi-window-close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    outlined
                    label="Nombre *"
                    v-model="dataUser.name"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    outlined
                    label="Apellido Paterno *"
                    v-model="dataUser.lastName"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    outlined
                    label="Apellido Materno *"
                    v-model="dataUser.last"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field
                    outlined
                    label="Correo"
                    v-model="dataUser.email"
                    :rules="[rules.required, rules.email]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-select
                    outlined
                    v-model="permiso"
                    :items="permisos"
                    label="Seleccionar permisos *"
                    multiple
                    hint="Permisos de información en el parque"
                    persistent-hint
                  ></v-select>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn @click="closeAction" text>Cerrar</v-btn>
              <v-btn @click="addUserAction">
                Agregar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog
          width="700"
          persistent
          v-model="addNave"
          :retain-focus="false"
        >
          <plusCard
            dialogs="1"
            @close="closePlusCard"
            :id="parque.id"
          ></plusCard>
        </v-dialog>
      </v-btn>
    </v-card-actions>
    <v-card-text>
      <v-tabs v-model="tab" class="btn_sec-space" background-color="transparent" color="basil" grow>
        <v-tab class="link_sec-space" v-if="parque.nombre_es != 'Naves sin parques'">
          Usuarios
        </v-tab>
        <v-tab class="link_sec-space">
          Inquilinos
        </v-tab>
        <v-tab class="link_sec-space">
          Espacio disponible
        </v-tab>
        <v-tab class="link_sec-space" v-if="parque.nombre_es != 'Naves sin parques'">
          Información
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <!-- Usuarios -->
        <v-tab-item v-if="parque.nombre_es != 'Naves sin parques'">
          <v-container>
            <v-row>
              <v-col sm="12" md="3" v-for="(i, key) in users_parqs" :key="key">
                <v-card v-if="i.fullName">
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
                    <v-btn icon @click="activeinactiveAction('u', i.id)">
                      <v-icon> mdi-delete</v-icon>
                    </v-btn>
                    <v-dialog
                      width="300"
                      persistent
                      v-model="data_user"
                      :retain-focus="false"
                    >
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
        <!-- inquilinos -->
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
                    <v-btn icon @click="activeinactiveAction('n', i.id)">
                      <v-icon> mdi-delete</v-icon>
                    </v-btn>
                    <!-- isAmpip -->
                    <v-btn
                      icon
                      @click="addUserToNaveAction(i.id)"
                      v-if="i.isAmpip == null"
                    >
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                    <v-dialog
                      width="700"
                      v-model="addUserToNave"
                      :retain-focus="false"
                    >
                      <plusCard
                        :dialogs="6"
                        :id="i"
                        @close="closePlusCard"
                      ></plusCard>
                    </v-dialog>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-tab-item>
        <!-- Espacio disponible -->
        <v-tab-item>
          <v-container>
            <v-row>
              <v-col cols="12" md="4" v-for="(i, key) in spacesAll" :key="key">
                <v-card>
                  <v-card-title>
                    {{ JSON.parse(i.extras).name }}
                    <v-spacer>$ {{ i.precio_promedio }}</v-spacer>
                  </v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="inactiveSpace(i.id)">
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
            <!-- dialogo agregar espacio -->
            <v-dialog
              persistent
              width="700"
              v-model="addSpace"
              :retain-focus="false"
            >
              <plusCard
                :dialogs="7"
                :id="[parque.id, parque.key_corp]"
                @close="closePlusCard"
              ></plusCard>
            </v-dialog>
          </v-container>
        </v-tab-item>
        <!-- Informacion -->
        <v-tab-item v-if="parque.nombre_es != 'standalone'">
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
                  v-model="parque.nombre_en"
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
              <v-col sm="12" md="6" v-if="editUb">
                <v-text-field
                  label="Ubicacion"
                  outlined
                  v-model="parque.parqIntoParq"
                  @focus="focs"
                ></v-text-field>
              </v-col>
              <v-col sm="12" md="6">
                <v-select
                  :items="regiones"
                  label="Región"
                  outlined
                  v-model="parque.region"
                ></v-select>
              </v-col>
              <v-col sm="12" md="6">
                <v-select
                  :items="mercados"
                  label="Mercado"
                  outlined
                  v-model="parque.mercado"
                  :value="Mercados"
                ></v-select>
              </v-col>
              <v-col sm="12">
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
                <v-select
                  :items="items"
                  label="Tipo de Propiedad"
                  outlined
                  v-model="parque.tipoDePropiedad"
                ></v-select>
              </v-col>
              <v-col sm="12">
                <v-text-field
                  label="Número de empleados"
                  outlined
                  v-model="parque.numEmpleados"
                ></v-text-field>
              </v-col>
              <v-col sm="12">
                <span>Detalles</span>
              </v-col>

              <v-col sm="6">
                <span
                  >Reconocimientos: {{ parque.reconocimientoPracticas }}</span
                >
              </v-col>
              <v-col sm="6">
                <span>Infraestructura: {{ parque.ifraestructura }}</span>
              </v-col>
              <v-col sm="12" md="6">
                <v-select
                  v-model="newRecords"
                  :items="records"
                  attach
                  chips
                  outlined
                  label="Reconocimientos"
                  multiple
                ></v-select>
              </v-col>

              <v-col sm="12" md="6">
                <v-select
                  v-model="newInfra"
                  :items="infraList"
                  attach
                  chips
                  outlined
                  label="Infraestructura"
                  multiple
                ></v-select>
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
              <v-btn @click="updatePark" class="card_space_general">Guardar Información</v-btn>
            </v-card-actions>
          </v-container>
        </v-tab-item>
      </v-tabs-items>
    </v-card-text>
  </content>
</template>
<script>
import infoCard from "../components/infoCard";
import axios from "axios";
import plusCard from "../components/plusCard";
import Swal from "sweetalert2";
export default {
  name: "parque",
  data() {
    return {
      tab: 1,
      parque: [],
      addUser: null,
      addNave: null,
      addSpace: null,
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
      mercados: [
        "productos de consumo",
        "productos de uso o inversión",
        "productos industriales",
        "servicios",
        "financieros",
        "distribuidores",
        "compradores industriales",
      ],
      regiones: [
        "Región Noroeste",
        "Región Noreste",
        "Región Occidente",
        "Región Oriente",
        "Región Centronorte",
        "Región Centrosur",
        "Región Suroeste",
        "Región Sureste",
      ],
      items: ["Privado", "Público"],
      records: [
        "Norma Mexiana de Parque Industrial",
        "Parque Industrial Verde",
        "Calidad Ambiental (PROFEPA)",
        "Parque Industrial Sustentable",
        "Parque Industrial Limpio",
        "Parque Industrial Seguro",
        "OEA",
      ],
      infraList: [
        "Al menos 0.5 litros agua por segundo por ha",
        "Pavimento",
        "Banquetas",
        "Drenaje Sanitario",
        "Drenaje Pluvial",
        "Planta de tratamiento de Agua",
        "Gas Natural",
        "Alumbrado público",
        "Instalación eléctrica",
        "Subestación eléctrica",
        "Telefonía",
        "Comunicación Satelital",
        "Instalación Digital",
        "Espuela de Ferrocarril",
        "Estación de bomberos",
        "Áreas verdes o recreativas",
        "Guardería",
        "Centro de Capacitación",
        "Seguridad",
        "Transporte interno de personal",
        "Transporte Urbano",
        "Recolección de basura",
        "Aduana interna",
        "Agente aduanal",
        "Servicios de consultoria",
        "Programa shelter",
        "Servicio Built to suit",
        "Reglamento interno",
        "Oficinas administrativas",
      ],
      newInfra: null,
      newRecords: null,
      addUserToNave: false,
      spacesAll: null,
      rules: {
        required: (value) => !!value || "Requerido.",
        email: (value) => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Ingresa un correo valido.";
        },
      },
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
        this.getallspacesAction(res.data[0].id);
      })
      .catch((e) => console.log(e));
  },
  methods: {
    getTab() {
      if (this.parque.nombre_es == "standalone") {
        switch (this.tab) {
          case 0:
            this.addNave = true;
            break;
          case 1:
            this.addSpace = true;
        }
      } else {
        switch (this.tab) {
          case 0:
            this.addUser = true;
            break;
          case 1:
            this.addNave = true;
            break;
          case 2:
            this.addSpace = true;
        }
      }
    },
    closeAction() {
      this.addUser = false;
      this.addNave = false;

      this.getUserFromPark(this.parque.id);
      this.getallnaves(this.parque.key_corp);
      this.getallspacesAction(this.parque.id);
    },
    addUserAction() {
      let jsons = [];
      this.permiso.map((i)=>{
        let perm = {i:i};
        jsons.push(perm);
      })
      console.log(jsons)
      if (
        this.dataUser.name != "" &&
        this.dataUser.lastName != "" &&
        this.dataUser.last != "" &&
        this.dataUser.email != "" &&
        this.permiso != null
      ) {
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
            if (res.data.message != 0) {
              let par = new URLSearchParams();
              par.append("email", ctx.dataUser.email);
              par.append("pass", ctx.dataUser.password);
              axios
                .post(`${this.$store.state.url}/getuseridlogin`, par)
                .then((res) => {
                  ctx.createdataUser(res.data);
                })
                .catch((e) => console.log(e));
            } else {
              Swal.fire({ text: "Correo electronico en uso", icon: "error" });
            }
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({
          icon: "error",
          title: "Ooops ...",
          text: "Por favor asegurate de llenar todos los datos",
        });
      }
    },
    createdataUser(id) {
      let params = new URLSearchParams();
      params.append("id", id[0].id);
      params.append("charge", "AdministradorParque");
      params.append("habilitar", 1);
      params.append("key_corp", this.$store.state.data.key_corp);
      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then(() => {
          this.closeAction();
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
      this.addUserToNave = false;
      this.addSpace = false;
      this.getUserFromPark(this.parque.id);
      this.getallnaves(this.parque.key_corp);
      this.getallspacesAction(this.parque.id);
    },
    openDialog(i) {
      this.data_user = true;
      this.data_to_info = i;
    },
    getallnaves() {
      let params = new URLSearchParams();
      params.append("id", this.$store.state.parque);
      axios
        .post(`${this.$store.state.url}/getnavebyparque`, params)
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
      let infra, records;

      if (this.newRecords != null) {
        records = this.newRecords;
      } else {
        records = this.parque.reconocimientoPracticas;
      }

      if (this.newInfra != null) {
        infra = this.newInfra;
      } else {
        infra = this.parque.ifraestructura;
      }

      let params = new URLSearchParams();
      params.append("id", this.parque.id);
      params.append("nombre_es", this.parque.nombre_es);
      params.append("nombre_en", this.parque.nombre_en);
      params.append("adminParq", this.parque.adminParq);
      params.append("parqProp", this.parque.parqProp);
      params.append("parqIntoParq", this.parque.parqIntoParq);
      params.append("region", this.parque.region);
      params.append("mercado", this.parque.mercado);
      params.append("tipoDeIndustria", this.parque.tipoDeIndustria);
      params.append("adminParq", this.parque.adminParq);
      params.append("tipoDePropiedad", this.parque.tipoDePropiedad);
      params.append("reconocimientoPracticas", records);
      params.append("ifraestructura", infra);
      params.append("contactName", this.parque.contactName);
      params.append("contactEmail", this.parque.contactEmail);
      params.append("numEmpleados", this.parque.numEmpleados);
      params.append("superficieTotal", this.parque.superficieTotal);
      params.append("date", null);

      axios
        .post(`${this.$store.state.url}/updatepark`, params)
        .then(() => {
          Swal.fire(
            "Este cambio debe ser aprobado por el administrador. Te notificaremos cuando tus cambios hayan sido aprobados."
          );
        })
        .catch((e) => console.log(e));
    },
    back() {
      this.$router.push("/");
    },
    addUserToNaveAction(id) {
      this.$store.commit("setParqueOfUser", id);
      this.addUserToNave = true;
    },
    getallspacesAction(id) {
      let params = new URLSearchParams();
      params.append("query", 3);
      params.append("id", id);
      axios
        .post(`${this.$store.state.url}/espacio`, params)
        .then((res) => (this.spacesAll = res.data))
        .catch((e) => console.log(e));
    },
    inactiveSpace(id) {
      const swalWithBootstrapButtons = Swal.mixin();

      swalWithBootstrapButtons
        .fire({
          title: "¿Esta seguro de esta acción?",
          text: "Esta apunto de eliminar!",
          showCancelButton: true,
          confirmButtonText: "Si!",
          cancelButtonText: "Cancelar",
          reverseButtons: true,
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger",
        })
        .then((result) => {
          if (result.isConfirmed) {
            let params = new URLSearchParams();
            params.append("type", "i");
            params.append("table", "s");
            params.append("id", id);
            axios
              .post(`${this.$store.state.url}/activeinactive`, params)
              .then((res) => {
                if (res.data.message == "Desactivado") {
                  Swal.fire({ text: "Listo", icon: "success" });
                  this.getallspacesAction(this.$store.state.parque);
                } else {
                  Swal.fire({ text: "Algo salio mal", icon: "error" });
                }
              })
              .catch((e) => console.log(e));
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire("Cancelado", "...", "error");
          }
        });
    },
    activeinactiveAction(table , id) {
      let params = new URLSearchParams();
      params.append("type", "i");
      params.append("table", table);
      params.append("id", id);
      axios
        .post(`${this.$store.state.url}/activeinactive`, params)
        .then(() => console.log(
          Swal.fire({text: "Listo", icon: "success"})
        ))
        .catch((e) => console.log(e));
    },
  },
  components: { plusCard, infoCard },
};
</script>
