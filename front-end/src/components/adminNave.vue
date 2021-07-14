<template>
  <v-container>
    <v-row>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.nombre_es"
          label="Nombre en Español"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.nombre_en"
          label="Nombre en Ingles"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.propietario"
          label="Propietario"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.nombre_empresa"
          label="Empresa"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.numero_empleados"
          label="Numero de empleados"
          :rules="[rules.required, rules.phone]"
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <v-select
          :items="paises"
          label="País de Origen *"
          placeholder="País de Origen"
          outlined
          v-model="nave.pais_origen"
        ></v-select>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.producto_insignia"
          label="Producto insignia"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.sector"
          disabled
          label="Sector"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.antiguedad"
          label="Antiguedad en años"
          :rules="[rules.required, rules.phone]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" md="6">
        <v-text-field
          outlined
          v-model="nave.id_denue"
          label="ID DENUE"
          :rules="[rules.required,  rules.phone]"
        ></v-text-field>
      </v-col>
      <v-col sm="12">
        <v-text-field
          outlined
          v-model="nave.id_scian"
          label="ID SCIAN"
          :rules="[rules.required, rules.phone]"
        ></v-text-field>
      </v-col>
      <v-col sm="12" v-if="false">
        <v-text-field
          outlined
          v-model="nave.medidaX"
          label="Medidas"
          :rules="[rules.required, rules.phone]"
        ></v-text-field>
      </v-col>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="save" class="card_space_general">Guardar información</v-btn>
      </v-card-actions>
    </v-row>
  </v-container>
