<template>
    <v-container>
        <v-row>
            <v-col>
                {{nave}}
            </v-col>
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
