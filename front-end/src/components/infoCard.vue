<template>
  <componen>
    <v-card v-if="type == 'user'">
      <v-card-title>
        Usuario
        <v-spacer></v-spacer>
        <v-btn icon @click="emitsClose">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text v-if="id.direccionDeOfficina">
        <v-row>
          <v-col cols="12" sm="12">
            <v-img
              :src="imgRoute + '/perfil/' + id.id + '.jpg'"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.0), rgba(0,0,0,.0)"
              height="200px"
            ></v-img>
          </v-col>
          <v-col cols="12" sm="12">
            <v-container>
              <v-row>
                <v-col cols="12" sm="12" md="6" class="card_space">
                  Cargo: <br>
                  <span>{{ id.cargo }}</span>
                </v-col>
                <v-col cols="12" sm="12" md="6" class="card_space">
                  Teléfono de oficina: <br>
                  <span>{{ id.telefonoOfficina }}</span>
                </v-col>

                <v-col cols="12" sm="12" md="6" class="card_space_sencillo">
                  Teléfono personal: <br>
                  <span>{{ id.celular }}</span>
                </v-col>

                <v-col cols="12" sm="12" md="6" class="card_space_sencillo">
                  Cumpleaños: <br>
                  <span>{{ id.cumpleanios }}</span>
                </v-col>

                <v-col cols="12" sm="12" class="card_space">
                  Dirección de oficina: <br>
                  <span>{{ id.direccionDeOfficina }}</span>
                </v-col>
              </v-row>
            </v-container>
          </v-col>
        </v-row>
      </v-card-text>

      <v-text v-if="!id.direccionDeOfficina" class="card_space_alerta">
        <span>El usuario aún no completa sus datos</span>
      </v-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="reset(id.id_A)" class="card_space_reenviar">Reenviar contraseña</v-btn>
        <v-btn @click="emitsClose" class="card_space_cerrar">Cerrar</v-btn>
      </v-card-actions>
    </v-card>

    <v-card v-if="type == 'park'">
      <v-card-title>
        Parque
        <v-spacer></v-spacer>
        <v-btn icon @click="emitsClose">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.nombre_es"
              label="Nombre de parque (Español)"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.nombre_en"
              label="Nombre de parque (Inglés)"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.parqProp"
              label="Propietario"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.region"
              label="Región"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.mercado"
              label="Mercado"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.tipoDeIndustria"
              label="Tipo de industria"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.superficieOcup"
              label="Superficie ocupada"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.superficieUrban"
              label="Superficie urbanizada"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.superficieDisp"
              label="Superficie disponible"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.tipoDePropiedad"
              label="Tipo de propiedad"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.numEmpleados"
              label="Numero de empleados"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.reconocimientoPracticas"
              label="Reconocimiento a mejores practicas"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.ifraestructura"
              label="Infraestructura"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              v-model="id.contactName"
              label="Nombre de contacto"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12">
            <v-text-field
              outlined
              v-model="id.contactEmail"
              label="Email"
              disabled
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="updatePark" class="card_space_aprobar" v-if="id.data == 'null'">Aprobar</v-btn>
        <v-btn @click="emitsClose" class="card_space_cerrar">Cancelar</v-btn>
      </v-card-actions>
    </v-card>

    <v-card v-if="type == 'nave'">
      <v-card-title>
        Inquilino
        <v-spacer></v-spacer>
        <v-btn icon @click="emitsClose">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Nombre de inquilino en (Español)"
              disabled
              v-model="id.nombre_es"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Nombre de inquilino en (Inglés)"
              v-model="id.nombre_en"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Propietario"
              v-model="id.propietario"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Empresa"
              v-model="id.nombreEmpresa"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Número de empleados"
              v-model="id.numEmpleados"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="País de origen"
              v-model="id.paisOrigen"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Producto insignia"
              v-model="id.productoInsignia"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Sector empresarial"
              disabled
              v-model="id.sectorEmpresarial"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Años de antigüedad"
              v-model="id.antiguedad"
              disabled
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="emitsClose" class="card_space_cerrar">Cerrar</v-btn>
      </v-card-actions>
    </v-card>

    <v-card v-if="type == 'user_from_parq'">
      <v-card-title>Permisos:</v-card-title>
      <v-card-text>
        <span>El usuario {{ id.fullName }} tiene los siguientes permisos</span>
        <br />
        <span> ' {{ id.permisos }} '</span>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="closeInfo">Cerrar</v-btn>
      </v-card-actions>
    </v-card>

    <v-card v-if="type == 'space'">
      <v-card-title>Espacio diponible contacto y detalles</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" md="6" class="card_space">
            <label>Nombre: </label><br>
            <span>{{ JSON.parse(id.extras).name }}</span>
          </v-col>
          <v-col cols="12" md="6" class="card_space">
            <label>Teléfono: </label><br>
            <span>{{ JSON.parse(id.extras).phone }}</span>
          </v-col>
          <v-col cols="12" md="6" class="card_space_sencillo">
            <label>Medidas: </label><br>
           <span> {{ JSON.parse(id.extras).medidas[0] }} x
            {{ JSON.parse(id.extras).medidas[1] }}</span>
          </v-col>

          <v-col cols="12" md="6" class="card_space_sencillo">
            <label>Tipo: </label><br>
            <span>{{ id.tipo }}</span>
          </v-col>

          <v-col cols="12" class="card_space">
            <label>Uso: </label><br>
            <span>{{ id.uso }}</span>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="closeInfo" class="card_space_cerrar">Cerrar</v-btn>
        <v-btn class="card_space_reenviar"
          @click="updateSpace"
          v-if="JSON.parse(id.extras).date == undefined"
          >Aprobar</v-btn
        >
      </v-card-actions>
    </v-card>
  </componen>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
