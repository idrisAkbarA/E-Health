<template>
  <v-container>
    <h4>Pilih Pasien</h4>
    <p>Pilih pasien dengan mencari di field berikut</p>
    <v-form
      ref="form"
      v-model="valid"
    >
      <v-autocomplete
        v-model="selectedPasien"
        hide-no-data
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Nama/NIK"
        :items="pasien"
        item-text="search"
        item-color="secondary"
        item-value="id"
        prepend-inner-icon="mdi-account"
        :search-input.sync="search"
      >
        <template v-slot:selection="data">
          <!-- HTML that describe how select should render selected items -->
          {{ data.item.nama }} - {{ data.item.nik}}
        </template>
        <template v-slot:item="data">
          <v-list>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>
                  {{ data.item.nama }}
                </v-list-item-title>
                <v-list-item-subtitle>
                  {{ data.item.nik }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </template>
      </v-autocomplete>

      <div class="mt-2 mb-2"></div>
      <h4>Poli</h4>
      <p>Isi tujuan Poli pasien</p>
      <v-select
        filled
        label="Poli"
        color="secondary"
        :items="poli"
        item-text="nama"
        item-value="id"
        :rules="ruleRequired"
        v-model="selectedPoli"
      >
        <!-- <template v-slot:item="data">
          {{ data.item.nama }} - {{ data.item.nik }}
        </template> -->

      </v-select>
      <v-btn
        :disabled="!valid"
        :loading="isLoading"
        color="primary"
      >Simpan</v-btn>
      <v-btn
        text
        color="secondary"
        @click="resetDataNValidation()"
      >Batal</v-btn>
    </v-form>

  </v-container>
</template>
<script>
export default {
  mounted() {
    // check if required data exist, request it if none
    if (!this.$store.state.poli.data) {
      this.$store.dispatch('poli/getPoli')
    }
  },
  computed: {
    // ...mapState({ poli: 'poli/data' }),
    poli() {
      return this.$store.state.poli.data
    },
  },
  data() {
    return {
      pasienMerged: [],
      itemText: ['nama', 'nik'],
      pasien: [],
      selectedPasien: null,
      search: null,
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
      modal: false,
      date: null,
      valid: false,
      selectedPoli: null,
      isLoading: false,
    }
  },
  methods: {
    getPasien(value) {
      this.isLoading = true
      var urlLiveSearch = this.$store.state.pasien.urlLiveSearch
      this.$axios
        .get(urlLiveSearch, { params: { data: value } })
        .then((response) => {
          var temp = response.data
          temp.forEach((element) => {
            element['search'] = element.nama + ' - ' + element.nik
          })
          this.pasien = temp
          console.table(this.pasien)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
    resetDataNValidation() {
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
    },
  },
  watch: {
    search(val) {
      this.getPasien(val)
    },
  },
}
</script>