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
                <v-text-field outlined v-model="nave.sector" label="Sector"></v-text-field>
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
                <v-btn>Guardar informacion</v-btn>
            </v-card-actions>
        </v-row>
    </v-container>
</template>
<script>
import VueCookies from "vue-cookies";
import axios from "axios";
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
    }
}
</script>
