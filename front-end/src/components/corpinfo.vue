<template>
  <v-card color="basil">
    <v-card-title class="text-center justify-center py-6">
      <v-btn icon @click="close">
        <v-icon color="red">mdi-block-helper</v-icon>
      </v-btn>
    </v-card-title>

    <v-tabs v-model="tab" background-color="transparent" color="basil" grow >
      <v-tab >
        Usuarios
      </v-tab>
      <v-tab>
        Parques
      </v-tab>
      <v-tab>
        Naves
      </v-tab>
      <v-tab>
        Información
      </v-tab>
    </v-tabs>

    <!-- Items -->
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card color="basil" flat>
          <v-container>
            <v-row>
              <v-col sm="12" md="4" v-for="i in users" :key="i.id">
                <v-card>
                  <v-card-title>
                    {{i.email}}
                  </v-card-title>
                  <v-card-text>
                    {{i.fullName}}
                  </v-card-text>
                  <v-card-actions>
                    <v-btn>Ver</v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card color="basil" flat>
          <v-card-text>Parques</v-card-text>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card color="basil" flat>
          <v-card-text>Naves</v-card-text>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card color="basil" flat>
          <v-container>
            <v-row>
              <v-col sm="6">
                <v-text-field outlined v-model="id.corporativo" label="Corporativo"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.nombre_es" label="Corporativo"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.nombre_en" label="Corporativo"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.rfc" label="Corporativo"></v-text-field>
              </v-col>

              <!-- parte de la ubicacion -->
              <v-col sm="6">
                <v-text-field outlined v-model="id.cp" label="C.P"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.colonia" label="Colonia"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.estado" label="Estado"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.municipio" label="Municipio"></v-text-field>
              </v-col>

              <!-- contacto eh inversiones -->

              <v-col sm="6">
                <v-text-field outlined v-model="id.celular" label="Celular"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.inversionAnualSiguiente" label="Inversion siguiente"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.inversionRealizadaActual" label="Inversion actual"></v-text-field>
              </v-col>
              <v-col sm="6">
                <v-text-field outlined v-model="id.inversionRealizadaAnterior" label="Inversion anterior"></v-text-field>
              </v-col>

            </v-row>
          </v-container>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>
<script>
export default {
  props: ["id", "users"],
  data() {
    return {
      tab: 0,
      corp: {},
      tabs: [
        { title: "Corporativo", id: 1 },
        { title: "Usuarios", id: 2 },
        { title: "Parques", id: 3 },
        { title: "Naves", id: 4 },
      ]
    };
  },
  methods: {
    close() {
      this.$router.push("/");
    }
  },
  beforeCreate() {
    this.getAllUser();
  },
};
</script>
