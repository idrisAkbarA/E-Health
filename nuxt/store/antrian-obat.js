export const state = () => ({
  url: '/api/antrian-obat',
  data: []
})

export const mutations = {
  SET_DATA(state, data) {
    state.data = data
  }
}

export const getters = {
  getAntrian: (state) => {
    console.log('asd', state.data)
    return state.data
  }
}

export const actions = {
  fetchData({ state, commit }) {
    this.$axios.get(state.url + "/antrian").then(response => {
      commit('SET_DATA', response.data.data)
      console.log('sta')
    })
  }
}
