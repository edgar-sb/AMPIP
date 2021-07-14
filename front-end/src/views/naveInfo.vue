<template>
    <contain>
      <v-card-actions>
            <v-btn @click="returns" icon>
              <v-icon>mdi-arrow-left-bold</v-icon>
            </v-btn>
          </v-card-actions>
      <v-container>
        
        <v-row v-if="inquilino[0]">
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].nombre_es" label="Nombre de Inquilino Español" outlined></v-text-field>
          </v-col>
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].nombre_en" label="Nombre de Inquilino Ingles" outlined></v-text-field>
          </v-col>
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].propietario" label="Propietario" outlined></v-text-field>
          </v-col>
          
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].numEmpleados" label="Número de empleados" outlined></v-text-field>
          </v-col>
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].paisOrigen" label="País de origen" outlined></v-text-field>
          </v-col>
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].productoInsignia" label="Producto insignia" outlined></v-text-field>
          </v-col>
          
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].sectorEmpresarial" label="Sector empresarial" outlined></v-text-field>
          </v-col>
          
          <v-col sm="12" md="6">
            <v-text-field v-model="inquilino[0].antiguedad" label="Años de antiguedad" outlined></v-text-field>
          </v-col>
        </v-row>
      </v-container>
    </contain>
</template>
<script>
import axios from "axios";
export default {
    data(){
        return{
            inquilino:null
        }
    },
    beforeCreate() {
        var id = null;
        if(this.$store.state.nave != null){
            id = this.$store.state.nave;
        } else{
            this.$router.push("/");
        }

        var params = new URLSearchParams();
        params.append("id", id);
        axios.post(`${this.$store.state.url}/getinquilino`,params)
        .then((res)=>{
            this.inquilino = res.data
        })
        .catch(e => console.log(e));
    },
    methods: {
      returns(){
        history.go(-1)
      }
    }
}
</script>
