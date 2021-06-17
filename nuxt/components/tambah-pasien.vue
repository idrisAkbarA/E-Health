<template>
  <v-container>
    <h4>Biodata</h4>
    <p>Isi biodata pasien</p>
    <v-form
      ref="form"
      v-model="valid"
    >
      <v-text-field
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Nama"
        v-model="nama"
        prepend-inner-icon="mdi-account"
      ></v-text-field>
      <v-text-field
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="NIK"
        v-model="nik"
        prepend-inner-icon="mdi-card-account-details"
      ></v-text-field>
      <v-select
        :rules="ruleRequired"
        color="secondary"
        filled
        label="Jenis Kelamin"
        :items="jk"
        v-model="selectedJK"
        prepend-inner-icon="mdi-gender-male-female"
      >
      </v-select>
      <v-text-field
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        v-model="tempatLahir"
        label="Tempat Lahir"
        prepend-inner-icon="mdi-map-marker"
      ></v-text-field>
      <v-dialog
        ref="dialog"
        v-model="modal"
        :return-value.sync="date"
        persistent
        width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            :rules="ruleRequired"
            dense
            filled
            v-model="date"
            color="secondary"
            label="Tanggal Lahir"
            prepend-inner-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="date"
          locale="id-ID"
          header-color="primary"
          color="secondary"
          scrollable
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="secondary"
            @click="modal = false"
          >
            Cancel
          </v-btn>
          <v-btn
            text
            color="secondary"
            @click="$refs.dialog.save(date)"
          >
            OK
          </v-btn>
        </v-date-picker>
      </v-dialog>
      <v-text-field
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Kontak"
        v-model="kontak"
        prepend-inner-icon="mdi-phone"
      ></v-text-field>
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
        :loading="isLoading"
        @click="store()"
      >Simpan</v-btn>
      <v-btn
        text
        color="secondary"
      >Batal</v-btn>
    </v-form>

  </v-container>
</template>
<script>
import { mapState } from 'vuex'
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
    pasienURL() {
      return this.$store.state.pasien.url
    },
  },
  data() {
    return {
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
      modal: false,
      date: null,
      valid: false,
      selectedPoli: null,
      selectedJK: null,
      jk: ['Laki-laki', 'Perempuan'],
      nama: null,
      nik: null,
      kontak: null,
      tempatLahir: null,
      alamat: null,
      isLoading: false,
    }
  },
  methods: {
    store() {
      this.isLoading = true
      var data = {
        nama: this.nama,
        nik: this.nik,
        tempat_lahir: this.tempatLahir,
        tanggal_lahir: this.date,
        kontak: this.kontak,
        jenis_kelamin: this.selectedJK,
        alamat: this.alamat,
        poli_id: this.selectedPoli,
      }
      this.$axios
        .post(this.pasienURL, data)
        .then((response) => {
          console.log(response)
          this.isLoading = false
        })
        .catch((error) => {
          console.log(error)
          this.isLoading = false
        })
    },
  },
}
</script>