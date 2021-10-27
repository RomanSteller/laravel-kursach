import {createStore} from "vuex";
import axios from "axios";
import '../axios'

export default createStore({
    state: {
        isAuth: null,
        user: null,
        userForId:null
    },
    getters: {
        setAuth(state) {
            return state.isAuth
        },
        setUser(state) {
            return state.user
        },
        setOneUser(state){
            return state.userForId
        }
    },
    mutations: {
        SET_TOKEN(state, payload) {
            state.isAuth = payload
        },
        SET_USER(state, payload) {
            state.user = payload
        },
        SET_USER_FOR_ID(state, payload){
            state.userForId = payload
        }

    },
    actions: {
        async getToken({commit}) {
            const getToken = await axios.get('/api/user', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            });

            if (getToken.data[0]) {
                commit('SET_TOKEN', true);
            } else if (!getToken.data[0]) {
                commit('SET_TOKEN', false);
            }
        },

        async getUser({commit}) {
            try {
                const getToken = await axios.get('/api/user', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                });
                commit('SET_USER', getToken.data[0]);
            } catch (e) {
                console.log(e)
            }
        },

        async getUserForId({commit},id) {
            try {
                const user = await axios.post('api/getUser',{
                    id:id
                });
                commit('SET_USER_FOR_ID',user.data[0]);
            } catch (e) {
                console.log(e)
            }
        }
    }

})

