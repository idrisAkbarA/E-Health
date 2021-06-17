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
      <h4>Poly</h4>
      <p>Isi tujuan poly pasien</p>
      <v-select
        :rules="ruleRequired"
        filled
        label="Poly"
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
  data() {
    return {
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
      modal: false,
      date: null,
      valid: false,
    }
  },
}
</script>