<template>
  <v-container>
    <h4>Pilih Pasien</h4>
    <p>Pilih pasien dengan mencari di field berikut</p>
    <v-form
      ref="form"
      v-model="valid"
    >
      <v-autocomplete
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Nama/NIK"
        prepend-inner-icon="mdi-account"
      ></v-autocomplete>

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
        v-model="selectedPoli"
      >

      </v-select>
      <v-btn
        :disabled="!valid"
        color="primary"
      >Simpan</v-btn>
      <v-btn
        text
        color="secondary"
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
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
      modal: false,
      date: null,
      valid: false,
      selectedPoli: null,
    }
  },
}
</script>