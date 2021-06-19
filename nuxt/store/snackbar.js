export const state = () => ({
  data: {
    color: null,
    message: null,
    value: false,
  },
})

export const mutations = {
  set(state, data) {
    state.data = data
  }
}
