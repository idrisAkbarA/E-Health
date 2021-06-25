export const state = () => ({
  url: '/api/antrian-obat',
  data: null
})

export const mutations = {
  SET_DATA(state, data) {
    state.data = data
  }
}

export const getters = {
  getAntrian: (state) => {
    return state.data
  }
}

export const actions = {
  fetchData({ state, commit }) {
    this.$axios.get(state.url + "/antrian").then(response => {
      commit('SET_DATA', response.data.data)
      console.log('sta')
    })
  },
  getAntrianObat({ state, commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(state.url).then((response) => {
        commit('SET_DATA', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  }
}
