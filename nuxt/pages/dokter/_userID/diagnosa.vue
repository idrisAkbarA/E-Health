<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="7">
        <v-card class="mb-10">
          <v-card-title>
            <v-icon class="mr-3">mdi-stethoscope</v-icon>
            Diagnosa
          </v-card-title>
          <v-card-subtitle>Catat hasil diagnosa pemeriksaan</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text class="pb-15" v-if="pasien">
            <v-simple-table dense>
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td>Nama</td>
                    <td>: {{ pasien.nama }}</td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ pasien.jenis_kelamin }}</td>
                  </tr>
                  <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td>
                      : {{ `${pasien.tempat_lahir}, ${pasien.tanggal_lahir}` }}
                    </td>
                  </tr>
                  <tr v-if="pasien.alamat">
                    <td>Alamat</td>
                    <td>: {{ pasien.alamat }}</td>
                  </tr>
                  <tr v-if="pasien.kontak">
                    <td>Kontak</td>
                    <td>: {{ pasien.kontak }}</td>
                  </tr>
                  <tr v-if="pasien.riwayat_penyakit_pribadi">
                    <td>Riwayat Penyakit Pribadi</td>
                    <td>: {{ pasien.riwayat_penyakit_pribadi }}</td>
                  </tr>
                  <tr v-if="pasien.riwayat_penyakit_keluarga">
                    <td>Riwayat Penyakit Keluarga</td>
                    <td>: {{ pasien.riwayat_penyakit_keluarga }}</td>
                  </tr>
                  <tr v-if="pasien.riwayat_alergi">
                    <td>Riwayat Alergi</td>
                    <td>: {{ pasien.riwayat_alergi }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <v-divider class="my-4"></v-divider>
            <v-expansion-panels focusable hover>
              <v-expansion-panel>
                <v-expansion-panel-header class="pink darken-4">
                  Diagnosa
                </v-expansion-panel-header>
                <v-expansion-panel-content class="blue-grey darken-4">
                  <p class="text-secondary mt-3">Hasil diagnosa pasien</p>
                  <v-form>
                    <v-row>
                      <v-col cols="12">
                        <v-textarea
                          outlined
                          color="secondary"
                          label="Diagnosa"
                          v-model="form.diagnosa"
                        ></v-textarea>
                        <v-textarea
                          outlined
                          color="secondary"
                          label="Pengobatan"
                          v-model="form.pengobatan"
                        ></v-textarea>
                        <v-text-field
                          type="number"
                          min="0"
                          color="secondary"
                          label="Total Biaya"
                          hint="*Total biaya belum termasuk harga obat"
                          prefix="Rp."
                          v-model="form.total_biaya"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-expansion-panel-content>
              </v-expansion-panel>
              <v-expansion-panel>
                <v-expansion-panel-header class="pink darken-4">
                  Resep Obat
                </v-expansion-panel-header>
                <v-expansion-panel-content class="blue-grey darken-4">
                  <p class="text-secondary mt-3">
                    Resep obat akan langsung dikirim ke bagian Farmasi.
                  </p>
                  <v-switch
                    inset
                    small
                    :color="isResep ? 'success' : ''"
                    :label="isResep ? 'Aktif' : 'Non-Aktif'"
                    v-model="isResep"
                  ></v-switch>
                  <v-card-text v-if="isResep">
                    <v-row
                      v-for="(resep, index) in resepObat.resep_obat"
                      :key="index"
                    >
                      <v-col cols="8">
                        <v-select
                          outlined
                          :items="obat"
                          item-text="nama"
                          item-value="id"
                          label="Nama Obat"
                          v-model="resep.obat"
                        ></v-select>
                      </v-col>
                      <v-col cols="4">
                        <v-text-field
                          outlined
                          type="number"
                          color="secondary"
                          label="Jumlah"
                          suffix="Satuan"
                          v-model="resep.jumlah"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-textarea
                      outlined
                      label="Catatan"
                      hint="catatan dosis dan penggunaan obat"
                      v-model="resepObat.catatan"
                    ></v-textarea>
                    <v-col class="text-center">
                      <v-btn
                        class="mx-2"
                        fab
                        small
                        dark
                        color="primary"
                        @click="tambahResep"
                      >
                        <v-icon dark> mdi-plus </v-icon>
                      </v-btn>
                    </v-col>
                  </v-card-text>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
            <v-col cols="12">
              <v-btn
                dark
                color="primary"
                class="mt-3 float-right"
                :loading="isLoading"
                @click="store"
                >Simpan</v-btn
              >
            </v-col>
          </v-card-text>
          <v-card-text v-else>
            <p class="text-center">Pilih pasien terlebih daluhu...</p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="5">
        <antrian-poli
          :poli="1"
          @antrian-selected="showDetail"
          :status="null"
        ></antrian-poli>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
  layout: 'dokter',
  created() {
    this.$store.commit('page/setTitle', this.title)
    this.getObat()
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Diagnosa',
      isLoading: false,
      isResep: false,
      form: {},
      resepObat: [],
    }
  },
  computed: {
    ...mapState('obat', { urlObat: (state) => state.url }),
    ...mapState('rekam-medis', { urlRekamMedis: (state) => state.url }),
    obat: {
      get: function () {
        return this.$store.state.obat.data ?? []
      },
      set: function (v) {
        this.$store.commit('obat/SET_OBAT', v)
      },
    },
    pasien() {
      return this.form.pasien
    },
  },
  watch: {
    isResep(val) {
      if (val) {
        this.resepObat = { resep_obat: [{}] }
      } else {
        delete this.resepObat
      }
    },
    pasien(val) {
      if (!val) {
        this.form = {}
      }
    },
    form(val) {
      if (this.$_.isEmpty(val)) {
        this.isResep = false
      }
    },
  },
  methods: {
    ...mapActions({ getObat: 'obat/getObat' }),
    showDetail(data) {
      this.form = this.$_.clone(data)
    },
    tambahResep() {
      this.resepObat.resep_obat.push({})
    },
    store() {
      var form = this.form
      form.resep_obat = this.resepObat
      form.dokter_id = this.$auth.user.id
      form.status = 1
      this.isLoading = true
      this.$axios
        .put(`${this.urlRekamMedis}/${form.id}`, form)
        .then((response) => {
          if (response.data.status) {
            this.form = {}
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
          this.$snackbar('danger', err)
        })
        .then(() => {
          this.isLoading = false
        })
    },
  },
}
</script>
