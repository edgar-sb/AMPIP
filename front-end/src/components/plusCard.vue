<template>
  <div>
    <!-- Nave *-->
    <v-card v-if="dialogs == 1">
      <v-card-actions>
        <v-card-title>Inquilinos </v-card-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="closeAction">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-actions>

      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="6">
              <v-text-field
                outlined
                placeholder="Nombre del inquilino (Español)"
                label="Nombre del inquilino (Español) *"
                v-model="inquilino.name"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>

            <v-col cols="6">
              <v-text-field
                outlined
                placeholder="Nombre del inquilino (Ingles)"
                label="Nombre del inquilino (Ingles) *"
                v-model="inquilino.name_en"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>

            <v-col cols="6">
              <v-text-field
                outlined
                placeholder="Nombre de Propietario"
                label="Propietario *"
                v-model="inquilino.prop"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>

            <v-col cols="6">
              <v-text-field
                outlined
                placeholder="Número de empleados"
                label="Número de empleados *"
                v-model="inquilino.num_emp"
                :rules="[rules.required, rules.phone]"
              ></v-text-field>
            </v-col>

            <v-col cols="12">
              <v-select
                :items="inquilino.paises"
                label="País de Origen *"
                placeholder="País de Origen"
                outlined
                v-model="inquilino.origin"
                :rules="[rules.required]"
              ></v-select>
            </v-col>

            <v-col cols="6">
              <v-text-field
                outlined
                placeholder="Producto insignia"
                label="Producto insignia *"
                v-model="inquilino.insignia"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>

            <v-col cols="6">
              <v-text-field
                outlined
                placeholder="Antigüedad en años"
                label="Antigüedad en años *"
                v-model="inquilino.antiguedad"
                :rules="[rules.required, rules.phone]"
              ></v-text-field>
            </v-col>

            <v-col cols="12">
              <v-select
                :items="inquilino.sectores"
                label="Sector *"
                placeholder="Sector"
                outlined
                v-model="inquilino.sector"
                :rules="[rules.required]"
              ></v-select>
            </v-col>

            <v-col sm="12" v-if="id">
              <v-select
                :items="Allspace"
                v-model="parque"
                label="Espacio en *"
                outlined
                @click="getAllspace"
                item-text="tipo"
                item-value="id"
              >
              </v-select>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-1" class="card_space_agregar" text @click="addNave">
          Añadir
        </v-btn>
        <v-btn color="red" class="card_space_cerrar" text @click="closeAction">Cancelar</v-btn>
      </v-card-actions>
    </v-card>
    <!-- Crear Parque -->
    <v-card v-if="dialogs == 2">
      <v-card-actions>
        <v-card-title>Parque</v-card-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="closeAction">
          <v-icon> mdi-window-close </v-icon>
        </v-btn>
      </v-card-actions>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="6">
              <v-text-field
                label="Nombre de parque (Español) *"
                outlined
                placeholder="Nombre"
                v-model="parquesData.name_es"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Nombre de parque (Inglés) *"
                outlined
                placeholder="Nombre"
                v-model="parquesData.name_en"
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Administrador de Parque *"
                outlined
                placeholder="Administrador"
                v-model="parquesData.admins"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Propietario *"
                outlined
                placeholder="Propietario"
                v-model="parquesData.propi"
                :rules="[rules.required]"
              >
              </v-text-field>
            </v-col>
            <v-col class="titulo_form_space" sm="12">
              <span class="titulo_form_space">Dirección:</span>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Calle y Número *"
                outlined
                placeholder="Direccion"
                type="phone"
                v-model="parquesData.direccion"
                :rules="[rules.required]"
              ></v-text-field>
            </v-col>
            <v-col md="6">
              <v-text-field
                outlined
                label="Codigo postal *"
                :rules="[rules.required, rules.phone, rules.cpLenghtMax]"
                v-model="corp.cp"
                @change="watchCp"
              ></v-text-field>
            </v-col>
            <v-col md="6">
              <v-select
                :items="cp"
                label="Colonia *"
                placeholder="Colonia"
                :rules="[rules.required]"
                outlined
                v-model="corp.col"
                item-text="d_asenta"
                item-value="d_asenta"
              ></v-select>
            </v-col>
            <v-col md="6">
              <v-text-field
                outlined
                label="Estado *"
                :rules="[rules.required]"
                v-model="edo"
                disabled
              ></v-text-field>
            </v-col>
            <v-col md="6">
              <v-text-field
                outlined
                label="Municipio/Alcaldía *"
                :rules="[rules.required]"
                v-model="mun"
                disabled
              ></v-text-field>
            </v-col>
            <v-col sm="12">
              <span>Información de actividades:</span>
            </v-col>
            <v-col cols="6">
              <v-select
                :items="regiones"
                label="Region *"
                outlined
                v-model="parquesData.region"
                :rules="[rules.required]"
              ></v-select>
            </v-col>
            <v-col cols="6">
              <v-select
                :items="mercados"
                label="Mercado *"
                outlined
                v-model="parquesData.Mercado"
                :rules="[rules.required]"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-select
                :items="tipoDeIndustria"
                label="Tipo de industria *"
                outlined
                v-model="parquesData.industria"
                :rules="[rules.required]"
              ></v-select>
            </v-col>
            <v-col sm="12">
              <span>Superficies:</span>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Superficie Total *"
                suffix="km2"
                outlined
                placeholder="En km2"
                v-model="parquesData.sup_tot"
                :rules="[rules.required, rules.phone]"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Superficie Urbanizada *"
                outlined
                suffix="km2"
                placeholder="En km2"
                v-model="parquesData.sup_urb"
                :rules="[rules.required, rules.phone]"
              >
              </v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Superficie Ocupada *"
                suffix="km2"
                outlined
                placeholder="En km2"
                v-model="parquesData.sup_oc"
                :rules="[rules.required, rules.phone]"
              ></v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                label="Superficie Disponible *"
                suffix="km2"
                outlined
                disabled
                placeholder="En km2"
                v-model="sup_disComputed"
                :rules="[rules.required, rules.phone]"
              >
              </v-text-field>
            </v-col>
            <v-col cols="6">
              <v-select
                :items="items"
                label="Tipo de Propiedad *"
                outlined
                v-model="parquesData.tipo"
                :rules="[rules.required]"
              ></v-select>
            </v-col>

            <v-col cols="12">
              <v-select
                v-model="parquesData.infra"
                :items="infraList"
                attach
                chips
                outlined
                label="Infraestructura *"
                multiple
                :rules="[rules.required]"
              ></v-select>
            </v-col>
            <v-col sm="12">
              <span>Contacto:</span>
            </v-col>
            <v-col sm="12">
              <v-text-field
                label="Página web *"
                outlined
                placeholder="http://"
                :rules="[rules.required, rules.link]"
                v-model="parquesData.web"
              >
              </v-text-field>
            </v-col>
            <v-col sm="12">
              {{ parquesData.code }} {{ parquesData.lada }}
              {{ parquesData.telefono }}
            </v-col>

            <v-col sm="12" md="3">
              <v-select
                :items="codigoPais"
                label="Codigo de pais *"
                outlined
                placeholder="Codigo de pais"
                type="phone"
                v-model="parquesData.code"
                :rules="[rules.required]"
              ></v-select>
            </v-col>
            <v-col sm="12" md="2">
              <v-text-field
                label="Lada *"
                outlined
                placeholder="Lada"
                type="phone"
                v-model="parquesData.lada"
                :rules="[rules.required, rules.phoneLada, rules.phone]"
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="7">
              <v-text-field
                label="Teléfono *"
                outlined
                placeholder="Teléfono"
                type="phone"
                v-model="parquesData.telefono"
                :rules="[rules.required, rules.phoneLenght, rules.phone]"
              ></v-text-field>
            </v-col>
            <v-col sm="12">
              <span>Detalles:</span>
            </v-col>
            <v-col cols="12">
              <v-text-field
                label="Número de empleados *"
                outlined
                placeholder="Número de empleados"
                v-model="parquesData.employeds"
                :rules="[rules.required, rules.phone]"
              ></v-text-field>
            </v-col>

            <v-col cols="12">
              <v-select
                v-model="parquesData.record"
                :items="records"
                attach
                chips
                outlined
                label="Reconocimientos"
                multiple
              ></v-select>
            </v-col>

            <v-col sm="12">
              <span>Multimedia:</span>
            </v-col>

            <v-col sm="12">
              <UploadImages
                @change="chargeImages"
                :max="3"
                maxError="Solamente una imagen"
                style="color:#000"
              />
            </v-col>
            <v-col sm="12">
              <GmapMap
                :center="{ lat: 19.794509121420788, lng: -99.0424054958186 }"
                :zoom="7"
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
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-1" class="card_space_agregar" text @click="addparque">
          Añadir
        </v-btn>
        <v-btn color="red" class="card_space_cerrar" @click="closeAction" text>Cancelar</v-btn>
      </v-card-actions>
    </v-card>
    <!-- Corporativo -->
    <v-card v-if="dialogs == 4">
      <v-card-title>
        Nuevo {{ type_society }}
        <v-spacer></v-spacer>
        <v-card-actions>
          <v-btn icon @click="closeAction">
            <v-icon>mdi-window-close</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card-title>

      <v-card-text>
        <v-row>
          <v-col cols="12" sm="12" md="12">
            <v-cotainer>
              <v-row align="center" justify="center">
                <v-col sm="12" md="6">
                  <UploadImages
                    @change="handleImages"
                    :max="3"
                    style="color:#fff"
                  />
                  <span>Sube aquí tu logotipo *</span>
                </v-col>
              </v-row>
            </v-cotainer>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Razón Social *"
              :rules="[rules.required]"
              v-model="corp.spcial"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Nombre de Corporativo (Español) *"
              :rules="[rules.required]"
              v-model="corp.name_es"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="12">
            <v-text-field
              outlined
              label="Nombre de Corporativo (Inglés) *"
              :rules="[rules.required]"
              v-model="corp.name_en"
            ></v-text-field>
          </v-col>
          <!-- Apartado de direccion -->
          <v-col class="titulo_form_space" cols="12" sm="12">
            <span>Dirección </span>
          </v-col>
          <v-col cols="12" sm="12" md="12">
            <v-text-field
              outlined
              label="Calle y Número *"
              :rules="[rules.required]"
              v-model="corp.address"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="12">
            <v-text-field
              outlined
              label="Código Postal *"
              :rules="[rules.required, rules.cpLenghtMax]"
              v-model="corp.cp"
              @change="watchCp"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="12">
            <v-select
              :items="cp"
              label="Colonia *"
              placeholder="Colonia"
              :rules="[rules.required]"
              outlined
              v-model="corp.col"
              item-text="d_asenta"
              item-value="d_asenta"
            ></v-select>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Estado *"
              :rules="[rules.required]"
              v-model="edo"
              disabled
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="12" md="6">
            <v-text-field
              outlined
              label="Municipio/Alcaldía *"
              :rules="[rules.required]"
              v-model="mun"
              disabled
            ></v-text-field>
          </v-col>
          <v-col class="titulo_form_space" cols="12" sm="12" md="12">
            <label>Teléfono de Oficina: {{ officePhone }}</label>
          </v-col>
          <v-col cols="12" sm="3">
            <v-select
              :items="codigoPais"
              label="Código país *"
              outlined
              :rules="[rules.required]"
              v-model="codigoPaisValue"
            ></v-select>
          </v-col>
          <v-col cols="12" sm="2">
            <v-text-field
              label="Lada *"
              outlined
              v-model="ladaValue"
              :rules="[rules.required, rules.phone, rules.phoneLada]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="7">
            <v-text-field
              outlined
              label="Número local *"
              :rules="[rules.required, rules.phone, rules.phoneLenght]"
              v-model="corp.cel"
            ></v-text-field>
          </v-col>
          <v-col class="titulo_form_space" cols="12" sm="12">
            <span>Clasificación</span>
          </v-col>
          <v-col cols="12" sm="12" v-if="type_society === 'Desarrollador'">
            <v-select
              outlined
              :rules="[rules.required]"
              label="Clasificación de Socio *"
              v-model="society"
              :items="types"
            ></v-select>
          </v-col>
          <v-col cols="12" sm="12" v-if="type_society === 'Patrocinador'">
            <v-select
              outlined
              :rules="[rules.required]"
              label="Clasificación de patrocinador *"
              v-model="society"
              :items="types_pats"
            ></v-select>
          </v-col>
          <v-col> </v-col>
        </v-row>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="red" class="card_space_cerrar" text @click="closeAction">Cancelar</v-btn>
        <v-btn color="green darken-1" class="card_space_agregar" text @click="addCorp">
          Añadir
        </v-btn>
      </v-card-actions>
    </v-card>
    <!-- Usuario --->
    <v-card v-if="dialogs == 5">
      <v-card-actions>
        <v-card-title>
          Usuario
        </v-card-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="closeAction">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-actions>
      <v-container>
        <v-row>
          <v-col sm="12">
            <v-text-field
              outlined
              label="Nombre *"
              :rules="[rules.required]"
              v-model="addUser.name"
            ></v-text-field>
          </v-col>
          <v-col sm="6">
            <v-text-field
              outlined
              label="Apellido Paterno *"
              :rules="[rules.required]"
              v-model="addUser.lastname"
            ></v-text-field>
          </v-col>
          <v-col sm="6">
            <v-text-field
              outlined
              label="Apellido Materno *"
              :rules="[rules.required]"
              v-model="addUser.last"
            ></v-text-field>
          </v-col>
          <v-col sm="12">
            <v-text-field
              outlined
              label="Correo *"
              :rules="[rules.required, rules.email]"
              v-model="addUser.email"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-container>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="red" class="card_space_cerrar" text @click="closeAction">Cancelar</v-btn>
        <v-btn color="green darken-1" class="card_space_agregar" text @click="addUserAction">
          Agregar
        </v-btn>
      </v-card-actions>
    </v-card>
    <!-- ultimo usuario -->
    <v-card v-if="dialogs == 6">
      <v-card-actions>
        <v-card-title></v-card-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="closeAction">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-actions>
      <v-container>
        <v-row>
          <v-col sm="12">
            <v-text-field
              outlined
              label="Nombre *"
              :rules="[rules.required]"
              v-model="addUser.name"
            ></v-text-field>
          </v-col>
          <v-col sm="6">
            <v-text-field
              outlined
              label="Apellido Paterno *"
              :rules="[rules.required]"
              v-model="addUser.lastname"
            ></v-text-field>
          </v-col>
          <v-col sm="6">
            <v-text-field
              outlined
              label="Apellido Materno *"
              :rules="[rules.required]"
              v-model="addUser.last"
            ></v-text-field>
          </v-col>
          <v-col sm="12">
            <v-text-field
              outlined
              label="Correo *"
              :rules="[rules.required, rules.email]"
              v-model="addUser.email"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-container>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-1" class="card_space_agregar" text @click="addUserActionUltimo">
          Agregar
        </v-btn>
        <v-btn color="red" class="card_space_cerrar" text @click="closeAction">Cancelar</v-btn>
      </v-card-actions>
    </v-card>
    <!-- espacio * -->
    <v-card v-if="dialogs == 7">
      <v-card-actions>
        <v-card-title>
          Espacio
        </v-card-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="closeAction">
          <v-icon>mdi-window-close</v-icon>
        </v-btn>
      </v-card-actions>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-text-field
              outlined
              label="Nombre *"
              placeholder="Nombre"
              v-model="spaces.type"
              :rules="[rules.required]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="spaces.nameSpace"
              :items="['Terreno', 'nave']"
              attach
              outlined
              label="Tipo de espacio *"
              placeholder="Tipo de espacio"
              :rules="[rules.required]"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-select
              v-model="spaces.use"
              :items="['Manufactura', 'Centro de distribución', 'Ambas']"
              attach
              outlined
              label="Uso del espacio *"
              placeholder="Uso del espacio"
              :rules="[rules.required]"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              outlined
              title="Precio"
              label="Precio promedio * MXN"
              prepend-icon="$"
              placeholder="Ej. 89"
              v-model="spaces.price"
              :rules="[rules.required, rules.phone]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              title="nombe de contacto *"
              placeholder="nombe de contacto"
              label="Nombre del contacto"
              outlined
              v-model="spaces.contact_name"
              :rules="[rules.required]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              label="Teléfono del contacto *"
              placeholder="Teléfono del contacto"
              outlined
              v-model="spaces.contact_phone"
              :rules="[rules.required, rules.phone, rules.phoneTen]"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              placeholder="Ancho"
              label="Ancho *"
              outlined
              v-model="spaces.width"
              :rules="[rules.required, rules.phone]"
              suffix="Km2"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="12">
            <v-text-field
              placeholder="Largo"
              label="Largo *"
              outlined
              v-model="spaces.height"
              suffix="Km2"
              :rules="[rules.required, rules.phone]"
            ></v-text-field>
          </v-col>
          <v-col sm="12">
            <v-checkbox
              v-model="amMap"
              label="Ingresar mi ubicacion en el mapa"
            ></v-checkbox>
          </v-col>
          <v-col cols="12" v-if="amMap">
            <span>Selecciona la ubicacion</span>
            <GmapMap
              :center="{ lat: 19.794509121420788, lng: -99.0424054958186 }"
              :zoom="7"
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
          <v-col cols="12" v-if="!amMap">
            <p>Latitud y longitud</p>
            <v-container>
              <v-row>
                <v-col md="6"><v-text-field placeholder="Lat" v-model="ubicacionCru.lat"></v-text-field></v-col>
                <v-col md="6"><v-text-field placeholder="Lng" v-model="ubicacionCru.lng"></v-text-field></v-col>
              </v-row>
            </v-container>
          </v-col>
          <v-col cols="12">
            <v-select
              v-model="parquesData.infra"
              :items="infraList"
              attach
              chips
              outlined
              label="Infraestructura *"
              multiple
              :rules="[rules.required]"
            ></v-select>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-1" class="card_space_agregar" text @click="addSpaceAction">
          Agregar
        </v-btn>
        <v-btn color="red" class="card_space_cerrar" text @click="closeAction">Cancelar</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import UploadImages from "vue-upload-drop-images";

