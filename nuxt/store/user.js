export const state = () => ({
  url: '/api/user',
  data: null
})

export const mutations = {
  SET_USERS(state, data) {
    state.data = data
  }
}

export const actions = {
  getUsers({ state, commit }) {
    return new Promise((resolve, reject) => {
      this.$axios.get(state.url).then((response) => {
        commit('SET_USERS', response.data.data)
        resolve(response);
      }).catch(error => {
        console.error(error);
        reject(error);
      })
    })
  }
}
