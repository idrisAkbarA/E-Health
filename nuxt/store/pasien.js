export const state = () => ({
  url: '/api/pasien',
  urlLiveSearch: '/api/pasien/live/search',
  urlAntrian: '/api/rekam-medis',
  data: []
})

export const mutations = {
  SET_DATA(state, data) {
    state.data = data
  }
}

export const actions = {
  getPasien({ state, commit }) {
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
