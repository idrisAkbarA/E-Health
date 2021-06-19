export const state = () => ({
  url: '/api/rekam-medis',
  data: null
})

export const mutations = {
  SET_REKAM_MEDIS(state, data) {
    state.data = data
  }
}

export const actions = {
  getRekamMedis({ state, commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(state.url).then((response) => {
        commit('SET_REKAM_MEDIS', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  },
  getRekamMedisById({ state, commit }, id) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`${state.url}/${id}`).then((response) => {
        commit('SET_REKAM_MEDIS', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  },
  getRekamMedisByPasien({ state, commit }, pasien) {
    return new Promise((resolve, reject) => {
      this.$axios.get(`${state.url}/${pasien}`).then((response) => {
        commit('SET_REKAM_MEDIS', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  }
}
