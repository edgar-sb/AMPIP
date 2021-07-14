  <template>      
   <!-- Header -->
    <v-container>
        <v-row justify="flex-start" align="center" class="_logo_header">
            <v-col cols="8">
                <v-img
                    class=""
                    lazy-src="http://18.207.162.106/img/logo_ampip.svg"
                    max-height="150"
                    max-width="250"
                    src="http://18.207.162.106/img/logo_ampip.svg"
                ></v-img>
            </v-col>
            <v-col cols="4">
                <div class="titulo_space_panel">
                    <span>Panel Socios AMPIP</span>
                </div>
            </v-col>
        </v-row>
    </v-container>
    <!-- END Header -->
  </template>
  <script>
      export default {
          name:'headerAmpip'
      }
  </script>
