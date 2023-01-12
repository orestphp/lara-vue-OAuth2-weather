import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
const debug = process.env.NODE_ENV !== 'production'
const apiUrl = 'http://localhost:8002';
//-------------------------------------------------------------------------
// App module
const app = {
    state: () => ({
        apiUrl: apiUrl,
    })
};
// Users module
const users = {
    state: () => ({
        loggedUser: {},
        apiUrl: apiUrl,
    }),
    mutations: {
        setUser(state, user) {
            state.loggedUser = user
        }
    },
    actions: {
        getUser({commit, state}) {
            return new Promise((resolve, reject) => {
                axios.get(`${state.apiUrl}/api/user/1`)
                    .then(result => {
                        commit('setUser', result.data);
                        resolve();
                    })
                    .catch(error => {
                        reject(error.response && error.response.data.message || 'Error.');
                    });
            });
        }
    },
    getters: {
        loggedUser: state => state.loggedUser
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
