<template>
  <v-card width="100%" height="5000">
  <v-spacer></v-spacer>
  <v-icon @click="()=>{this.$router.push('/')}">mdi-close</v-icon>
    <iframe
      id="inlineFrameExample"
      title="Inline Frame Example"
      width="100%"
      height="5000"
      src="http://seccion-socios56789654.bilda.bar/eventos"

    >
    </iframe>
  </v-card>
</template>
<script>
/* import VueGoogleCalendar from "vue-google-calendar/src/vue-google-calendar"
 */

export default {
  data() {
    return {
      data: "Hello Vue!",
    };
  },
  components: {
    /* VueGoogleCalendar */
  },
};
</script>
<style scoped>
  
</style>
