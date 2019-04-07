import {AuthHttp} from '@/helpers/http-helper'
import router from '@/router/index'

const state = {
  token: {
    access_token: '',
    token_type: '',
    expires_in: '',
    scope: '',
    jti: '',
    test: ''
  },
  errors: {
    email: '',
    password: ''
  },
}

const getters = {
  getToken: state => state.token,
  getErrors: state => state.errors
}

const mutations = {
  setToken (state, token) {
    state.token = token
  },
  setError (state, errors) {
    state.errors = errors
  }
}

const actions = {
  login ({ commit }, user) {
    let formData = new FormData()
    formData.set('email', user.email)
    formData.set('password', user.password)
    formData.set('grant_type', 'password')

    AuthHttp.post('api/auth/login', formData)
      .then(response => {
        commit('setToken', response.data.aye_token)
        router.push({name: 'dashboard'})
      }).catch(e => {
      commit('setError', e.response.data.errors)
      localStorage.setItem('vuex', '')
    })
  }
}

export default {
  namespaced: true,

  state: state,
  getters: getters,
  mutations: mutations,
  actions: actions
}
