export const state = () => ({
  url: '/api/poli',
  data: []
})

export const mutations = {
  getPoli() {
    //
  }
}

export const actions = {
  getPoli(state) {
    return new Promise((resolve, reject) => {
      this.$axios.get(state.url).then((response) => {
        console.log(response);
        state.data = response.data
        resolve(response);
      }).catch(error => {
        console.log(error);
        reject(error);
      })
    })
  }
}
