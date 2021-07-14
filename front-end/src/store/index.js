import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);
/*
http://18.207.162.106/api
http://localhost:8000/api,
*/
export default new Vuex.Store({
  state: {
    url: "http://18.207.162.106/api",
    img: "http://18.207.162.106/uploads",
    baseUrl: "http://18.207.162.106",
    data: null,
    permisos: null,
    token: "a270c78c-a633-4e22-bb98-172615781bb8",
    id_corp: null,
    type_society: null,
    profileDialog: false,
    parque: null,
    nave: null,
    parqueOfuser: null,
    superAdmin:false,
    profile: false
  },
  mutations: {
    adddata(state, value) {
      state.data = value;
    },
    addpermiso(state, value) {
      state.permisos = value;
    },
    setIdCorp(state, value) {
      state.id_corp = value;
    },
    setTypeSociety(state, value) {
      state.type_society = value;
    },
    changeProfileDialog(state) {
      state.profileDialog = !state.profileDialog;
    },
    setParque(state, value) {
      state.parque = value;
    },
    setNave(state, value) {
      state.nave = value;
    },
    setParqueOfUser(state, value) {
      state.parqueOfuser = value;
    },
    newUserAdmin(state, value){
      state.superAdmin = value;
    },
    closeProfile(state, value){
      state.profile = value;
    }
  },
  actions: {},
  modules: {},
});
