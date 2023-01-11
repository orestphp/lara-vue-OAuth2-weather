import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
const debug = process.env.NODE_ENV !== 'production'

//-------------------------------------------------------------------------
// App module
const app = {
    state: () => ({
        apiUrl: 'http://localhost:8002',
    })
};
// Users module
const users = {
    state: () => ({
        logged_user: {}
    }),
    mutations: {
        setUser(state, user) {
            state.logged_user = user
        }
    },
    getters: {
        loggedUser: state => state.logged_user
    }
};
//----------------------------------------------------------------------

export default new Vuex.Store({
    modules: {
        app,
        users
    },
    strict: debug
})
