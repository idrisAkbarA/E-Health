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
        item-text="nama"
        item-value="id"
        prepend-inner-icon="mdi-account"
      ></v-autocomplete>

      <div class="mt-2 mb-2"></div>
      <h4>Poli</h4>
      <p>Isi tujuan Poli pasien</p>
      <v-select
        :search-input.sync="search"
        filled
        label="Poli"
        color="secondary"
        :items="poli"
        item-text="nama"
        item-value="id"
        :rules="ruleRequired"
        v-model="selectedPoli"
      >
        <template v-slot:item="data">
          <!-- HTML that describe how select should render items when the select is open -->
          {{ data.item.nama }} - {{ data.item.id }}
        </template>

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
        .get(urlLiveSearch, { data: value })
        .then((response) => {
          this.pasien = response.data
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