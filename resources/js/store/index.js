import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
const debug = process.env.NODE_ENV !== 'production';

//-------------------------------------------------------------------------
// Users module
const users = {
    state: () => ({
        loggedUser: {},
    }),
    mutations: {
        setUser(state, user) {
            state.loggedUser = user
        },
    },
    actions: {
        async getUser({commit}) {
            // get User
            const token = localStorage.getItem('token');
            if(token!=="") {
                await axios.get(`${process.env.MIX_API_URL}/user/${token}`)
                    .then(result => {
                         commit('setUser', result.data);
                    })
                    .catch(error => {
                        console.log(error.response && error.response.data.message || 'Error.');
                    });
            } else {
                // Logout
                await commit('setUser', {});
            }
        }
    },
    getters: {
        loggedUser: state => state.loggedUser,
    }
};
//----------------------------------------------------------------------

export default new Vuex.Store({
    modules: {
        users
    },
    strict: debug
});
