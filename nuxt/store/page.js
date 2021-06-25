export const state = () => ({
  title: null,
  isLoading: false,
})

export const mutations = {
  setTitle(state, newTitle) {
    state.title = newTitle
  },
  setLoading(state, data) {
    state.isLoading = data
  }
}
