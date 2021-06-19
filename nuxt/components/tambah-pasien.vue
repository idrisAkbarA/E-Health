<template>
  <v-container>
    <h4>Biodata</h4>
    <p>Isi biodata pasien</p>
    <v-form
      ref="form"
      v-model="valid"
    >
      <v-text-field
        persistent-hint
        hint="Wajib diisi"
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Nama"
        v-model="nama"
        prepend-inner-icon="mdi-account"
      ></v-text-field>
      <v-text-field
        persistent-hint
        hint="Wajib diisi"
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="NIK"
        v-model="nik"
        prepend-inner-icon="mdi-card-account-details"
      ></v-text-field>
      <v-select
        persistent-hint
        hint="Wajib diisi"
        :rules="ruleRequired"
        color="secondary"
        filled
        label="Jenis Kelamin"
        :items="jk"
        v-model="selectedJK"
        prepend-inner-icon="mdi-gender-male-female"
      >
      </v-select>
      <v-select
        color="secondary"
        filled
        label="Agama"
        :items="agama"
        v-model="selectedAgama"
      >
      </v-select>
      <v-text-field
        persistent-hint
        hint="Wajib diisi"
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
            persistent-hint
            hint="Wajib diisi"
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
        persistent-hint
        hint="Wajib diisi"
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Alamat"
        v-model="alamat"
        prepend-inner-icon="mdi-map-marker"
      ></v-text-field>
      <v-text-field
        persistent-hint
        hint="Wajib diisi"
        :rules="ruleRequired"
        dense
        filled
        color="secondary"
        label="Kontak"
        v-model="kontak"
        prepend-inner-icon="mdi-phone"
      ></v-text-field>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Pendidikan"
        v-model="pendidikan"
        prepend-inner-icon="mdi-school"
      ></v-text-field>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Pekerjaan"
        v-model="pekerjaan"
        prepend-inner-icon="mdi-briefcase"
      ></v-text-field>
      <div class="mt-2 mb-2"></div>
      <h4>Riwayat Kesehatan</h4>
      <p>Isi data-data riwayat penyakit pasien</p>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Riwayat Penyakit Pribadi"
        v-model="riwayatPenyakitPribadi"
        prepend-inner-icon="mdi-account-alert"
      ></v-text-field>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Riwayat Penyakit Keluarga"
        v-model="riwayatPenyakitKeluarga"
        prepend-inner-icon="mdi-account-multiple"
      ></v-text-field>
      <v-text-field
        dense
        filled
        color="secondary"
        label="Riwayat Alergi"
        v-model="riwayatAlergi"
        prepend-inner-icon="mdi-allergy"
      ></v-text-field>
      <div class="mt-2 mb-2"></div>
      <h4>Poli</h4>
      <p>Isi tujuan Poli pasien</p>
      <v-select
        color="secondary"
        persistent-hint
        hint="Wajib diisi"
        :rules="ruleRequired"
        filled
        label="Poli"
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
        @click="resetDataNValidation()"
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
    // save original data value
    console.log(this)
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
      selectedAgama: null,
      jk: ['Laki-laki', 'Perempuan'],
      agama: ['Islam', 'Kristen', 'Konghucu', 'Budha', 'Hindu'],
      nama: null,
      nik: null,
      kontak: null,
      tempatLahir: null,
      alamat: null,
      isLoading: false,
      riwayatAlergi: null,
      riwayatPenyakitPribadi: null,
      riwayatPenyakitKeluarga: null,
      pekerjaan: null,
      pendidikan: null,
    }
  },
  methods: {
    // setOriginalData() {
    //   this.$data['originalData'] = this.$data
    // },
    resetData() {
      // this.$data = this.originalData
      // this.$data['originalData'] = this.$data
      this.nama = null
      this.nik = null
      this.tempatLahir = null
      this.date = null
      this.kontak = null
      this.selectedJK = null
      this.alamat = null
      this.selectedPoli = null
      this.valid = true
    },
    resetDataNValidation() {
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
    },
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
        agama: this.selectedAgama,
        riwayat_alergi: this.riwayatAlergi,
        riwayat_penyakit_pribadi: this.riwayatPenyakitPribadi,
        riwayat_penyakit_keluarga: this.riwayatPenyakitKeluarga,
        pekerjaan: this.pekerjaan,
        pendidikan: this.pendidikan,
      }
      this.$axios
        .post(this.pasienURL, data)
        .then((response) => {
          console.log(response)
          this.resetDataNValidation()
          // this.resetData()
          this.isLoading = false
          this.$snackbar('success', response.data.message, true)
        })
        .catch((error) => {
          console.log(error)
          this.isLoading = false
        })
    },
  },
}
</script>