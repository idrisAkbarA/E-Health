export const state = () => ({
  url: '/api/dokter',
  data: null,
  currentDokter: null
})

export const mutations = {
  SET_CURRENT_DOKTER(state, data) {
    state.currentDokter = data
  },
  SET_DATA(state, data) {
    state.data = data
  }
}

export const actions = {
  getDokter({ state, commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`${state.url}`).then((response) => {
        commit('SET_DATA', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  },
  getDokterByUserId({ state, commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`${state.url}/user/${id}`).then((response) => {
        commit('SET_CURRENT_DOKTER', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  },
}