</template>
<script>
import VueCookies from "vue-cookies";
import axios from "axios";
import Swal from "sweetalert2";
var CryptoJS = require("crypto-js");
export default {
  data() {
    return {
      nave: null,
      rules: {
        required: (value) => !!value || "Requerido.",
        counterThre: (value) => value.length >= 3 || "Minimo 3 caracteres",
        counter: (value) => value.length >= 8 || "Minimo 8 characters",
        email: (value) => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Ingresa un correo valido.";
        },
        phone: (value) => {
          const pattern = /^([0-9])*$/;
          return pattern.test(value) || "Numero no valido";
        },
        cp: (value) => value.length <= 5 || "Maximo 5 numeros",
        waitingSpace: (value) => value <= this.space || "Espacio insuficiente",
        phoneLenght: (value) => value.length == 8 || "Necesariamente 8 digitos",
        phoneLada: (value) => value.length <= 2 || "Maximo 2 digitos",
        phoneTen: (value) => value.length > 9 || "Minimo 10 digitos",
        promPrice: (value) =>
          this.decimalPoint.test(value) || "Numero Incorrecto",
        cpLenghtMax: (c) => c.length == 5 || "Necesariamente 5 digitos",
        link: (i) => {
          let pattern = /^https?:\/\/[\w-]+(\.[\w-]+)+[/#?]?.*$/;
          return pattern.test(i) || "Link no valido";
        },
      },
      paises: [
        "Afganistán",
        "Åland Islands",
        "Albania",
        "Alemania",
        "Andorra",
        "Angola",
        "Anguila",
        "Antártida",
        "Antigua y Barbuda",
        "Antillas Neerlandesas",
        "Arabia Saudita",
        "Argelia",
        "Argentina",
        "Armenia",
        "Aruba",
        "Australia",
        "Austria",
        "Azerbaiyán",
        "Bahamas",
        "Bahrein",
        "Bangladesh",
        "Barbados",
        "Belarús",
        "Bélgica",
        "Bélgica-Luxemburgo",
        "Belice",
        "Benin",
        "Bermudas",
        "Bhután",
        "Bolivia",
        "Bonaire",
        "Bosnia y Herzegovina",
        "Botswana",
        "Brasil",
        "Brunei Darussalam",
        "Bulgaria",
        "Burkina Faso",
        "Burundi",
        "Cabo Verde",
        "Camboya",
        "Camerún",
        "Canadá",
        "Categorías especiales",
        "Chad",
        "Checoslovaquia",
        "Chile",
        "China",
        "Chipre",
        "Colombia",
        "Comando I del Pacífico de Estados Unidos",
        "Comoras",
        "Congo, Rep. del",
        "Congo, Rep. Dem. del",
        "Corea, Rep. de",
        "Corea, Rep. Dem. de",
        "Costa Rica",
        "Côte d'Ivoire",
        "Croacia",
        "Cuba",
        "Curacao",
        "Dinamarca",
        "Djibouti",
        "Dominica",
        "Ecuador",
        "Egipto, Rep. Arabe de",
        "El Salvador",
        "Emiratos Arabes Unidos",
        "Eritrea",
        "Eslovenia",
        "España",
        "Estados Unidos",
        "Estonia",
        "Etiopía (excluida Eritrea)",
        "Etiopía (incluida Eritrea)",
        "European Union",
        "Ex Sudán",
        "Federación de Rusia",
        "Fiji",
        "Filipinas",
        "Finlandia",
        "Fm Panama Cz",
        "Fm Rhod Nyas",
        "Fm Tanganyik",
        "Fm Vietna,m DR",
        "Fm Vietnam Rp",
        "Fm Zanz-Pemb",
        "Francia",
        "Gabón",
        "Gambia",
        "Gaza Strip",
        "Georgia",
        "Ghana",
        "Gibraltar",
        "Granada",
        "Grecia",
        "Groenlandia",
        "Guadalupe",
        "Guam",
        "Guatemala",
        "Guayana Francesa",
        "Guinea",
        "Guinea Ecuatorial",
        "Guinea-Bissau",
        "Guyana",
        "Haití",
        "Honduras",
        "Hong Kong (China)",
        "Hungría",
        "India",
        "Indonesia",
        "Irán, Rep. Islámica del",
        "Iraq",
        "Irlanda",
        "Isla Bouvet",
        "Isla Bunker",
        "Isla de Navidad",
        "Isla Norfolk",
        "Islandia",
        "Islas Caimán",
        "Islas Cocos (Keeling)",
        "Islas Cook",
        "Islas del Pacífico",
        "Islas Falkland",
        "Islas Feroe",
        "Islas Georgias del Sur y Sandwich del Sur",
        "Islas Heard y McDonald",
        "Islas Marshall",
        "Islas Salomón",
        "Islas Turcas y Caicos",
        "Islas Ultramarinas Menores de Estados Unidos",
        "Islas Vírgenes (EE.UU.)",
        "Islas Vírgenes Británicas",
        "Islas Wallis y Futuna",
        "Israel",
        "Italia",
        "Jamaica",
        "Japón",
        "Jhonston Island",
        "Jordania",
        "Kazajstán",
        "Kenya",
        "Kirguistán",
        "Kiribati",
        "Kosovo",
        "Kuwait",
        "Lesotho",
        "Letonia",
        "Líbano",
        "Liberia",
        "Libia",
        "Liechtenstein",
        "Lituania",
        "Luxemburgo",
        "Macao",
        "Macedonia, ex Rep. Yugoslava de",
        "Madagascar",
        "Malasia",
        "Malawi",
        "Maldivas",
        "Malí",
        "Malta",
        "Mariana",
        "Marruecos",
        "Martinica",
        "Mauricio",
        "Mauritania",
        "Mayotte",
        "México",
        "Micronesia, Estados Fed. de",
        "Midway Islands",
        "Mónaco",
        "Mongolia",
        "Montenegro",
        "Montserrat",
        "Mozambique",
        "Mundo",
        "Myanmar",
        "Namibia",
        "Nauru",
        "Nepal",
        "Nicaragua",
        "Níger",
        "Nigeria",
        "Niue",
        "No especificados",
        "Noruega",
        "Nueva Caledonia",
        "Nueva Zelandia",
        "Omán",
        "Otra zona de Asia, no esp.",
        "Países Bajos",
        "Pakistán",
        "Palau",
        "Panamá",
        "Papua Nueva Guinea",
        "Paraguay",
        "Pen Malaysia",
        "Perú",
        "Pitcairn",
        "Polinesia Francesa",
        "Polonia",
        "Portugal",
        "Puerto Rico",
        "Qatar",
        "Reino Unido",
        "República �?rabe Siria",
        "República Centroafricana",
        "República Checa",
        "República de Moldova",
        "República Democrática Alemana",
        "República Democrática Popular Lao",
        "República Dominicana",
        "República Eslovaca",
        "Reunión",
        "Rumania",
        "Rwanda",
        "Ryukyu Is",
        "Sabah",
        "Sahara Occidental",
        "Saint Kitts y Nevis",
        "Saint Kitts-Nevis-Anguilla-Aru",
        "Samoa",
        "Samoa Americana",
        "San Marino",
        "San Martín",
        "San Pedro y Miquelón",
        "San Vicente y las Granadinas",
        "Santa Elena",
        "Santa Lucía",
        "Santa Sede",
        "Santo Tomé y Príncipe",
        "Sarawak",
        "Senegal",
        "Serbia, Rep. Fed. de (Serbia y Montenegro)",
        "Seychelles",
        "Sierra Leona",
        "SIKKIM",
        "Singapur",
        "Somalia",
        "Sri Lanka",
        "Sudáfrica",
        "Sudán",
        "Sudán del Sur",
        "Suecia",
        "Suiza",
        "Suriname",
        "Svalbard and Jan Mayen Is",
        "Swazilandia",
        "Tailandia",
        "Taiwán, China",
        "Tanzanía",
        "Tayikistán",
        "Territorio Antártico Británico",
        "Territorio Británico del Océano Indico",
        "Territorio Palestino Ocupado",
        "Tierras Australes y Antárticas Francesas",
        "Timor Oriental",
        "Togo",
        "Tokelau",
        "Tonga",
        "Trinidad y Tobago",
        "Túnez",
        "Turkmenistán",
        "Turquía",
        "Tuvalu",
        "Ucrania",
        "Uganda",
        "Unión Soviética",
        "Uruguay",
        "Uzbekistán",
        "Vanuatu",
        "Venezuela",
        "Viet Nam",
        "Wake Island",
        "Yemen, Rep. del",
        "Yemen, Rep. Dem. Del",
        "Yugoslavia, Rep. Fed. de (Serbia y Montenegro)",
        "Zambia",
        "Zimbabwe",
      ],
      medidaX:0,
      medidaY:0,
      medidaZ:0,
    };
  },
  beforeMount() {
    var id = CryptoJS.AES.decrypt(VueCookies.get("id"), "ampip");
    let idData = id.toString(CryptoJS.enc.Utf8);

    let params = new URLSearchParams();
    params.append("id_user", idData);
    params.append("query", 2);
    axios
      .post(`${this.$store.state.url}/naveadmin`, params)
      .then((res) => (this.nave = res.data[0]))
      .catch((e) => console.log(e));
  },

  methods: {
    save() {
      let params = new URLSearchParams();
      params.append("id", this.nave.id);
      params.append("nombre_es", this.nave.nombre_es);
      params.append("nombre_en", this.nave.nombre_en);
      params.append("propietario", this.nave.propietario);
      params.append("nombreEmpresa", this.nave.nombre_empresa);
      params.append("numEmpleados", this.nave.numero_empleados);
      params.append("paisOrigen", this.nave.pais_origen);
      params.append("productoInsignia", this.nave.producto_insignia);
      params.append("sectorEmpresarial", this.nave.sector);
      params.append("id_SCIAN", this.nave.id_scian);
      params.append("id_DENUE", this.nave.id_denue);
      params.append("antiguedad", this.nave.antiguedad);
      axios
        .post(`${this.$store.state.url}/updateinquilino`, params)
        .then(() => {
          Swal.fire("Inquilino actualizado");
        })
        .catch((e) => console.log(e));
    },
  },
};
</script>
