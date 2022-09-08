import { createStore } from 'vuex'
const store = createStore({
  state : {
    userData: {},
  },
  getters : {
    getUserData(state){
      return state.userData;
    }
  },
  mutations : {
    setUserData(state, val){
      state.userData = val;
    }
  },
});
export default store;