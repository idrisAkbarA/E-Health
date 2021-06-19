export const state = () => ({
  url: '/api/obat',
  data: null
})

export const mutations = {
  SET_OBAT(state, data) {
    state.data = data
  }
}

export const actions = {
  getObat({ state, commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(state.url).then((response) => {
        commit('SET_OBAT', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  }
}
