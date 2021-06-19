export const state = () => ({
    data: []
})

export const mutations = {
    setData(state, data) {
        state.data = data
    }

}
export const getters = {
    getAll: state => {
        return state.data;
    },
    getAntrianPoliByID: (state) => (id) => {
        if (!id) {
            console.log('hai');
            return state.data
        }
        return state.data.find(poli => poli.id === id)
    }

}
export const actions = {
    fetchData({ rootState, commit }) {
        this.$axios.get(rootState.pasien.urlAntrian + "/antrian").then(response => {
            commit('setData', response.data.data)
        })
    }
}
