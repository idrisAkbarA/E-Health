export const state = () => ({
  url: '/api/poli',
  data: null
})

export const mutations = {
  setPoli(state, data) {
    state.data = data
  }
}

export const actions = {
  getPoli({ state, commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(state.url).then((response) => {
        commit('setPoli', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  }
}