export default {
  name: "plusCard",
  components: { UploadImages },
  data() {
    return {
      multiImage: [],
      codigoPais: ["+52"],
      gmapsLat: true,
      editPark: false,
      restEsp: null,
      lada: ["+52", "+1"],
      newNave: false,
      newCorp: false,
      name: "",
      parques: [],
      parque: false,
      newPark: false,
      items: ["Privado", "Público"],
      menu1: false,
      date: "",
      name_es: null,
      name_en: null,
      admins: null,
      propi: null,
      region: null,
      mercado: null,
      industria: null,
      sup_tot: null,
      sup_urb: null,
      sup_oc: null,
      sup_dis: null,
      tipo: null,
      infraList: [
        "Al menos 0.5 litros agua por segundo por ha",
        "Pavimento",
        "Banquetas",
        "Drenaje Sanitario",
        "Drenaje Pluvial",
        "Planta de tratamiento de Agua",
        "Gas Natural",
        "Alumbrado público",
        "Instalación eléctrica",
        "Subestación eléctrica",
        "Telefonía",
        "Comunicación Satelital",
        "Instalación Digital",
        "Espuela de Ferrocarril",
        "Estación de bomberos",
        "Áreas verdes o recreativas",
        "Guardería",
        "Centro de Capacitación",
        "Seguridad",
        "Transporte interno de personal",
        "Transporte Urbano",
        "Recolección de basura",
        "Aduana interna",
        "Agente aduanal",
        "Servicios de consultoria",
        "Programa shelter",
        "Servicio Built to suit",
        "Reglamento interno",
        "Oficinas administrativas",
      ],
      name_contact: null,
      telefono: null,
      parkIntoPark: 0,
      key_corp: null,
      infra: null,
      markers: { lat: 56.19605552778996, lng: 111.13718986063111 },
      corp: {
        lada: "",
        name_es: "",
        name_en: "",
        type: "",
        address: "",
        cp: "",
        col: "",
        edo: "",
        mun: "",
        cel: "",
        logo: "",
        inv_ant: "",
        inv_act: "",
        inv_sig: "",
        rfc: "",
        spcial: "",
        decimalPoint: /\^[0-9]+([,][0-9]+)?$/,
      },
      space: null,
      cp: [],
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
      corps: [],
      park: false,
      inquilino: {
        name: "",
        name_en: "",
        sectores: [
          "Agricultura; plantaciones",
          "Alimentación; bebidas; tabaco",
          "Comercio",
          "Construcción",
          "Educación",
          "Fabricación de material de transporte ",
          "Función pública",
          "Hotelería, restauración, turismo",
          "Industrias químicas ",
          "Ingenieria mecánica y eléctria",
          "Medios de comunicación; cultura; gráficos",
          "Minería (carbón, otra minería) ",
          "Petroleo y producción de gas; refinación de petroleo",
          "Producción de metales básicos",
          "Servicios de correosy de telecomunicaciones ",
          "Servicios de salud",
          "Servicios financieros; servicios profesionales",
          "Servicios públicos (agua; gas; electricidad)",
          "Silvicultura; madera; celulosa; papel",
          "Textiles; vestido; cuero; calzado",
          "Transporte (inluyendo aviación civil; ferrocarriles; transporte por carretera)",
          "Transporte marítimo; puertos; pesca; transporte interior",
          "otros sectores rurales",
        ],
        prop: "",
        num_emp: "",
        origin: "",
        insignia: "",
        sector: "",
        antiguedad: "",
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
      },
      tipoDeIndustria: [
        "Industrias pesadas",
        "siderúrgicas o metalúrgicas",
        "químicas",
        "petroquímica",
        "automovilística",
        "alimentaria",
        "textil",
        "farmacéutica",
      ],
      regiones: [
        "Región Noroeste",
        "Región Noreste",
        "Región Occidente",
        "Región Oriente",
        "Región Centronorte",
        "Región Centrosur",
        "Región Suroeste",
        "Región Sureste",
      ],
      mercados: [
        "productos de consumo",
        "productos de uso o inversión",
        "productos industriales",
        "servicios",
        "financieros",
        "distribuidores",
        "compradores industriales",
      ],
      parquesData: {
        name_es: "",
        name_en: "",
        key_corp: "",
        admins: "",
        propi: "",
        mun: "",
        region: "",
        Mercado: "",
        industria: "",
        sup_tot: "",
        sup_urb: "",
        sup_oc: "",
        sup_dis: "",
        tipo: "",
        date: "",
        infra: "",
        name_contact: "",
        telefono: "",
        code: "",
        lada: "",
        direccion: "",
        employeds: "",
        record: "",
        web: "",
      },
      parkToEdit: null,
      records: [
        "Norma Mexiana de Parque Industrial",
        "Parque Industrial Verde",
        "Calidad Ambiental (PROFEPA)",
        "Parque Industrial Sustentable",
        "Parque Industrial Limpio",
        "Parque Industrial Seguro",
        "OEA",
      ],
      images: [],
      addUser: {
        name: "",
        lastname: "",
        last: "",
        email: "",
        pass: "",
      },
      types: [
        "Desarrollador Privado",
        "Fondo de inversión",
        "FIBRA",
        "Gobierno Estatal",
        "No es Socio AMPIP",
      ],
      codigoPaisValue: "",
      ladaValue: "",
      types_pats: [
        "Consultoría",
        "Construcción",
        "Energía",
        "Financiero",
        "Inmobiliario",
        "Telecomunicaciones",
        "Otros",
        "Transporte",
      ],
      society: "",
      parks: ["Modelo"],
      spaces: {},
      Allspace: [],
      amMap: false,
      ubicacionCru:{
        lat:"",
        lng:"",
      }
    };
  },
  props: ["dialogs", "nuevo", "id", "type_society"],
  methods: {
    addNave() {
      if (
        this.inquilino.name != "" &&
        this.inquilino.name_en != "" &&
        this.inquilino.prop != "" &&
        this.inquilino.num_emp != "" &&
        this.inquilino.origin != "" &&
        this.inquilino.insignia != "" &&
        this.inquilino.sector != "" &&
        this.inquilino.antiguedad != ""
      ) {
        /* var parqueId = null;
        if (this.parque != false) {
          parqueId = this.parque;
        } else {
          parqueId = this.id;
        } */

        var params = new URLSearchParams();
        params.append("name", this.inquilino.name);
        params.append("idParque", this.id);

        axios
          .post(`${this.$store.state.url}/createnave`, params)
          .then((res) => {
            console.log(res.data.id);
            let data = new URLSearchParams();
            data.append("nombre_es", this.inquilino.name);
            data.append("nombre_en", this.inquilino.name_en);
            data.append("propietario", this.inquilino.prop);
            data.append("numEmpleados", this.inquilino.num_emp);
            data.append("paisOrigen", this.inquilino.origin);
            data.append("productoInsignia", this.inquilino.insignia);
            data.append("sectorEmpresarial", this.inquilino.sector);
            data.append("antiguedad", this.inquilino.antiguedad);
            data.append("antiguedad", this.inquilino.antiguedad);

            data.append("id_nave", res.data.id);
            axios
              .post(`${this.$store.state.url}/setinquilino`, data)
              .then(() => {
                this.closeAction();
              })
              .catch((e) => console.log(e));
          })
          .catch((e) => console.log(e));

        if (this.parque != false) {
          let params = new URLSearchParams();
          params.append("type", "i");
          params.append("table", "s");
          params.append("id", this.parque);
          axios
            .post(`${this.$store.state.url}/activeinactive`, params)
            .then((res) => console.log(res))
            .catch((e) => console.log(e));
        }
      } else {
        Swal.fire({
          icon: "error",
          title: "Ooops ...",
          text: "Por favor asegurate de llenar todos los datos",
        });
      }
    },
    addparque() {
      if (
        this.parquesData.name_es != "" &&
        this.parquesData.name_en != "" &&
        this.parquesData.admins != "" &&
        this.parquesData.propi != "" &&
        this.parquesData.region != "" &&
        this.parquesData.Mercado != "" &&
        this.parquesData.industria != "" &&
        this.parquesData.sup_tot != "" &&
        this.parquesData.sup_urb != "" &&
        this.parquesData.sup_urb != "" &&
        this.sup_disComputed != "" &&
        this.parquesData.tipo != "" &&
        this.parquesData.infra != "" &&
        this.parquesData.employeds != ""
      ) {
        var jsons = {
          telefono: `${this.parquesData.code} ${this.parquesData.lada} ${this.parquesData.telefono}`,
          direccion: this.parquesData.direccion,
          col: this.corp.col,
          edo: this.edo,
          mun: this.mun,
          web: this.parquesData.web,
        };

        var params = new URLSearchParams();
        params.append("key_corp", this.$store.state.data.key_corp);
        params.append("nombre_es", this.parquesData.name_es);
        params.append("nombre_en", this.parquesData.name_en);
        params.append("adminParq", this.parquesData.admins);
        params.append("parqProp", this.parquesData.propi);
        params.append("parqIntoParq", "");
        params.append("region", this.parquesData.region);
        params.append("mercado", this.parquesData.Mercado);
        params.append("tipoDeIndustria", this.parquesData.industria);
        params.append("superficieTotal", this.parquesData.sup_tot);
        params.append("superficieUrban", this.parquesData.sup_urb);
        params.append("superficieOcup", this.parquesData.sup_urb);
        params.append("superficieDisp", this.sup_disComputed);
        params.append("tipoDePropiedad", this.parquesData.tipo);
        params.append("ifraestructura", this.parquesData.infra);
        params.append("numEmpleados", this.parquesData.employeds);
        params.append("observacion", "");
        params.append("kmz", "");
        params.append("planMaestro", "");
        params.append("contactName", "");
        params.append("contactEmail", "");
        params.append("reconocimientoPracticas", this.parquesData.record);
        params.append("extras", JSON.stringify(jsons));
        var ctx = this;
        axios
          .post(`${this.$store.state.url}/createpark`, params)
          .then((res) => {
            if (res.data.message == "Listo") {
              for (let i = 0; i < ctx.multiImage.length; i++) {
                let data = new FormData();
                data.append("query", "parks");
                data.append("uniqueName", `${ctx.parquesData.name_es}-${i}`);
                data.append("fichero_usuario", ctx.multiImage[i]);
                var config = {
                  method: "post",
                  url: `${ctx.$store.state.baseUrl}/api/uploadfiles`,
                  headers: { "Content-Type": "image/jpeg" },
                  data: data,
                };
                axios(config)
                  .then(function() {
                    Swal.fire({ text: "Creado" });
                    ctx.$router.push("/");
                  })
                  .catch(function(error) {
                    console.log(error);
                  });
              }
            } else {
              Swal.fire({
                icon: "error",
                title: "Ooops ...",
                text: res.data.err,
              });
            }
            this.closeAction();
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({
          icon: "error",
          title: "Ooops ...",
          text: "Por favor asegurate de llenar todos los datos",
        });
      }
    },
    add(target) {
      this.markers = target.latLng.toJSON();
    },
    watchCp() {
      if (this.corp.cp.length > 4) {
        axios
          .get(
            `http://sepomex.icalialabs.com/api/v1/zip_codes?zip_code=${this.corp.cp}`
          )
          .then((res) => {
            this.cp = res.data.zip_codes;
          })
          .catch((e) => {
            console.log(e);
          });
      }
    },
    addCorp() {
      var params = new URLSearchParams();
      params.append("corporativo", this.corp.spcial);
      params.append("nombre_es", this.corp.name_es);
      params.append("nombre_en", this.corp.name_en);
      params.append("tipoDeSocio", this.type_society);
      params.append("direccion", this.corp.address);
      params.append("cp", this.corp.cp);
      params.append("colonia", this.corp.col);
      params.append("estado", this.edo);
      params.append("municipio", this.mun);
      params.append("celular", "(" + this.corp.lada + ")" + this.corp.cel);
      params.append("inversionRealizadaAnterior", this.corp.inv_ant);
      params.append("inversionRealizadaActual", this.corp.inv_act);
      params.append("inversionAnualSiguiente", this.corp.inv_sig);
      params.append("validadoPor", "admin");
      params.append("status", "1");
      params.append("habilitar", "1");
      params.append("rfc", this.corp.rfc);
      params.append("type", this.society);
      if (
        this.corp.name_en != "" &&
        this.corp.name_es != "" &&
        this.society != "" &&
        this.corp.cp != "" &&
        this.corp.col != "" &&
        this.edo != "" &&
        this.mun != "" &&
        this.corp.address != "" &&
        this.ladaValue != "" &&
        this.codigoPaisValue != "" &&
        this.corp.cel != "" &&
        this.corp.logo
      ) {
        var ctx = this;
        axios
          .post(`${this.$store.state.url}/createcorp`, params)
          .then(() => {
            let data = new FormData();
            data.append("query", "logo");
            data.append("uniqueName", this.corp.name_es);
            data.append("fichero_usuario", this.corp.logo);
            var config = {
              method: "post",
              url: `${this.$store.state.baseUrl}/api/uploadfiles`,
              headers: { "Content-Type": "image/jpeg" },
              data: data,
            };
            axios(config)
              .then(function() {
                Swal.fire("La información se agregó correctamente");
                ctx.$router.push("/");
              })
              .catch(function(error) {
                console.log(error);
              });
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({
          icon: "error",
          title: "Ooops ...",
          text: "Por favor asegurate de llenar todos los datos",
        });
      }
    },
    getParks() {
      var data = new URLSearchParams();
      data.append("id", this.parque);
      axios
        .post(`${this.$store.state.url}/getpark`, data)
        .then((res) => {
          this.park = res.data[0].superficieDisp;
          this.space = parseInt(this.park);
        })
        .catch((e) => console.log(e));
    },
    getAllParks() {
      var data = new URLSearchParams();
      data.append("id", this.id);
      axios
        .post(`${this.$store.state.url}/getallpark`, data)
        .then((res) => {
          this.parks = res.data;
        })
        .catch((e) => console.log(e));
    },
    setSpace() {
      this.space = parseInt(this.park - this.restEsp);
    },
    handleImages(files) {
      this.corp.logo = files[0];
      console.log(this.corp.logo);
    },

    chargeImages(files) {
      this.multiImage = files;
    },
    addUserAction() {
      let params = new URLSearchParams();
      params.append("email", this.addUser.email);
      params.append(
        "fullname",
        this.addUser.name +
          " " +
          this.addUser.lastname +
          " " +
          this.addUser.last
      );
      params.append("status", 1);
      var ctx = this;
      if (
        this.addUser.email != "" &&
        this.addUser.name != "" &&
        this.addUser.lastname != ""
      ) {
        axios
          .post(`${this.$store.state.url}/createuser`, params)
          .then((res) => {
            if (res.data.message == 1) {
              let par = new URLSearchParams();
              par.append("email", ctx.addUser.email);
              par.append("pass", ctx.addUser.pass);
              par.append(
                "fullname",
                `${ctx.addUser.name} ${ctx.addUser.lastname} ${ctx.addUser.last}`
              );
              axios
                .post(`${this.$store.state.url}/getuseridlogin`, par)
                .then((res) => {
                  ctx.createdataUser(res.data);
                })
                .catch((e) => console.log(e));
            } else {
              Swal.fire({
                text: "El correo electronico ya esta en uso",
                icon: "error",
              });
            }
          })
          .catch((e) => console.log(e));
      } else {
        this.alerts();
      }
    },
    addUserActionUltimo() {
      let params = new URLSearchParams();
      params.append("email", this.addUser.email);
      params.append(
        "fullname",
        this.addUser.name +
          " " +
          this.addUser.lastname +
          " " +
          this.addUser.last
      );
      params.append("status", 1);
      const ctx = this;
      if (
        this.addUser.email != "" &&
        this.addUser.name != "" &&
        this.addUser.lastname != ""
      ) {
        axios
          .post(`${this.$store.state.url}/createuser`, params)
          .then((res) => {
            if (res.data.message) {
              let par = new URLSearchParams();
              par.append("email", ctx.addUser.email);
              par.append("pass", ctx.addUser.pass);
              par.append(
                "fullname",
                `${ctx.addUser.name} ${ctx.addUser.lastname} ${ctx.addUser.last}`
              );
              axios
                .post(`${this.$store.state.url}/getuseridlogin`, par)
                .then((res) => {
                  ctx.linkinquilino(ctx.id.id, res.data);
                  ctx.linkinquilino(ctx.id, res.data);
                  ctx.linkinquilino(this.$store.state.parqueOfuser, res.data);
                  ctx.createdataLast(res.data);
                })
                .catch((e) => console.log(e));
            }
          })
          .catch((e) => console.log(e));
      } else {
        this.alerts();
      }
    },
    linkinquilino(id_nave, id_user) {
      let params = new URLSearchParams();
      params.append("query", 1);
      params.append("id", id_nave);
      params.append("id_user", id_user[0].id);
      axios
        .post(`${this.$store.state.url}/naveadmin`, params)
        .then((res) => console.log(res))
        .catch((e) => console.log(e));
    },
    createdataUser(id) {
      let params = new URLSearchParams();
      params.append("id", id[0].id);
      params.append("charge", "Administrador");
      params.append("habilitar", 1);
      params.append("key_corp", this.$store.state.id_corp);
      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then(() => {
          this.closeAction();
        })
        .catch((e) => console.log(e));
      axios.get(
        `${this.$store.state.baseUrl}/mailler?email=${this.addUser.email}&name=${this.addUser.name}&link=${id[0].id}`
      );
    },
    createdataLast(id) {
      let params = new URLSearchParams();
      params.append("id", id[0].id);
      params.append("charge", "AdministradorDeNave");
      params.append("habilitar", 1);
      params.append("key_corp", this.$store.state.data.key_corp);
      axios
        .post(`${this.$store.state.url}/createdatauser`, params)
        .then(() => {
          this.closeAction();
        })
        .catch((e) => console.log(e));
      axios.get(
        `${this.$store.state.baseUrl}/mailler?email=${this.addUser.email}&name=${this.addUser.name}&link=${id[0].id}`
      );
    },
    closeAction() {
      this.$emit("close");
    },
    alerts() {
      Swal.fire({
        icon: "error",
        title: "Ooops ...",
        text: "Por favor asegurate de llenar todos los datos",
      });
    },
    reload() {
      this.$router.push("/");
    },
    addSpaceAction() {
      let extras = {
        name: this.spaces.contact_name,
        phone: this.spaces.contact_phone,
        medidas: [this.spaces.height, this.spaces.width],
        nameSpace: this.spaces.name,
      };
      if (
        this.id[0] != null &&
        this.spaces.price != undefined &&
        this.spaces.type != undefined &&
        this.spaces.use != undefined
      ) {
        let params = new URLSearchParams();
        params.append("query", 2);
        params.append("id", this.id[1]);
        params.append("parque", this.id[0]);
        params.append("precio", this.spaces.price);
        params.append("tipo", this.spaces.type);
        params.append("uso", this.spaces.use);
        params.append("extras", JSON.stringify(extras));
        let ctx = this;
        axios
          .post(`${this.$store.state.url}/espacio`, params)
          .then((res) => {
            if (res.data.message == 1) {
              let lat, lng;
              if(ctx.amMap == false){
                lat = ctx.ubicacionCru.lat;
                lng = ctx.ubicacionCru.lng;
              } else{
                lat = ctx.markers.lat
                lng = ctx.markers.lng
              }
              let paramsMaps = new URLSearchParams();
              paramsMaps.append("name", ctx.spaces.type);
              paramsMaps.append("lat", lat);
              paramsMaps.append("lng", lng);
              paramsMaps.append("filters", ctx.parquesData.infra);
              axios
                .post(`${this.$store.state.url}/mapsup`, paramsMaps)
                .then((res) => {
                  Swal.fire({ text: res.data.message, icon: "success" });
                  ctx.closeAction();
                })
                .catch((e) => console.log(e));
            } else {
              Swal.fire({ text: "Ah ocurrido un error", icon: "error" });
            }
          })
          .catch((e) => console.log(e));
      } else {
        Swal.fire({ text: "Por favor llena todos los datos", icon: "error" });
      }
    },
    getAllspace() {
      let params = new URLSearchParams();
      params.append("query", 3);
      params.append("id", this.id);
      axios
        .post(`${this.$store.state.url}/espacio`, params)
        .then((res) => {
          this.Allspace = res.data;
        })
        .catch((e) => console.log(e));
    },
  },
  computed: {
    edo() {
      if (this.cp.length > 0) {
        return this.cp[0].d_estado;
      } else {
        return "Sin datos";
      }
    },
    mun() {
      if (this.cp.length > 0) {
        return this.cp[0].d_mnpio;
      } else {
        return "Sin datos";
      }
    },
    restEspComputed() {
      return parseInt(this.park - this.restEsp);
    },
    mapsorlat() {
      if (this.gmapsLat) {
        return "Seleccionar en el mapa";
      } else {
        return "Ingresar latitud y longitud";
      }
    },
    officePhone() {
      return `${this.codigoPaisValue} ${this.ladaValue} ${this.corp.cel}`;
    },

    sup_disComputed() {
      return this.parquesData.sup_tot - this.parquesData.sup_oc;
    },
  },
  beforeMount() {
    this.getAllParks();
  },
};
</script>

<style scoped>
.btn {
  background-color: #673ab7;
  padding: 1em;
  color: #fff;
  border-radius: 0.5em;
}
</style>
