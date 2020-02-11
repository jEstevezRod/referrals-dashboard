import Vue from 'vue';
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        // DOMAINS STATE
        domainsState: [],
        treeState: []
    },
    actions: {
        // DOMAINS ACTIONS
        createDomain({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('newDomain', payload).then(response => {
                    commit('addDomain', response.data.domain);
                    resolve();
                })
            })
        },
        listDomains({commit}) {
            return new Promise(((resolve, reject) => {
                axios.get('domains').then(response => {
                    commit('setDomains', response.data.data);
                })
            }))
        },
        deleteDomain({commit}, payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('deleteDomain/' + payload).then(response => {
                    commit('deleteDomain', response.data.id)
                })
            }))
        },
        // CATEGORIES ACTIONS
        createCategory({commit}, payload) {
            return new Promise(((resolve, reject) => {
                axios.post('addCategory', payload).then(response => {
                    commit('updateDomains', response.data.domainChanged);
                })
            }))
        },
        deleteCategory({commit, dispatch}, payload) {
            return new Promise(((resolve, reject) => {
                axios.delete('deleteCategory/' + payload).then(response => {
                    dispatch('listDomains')
                })
            }))
        },
        // PRODUCT ACTIONS

        createProduct({dispatch}, payload) {
            return new Promise(((resolve, reject) => {
                axios.post('createProduct', payload).then(response => {
                    resolve(response.data.product);
                })
            }))
        },

        loadTree({commit}, payload) {
            return new Promise(((resolve, reject) => {
                axios.get('loadTree/' + payload).then(res => {
                    console.log(res)
                    commit('setTree', res.data)
                })
            }))
        },
        // JSON
        exportJson({commit}, payload) {
            return new Promise(((resolve, reject) => {
                axios.get('downloadJson/' + payload).then(res => {
                    resolve(res.data)
                })
            }))
        }

    },
    mutations: {
        // DOMAINS MUTATIONS
        setDomains(state, payload) {
            state.domainsState = payload;
        },

        addDomain(state, domain) {
            state.domainsState.push(domain);
        },

        deleteDomain(state, domainId) {
            state.domainsState = state.domainsState.filter((dom) => dom.id != domainId)

        },
        // CATEGORIES MUTATIONS

        updateDomains(state, domain) {
            state.domainsState.splice(state.domainsState.map(e => e.id).indexOf(domain.id), 1, domain)
        },

        // PRODUCTS MUTATIONS
        setTree(state, tree) {
            state.treeState = tree;
        }
    },
    getters: {
        // DOMAINS GETTERS
        domains: state => state.domainsState,

        tree: state => state.treeState
    }
})
