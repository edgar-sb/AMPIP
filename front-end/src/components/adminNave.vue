<template>
    <v-container>
        <v-row>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.propietario" label="Propietario"></v-text-field>
            </v-col>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.nombre_empresa" label="Empresa"></v-text-field>
            </v-col>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.numero_empleados" label="Numero de empleados"></v-text-field>
            </v-col>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.pais_origen" label="País de origen"></v-text-field>
            </v-col>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.producto_insignia" label="Producto insignia"></v-text-field>
            </v-col>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.sector" disabled label="Sector"></v-text-field>
            </v-col>
            <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.antiguedad" label="Antiguedad en años"></v-text-field>
            </v-col>
             <v-col sm="12" md="6">
                <v-text-field outlined v-model="nave.id_denue" label="ID DENUE"></v-text-field>
            </v-col>
             <v-col sm="12">
                <v-text-field outlined v-model="nave.id_scian" label="ID SCIAN"></v-text-field>
            </v-col>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="save">Guardar informacion</v-btn>
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
    data(){
        return{
            nave:null
        }
    },
    beforeMount() {
        var id = CryptoJS.AES.decrypt(VueCookies.get("id"), "ampip");
        let idData  = id.toString(CryptoJS.enc.Utf8);

        let params = new URLSearchParams();
        params.append("id_user", idData);
        params.append("query", 2);
        axios.post(`${this.$store.state.url}/naveadmin`,params)
        .then(res => this.nave = res.data[0])
        .catch(e => console.log(e));
    },

    methods: {
        save(){
            let params = new URLSearchParams();
            params.append("id", this.nave.id);
            params.append("propietario", this.nave.propietario)
            params.append("nombreEmpresa", this.nave.nombre_empresa)
            params.append("numEmpleados", this.nave.numero_empleados)
            params.append("paisOrigen", this.nave.pais_origen)
            params.append("productoInsignia", this.nave.producto_insignia)
            params.append("sectorEmpresarial", this.nave.sector)
            params.append("id_SCIAN", this.nave.id_scian)
            params.append("id_DENUE", this.nave.id_denue)
            params.append("antiguedad", this.nave.antiguedad)
            params.append("medidaX",0)
            params.append("medidaY",0)
            params.append("medidaZ",0)
            axios.post(`${this.$store.state.url}/updateinquilino`, params)
            .then(() => {
                Swal.fire("Inquilino actualizado");
            })
            .catch(e => console.log(e))
        }
    }
}
</script>
