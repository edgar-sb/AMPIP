<template>
    <!-- Editar Parque-->
    <v-card v-show="dialogs == 3">
      <v-card-title>Parque</v-card-title>
      <v-container>
        <v-row>
          <v-col cols="6">
            <v-text-field
              label="Nombre en Español"
              outlined
              placeholder="Nombre"
              v-model="parquesData.name_es"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Nombre en Ingles"
              outlined
              placeholder="Nombre"
              v-model="parquesData.name_en"
            >
            </v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Administrador"
              outlined
              placeholder="Administrador"
              v-model="parquesData.admins"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Propietario"
              outlined
              placeholder="Propietario"
              v-model="parquesData.propi"
            >
            </v-text-field>
          </v-col>

          <v-col md="6">
            <v-text-field
              outlined
              label="Codigo postal"
              :rules="[rules.required]"
              v-model="corp.cp"
              @keyup="watchCp"
            ></v-text-field>
          </v-col>
          <v-col md="6">
            <v-select
              :items="cp"
              label="Colonia"
              placeholder="Colonia"
              :rules="[rules.required]"
              outlined
              v-model="corp.col"
              item-text="colonia"
              item-value="colonia"
            ></v-select>
          </v-col>
          <v-col md="6">
            <v-text-field
              outlined
              label="Estado"
              :rules="[rules.required]"
              v-model="edo"
              disabled
            ></v-text-field>
          </v-col>
          <v-col md="6">
            <v-text-field
              outlined
              label="municipio/alcaldía"
              :rules="[rules.required]"
              v-model="mun"
              disabled
            ></v-text-field>
          </v-col>

          <v-col cols="6">
            <v-select
              :items="regiones"
              label="Región"
              outlined
              v-model="parquesData.region"
            ></v-select>
          </v-col>
          <v-col cols="6">
            <v-select
              :items="mercados"
              label="Mercado"
              outlined
              v-model="parquesData.Mercado"
              :value="Mercados"
            ></v-select>
          </v-col>
          <v-col cols="6">
            <v-select
              :items="tipoDeIndustria"
              label="Tipo de industria"
              outlined
              v-model="parquesData.industria"
            ></v-select>
          </v-col>
          <!-- superficies -->
          <v-col cols="6">
            <v-text-field
              label="Superficie total"
              suffix="km2"
              outlined
              placeholder="En km2"
              type="number"
              v-model="parquesData.sup_tot"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Superficie urbanizada"
              outlined
              suffix="km2"
              placeholder="En km2"
              type="number"
              v-model="parquesData.sup_urb"
            >
            </v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Superficie ocupada"
              suffix="km2"
              outlined
              placeholder="En km2"
              type="number"
              v-model="parquesData.sup_oc"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Superficie disponible"
              suffix="km2"
              outlined
              placeholder="En km2"
              type="number"
              v-model="parquesData.sup_dis"
            >
            </v-text-field>
          </v-col>
          <!-- superficies -->

          <v-col cols="6">
            <v-select
              :items="items"
              label="Tipo de propiedad"
              outlined
              v-model="parquesData.tipo"
            ></v-select>
          </v-col>
          <v-col cols="6">
            <v-menu
              v-model="menu1"
              :close-on-content-click="false"
              max-width="290"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  :value="date"
                  label="Inicio de operaciones"
                  readonly
                  outlined
                  v-bind="attrs"
                  v-on="on"
                  @click:clear="date = null"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="date"
                @change="menu1 = false"
              ></v-date-picker>
            </v-menu>
          </v-col>
          <v-col col="12">
            <v-select
              v-model="parquesData.infra"
              :items="infraList"
              attach
              chips
              outlined
              label="Infraestructura"
              multiple
            ></v-select>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Pagina web"
              outlined
              placeholder="http://"
              v-model="parquesData.name_contact"
            >
            </v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              label="Teléfono"
              outlined
              placeholder="Teléfono"
              type="phone"
              v-model="parquesData.telefono"
            ></v-text-field>
          </v-col>

          <v-col cols="12">
            <v-text-field
              label="Direccion"
              outlined
              placeholder="Direccion"
              v-model="parquesData.direccion"
            ></v-text-field>
          </v-col>

          <v-col cols="12">
            <h1>Seleciona la ubicacion</h1>
            <GmapMap
              :center="{ lat: 25, lng: -100 }"
              :zoom="4"
              map-type-id="terrain"
              style="width: 100%; height: 300px"
              @click="add"
            >
              <GmapMarker
                :position="markers"
                :clickable="true"
                :draggable="true"
              />
            </GmapMap>
          </v-col>
        </v-row>
      </v-container>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn class="card_space_cerrar" color="red" @click="closeAction" text>Cancelar</v-btn>
        <v-btn class="card_space_anadir" color="green darken-1" text @click="addparque">
          Añadir
        </v-btn> </v-card-actions
      >Seleciona la ubicacion
    </v-card>
</template>