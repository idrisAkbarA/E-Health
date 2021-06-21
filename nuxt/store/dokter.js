export const state = () => ({
  url: '/api/dokter',
  data: null,
  currentDokter: null
})

export const mutations = {
  SET_CURRENT_DOKTER(state, data) {
    state.currentDokter = data
  }
}

export const actions = {
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