export default {
  name: "infoCard",
  props: ["id", "type"],
  computed: {
    imgRoute() {
      return `${this.$store.state.img}/`;
    },
  },
  methods: {
    emitsClose() {
      this.$emit("closeInfo");
      this.$emit("close");
    },
    updatePark() {
      let params = new URLSearchParams();
      params.append("id", this.id.id);
      params.append("nombre_es", this.id.nombre_es);
      params.append("nombre_en", this.id.nombre_en);
      params.append("adminParq", this.id.adminParq);
      params.append("parqProp", this.id.parqProp);
      params.append("region", this.id.region);
      params.append("mercado", this.id.mercado);
      params.append("tipoDeIndustria", this.id.tipoDeIndustria);
      params.append("superficieTotal", this.id.superficieTotal);
      params.append("superficieUrban", this.id.superficieUrban);
      params.append("superficieOcup", this.id.superficieOcup);
      params.append("superficieDisp", this.id.superficieDisp);
      params.append("tipoDePropiedad", this.id.tipoDePropiedad);
      params.append("numEmpleados", this.id.numEmpleados);
      params.append("reconocimientoPracticas", this.id.reconocimientoPracticas);
      params.append("ifraestructura", this.id.ifraestructura);
      params.append("numeroDeNaves", this.id.numeroDeNaves);
      params.append("observacion", this.id.observacion);
      params.append("kmz", this.id.kmz);
      params.append("planMaestro", this.id.planMaestro);
      params.append("contactName", this.id.contactName);
      params.append("contactEmail", this.id.contactEmail);
      axios
        .post(`${this.$store.state.url}/updatepark`, params)
        .then((res) => {
          console.log(res.data);
          this.emitsClose();
        })
        .catch((e) => {
          console.log(e);
        });
    },
    reset(id) {
      const ctx = this;
      Swal.fire({
        title: "¿Esta seguro de esta acción?",
        text: "Se reenviara la contraseña",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          let params = new URLSearchParams();
          params.append("id", id);
          params.append("type", 2);
          axios
            .post(`${this.$store.state.url}/reset`, params)
            .then((res) => {
              console.log(res.data);
            })
            .catch((e) => console.log(e));
          axios
            .post(`${this.$store.state.url}/getemailyid`, params)
            .then((res) => {
              console.log(res.data);
              axios
                .get(
                  `${this.$store.state.baseUrl}/mailler?email=${res.data[0].email}&name=${res.data[0].name}&link=${id}`
                )
                .then((res) => {
                  console.log(res.data)
                  })
                .catch((e) => console.log(e));
            })
            .catch((e) => console.log(e));
          ctx.emitsClose();
        }
      });
    },
    closeInfo() {
      this.$emit("close");
    },
    updateSpace() {
      let params = new URLSearchParams();
      let extras = JSON.parse(this.id.extras);
      let date = Date.now();
      let newExtras = {
        name: extras.name,
        phone: extras.phone,
        medidas: extras.medidas,
        date: date,
        nameSpace: extras.name,
      };
      console.log(newExtras);
      params.append("query", 4);
      params.append("id", this.id.id);
      params.append("extras", JSON.stringify(newExtras));

      axios
        .post(`${this.$store.state.url}/espacio`, params)
        .then((res) => console.log(res))
        .catch((e) => console.log(e));
      this.emitsClose();
    },
  },
};
</script>

<style scoped></style>
