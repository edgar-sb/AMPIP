<template>
  <v-app>
    <v-container>
      <v-row justify="center" align="center" class="all">
        <v-col sm="6">
          <v-card>
            <v-card-title>Genera una contraseña</v-card-title>
            <v-card-text>
              <v-text-field solo placeholder="Nueva contraseña" type="password" v-model="pass"></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-btn color="red" text @click="updatePass">Guardar</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import axios from "axios";
import VueCookies from "vue-cookies";
export default {
  name: "password",
  data(){
    return{
      user:null,
      pass:null
    }
  },
  beforeMount() {
     var location = window.location.href;
     var user = location.split("?id=")
     if (user[1]){
       this.user = user[1]
     } else {
       this.$router.push("/");
     }

  },
  methods:{
    updatePass(){
      let params = new URLSearchParams();
      params.append("id", this.user);
      params.append("type",1);
      params.append("pass",this.pass)
      axios.post(`${this.$store.state.url}/reset`, params)
          .then(() => {
            VueCookies.remove("id");
            VueCookies.remove("email");
            VueCookies.remove("name");
            this.$router.push("/");
          })
          .catch(e => console.log(e));
    }
  }
}
</script>

<style scoped>
.all {
  height: 90vh;
}

</style>