export const state = () => ({
    data: []
})

export const mutations = {
    setData(state, data) {
        function calculateAge(birthDate) {
            birthDate = new Date(birthDate);
            var now = new Date();

            var years = (now.getFullYear() - birthDate.getFullYear());

            if (now.getMonth() < birthDate.getMonth() ||
                now.getMonth() == birthDate.getMonth() && now.getDate() < birthDate.getDate()) {
                years--;
            }

            return years;
        }
        // set priority atribute
        data.forEach(element => {
            var age = calculateAge(element.pasien.tanggal_lahir);
            element['umur'] = age
            if (age >= 60) {
                element['prioritas_utama'] = true
            } else {
                element['prioritas_utama'] = false;
            }

        });
        state.data = data
    }

}
export const getters = {
    getAll: state => {
        return state.data;
    },
    getAntrianPoliByID: (state) => (id) => {
        if (id === null) {
            console.log('hai');
            return state.data
        }
        return state.data.filter(data =>
            data.poli_id === id
        )
    }

}
export const actions = {
    fetchData({ rootState, commit }) {
        this.$axios.get(rootState.pasien.urlAntrian + "/antrian").then(response => {
            commit('setData', response.data.data)
        })
    }
}
