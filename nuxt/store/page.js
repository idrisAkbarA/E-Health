export const state = () => ({
    title: null
})

export const mutations = {
    setTitle(state, newTitle) {
        state.title = newTitle
    }
}