<template>
  <v-container fill-height>
    <v-row style="height: 100%" v-if="dokter && dokter.is_aktif">
      <v-col cols="7" v-if="!isRujuk">
        <v-card class="mb-10">
          <v-card-title>
            <v-icon class="mr-3">mdi-stethoscope</v-icon>
            Diagnosa
          </v-card-title>
          <v-card-subtitle>Catat hasil diagnosa pemeriksaan</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text class="pb-10" v-if="pasien">
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
                  <v-form v-model="formDiagnosa">
                    <v-row>
                      <v-col cols="12">
                        <v-textarea
                          :rules="ruleRequired"
                          outlined
                          color="secondary"
                          label="Diagnosa"
                          v-model="form.diagnosa"
                        ></v-textarea>
                        <v-textarea
                          :rules="ruleRequired"
                          outlined
                          color="secondary"
                          label="Pengobatan"
                          v-model="form.pengobatan"
                        ></v-textarea>
                        <v-text-field
                          :rules="ruleRequired"
                          outlined
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
                :disabled="!formDiagnosa"
                @click="store"
                >Selesai</v-btn
              >
              <v-btn
                dark
                class="mt-3"
                :loading="isLoading"
                :disabled="!formDiagnosa"
                @click="rujukan"
                >Rujuk Pasien</v-btn
              >
            </v-col>
          </v-card-text>
          <v-card-text v-else>
            <p class="text-center">Pilih pasien terlebih daluhu...</p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="7" v-else>
        <v-card class="mb-10 pb-5">
          <v-card-title>
            <v-icon class="mr-3">mdi-stethoscope</v-icon>
            Surat Rujukan
          </v-card-title>
          <v-card-subtitle>Buat Surat Rujukan</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text class="pb-10" v-if="formRujukan.pasien">
            <v-simple-table dense>
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td>Nama</td>
                    <td>: {{ formRujukan.pasien.nama }}</td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ formRujukan.pasien.jenis_kelamin }}</td>
                  </tr>
                  <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td>
                      :
                      {{
                        `${formRujukan.pasien.tempat_lahir}, ${formRujukan.pasien.tanggal_lahir}`
                      }}
                    </td>
                  </tr>
                  <tr v-if="formRujukan.pasien.alamat">
                    <td>Alamat</td>
                    <td>: {{ formRujukan.pasien.alamat }}</td>
                  </tr>
                  <tr v-if="formRujukan.pasien.kontak">
                    <td>Kontak</td>
                    <td>: {{ formRujukan.pasien.kontak }}</td>
                  </tr>
                  <tr v-if="formRujukan.pasien.riwayat_penyakit_pribadi">
                    <td>Riwayat Penyakit Pribadi</td>
                    <td>: {{ formRujukan.pasien.riwayat_penyakit_pribadi }}</td>
                  </tr>
                  <tr v-if="formRujukan.pasien.riwayat_penyakit_keluarga">
                    <td>Riwayat Penyakit Keluarga</td>
                    <td>
                      : {{ formRujukan.pasien.riwayat_penyakit_keluarga }}
                    </td>
                  </tr>
                  <tr v-if="formRujukan.pasien.riwayat_alergi">
                    <td>Riwayat Alergi</td>
                    <td>: {{ formRujukan.pasien.riwayat_alergi }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <v-divider class="my-4"></v-divider>
            <v-form v-model="formSurat">
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    filled
                    :rules="ruleRequired"
                    color="secondary"
                    label="Tujuan Rujukan"
                    hint="*Rumah Sakit tujuan rujukan"
                    v-model="formRujukan.tujuan"
                  ></v-text-field>
                  <v-textarea
                    filled
                    :rules="ruleRequired"
                    color="secondary"
                    label="Diagnosa"
                    v-model="formRujukan.diagnosa"
                  ></v-textarea>
                  <v-textarea
                    filled
                    :rules="ruleRequired"
                    color="secondary"
                    label="Pengobatan"
                    v-model="formRujukan.pengobatan"
                  ></v-textarea>
                  <v-textarea
                    filled
                    :rules="ruleRequired"
                    color="secondary"
                    label="Keadaan"
                    v-model="formRujukan.keadaan"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-form>
            <v-form id="print" class="d-none">
              <h4 style="text-align: center; margin-bottom: 10px">
                Puskesmas Bangkinang Kota
              </h4>
              <hr />
              <h3
                style="
                  text-align: center;
                  margin-bottom: 10px;
                  margin-top: 10px;
                  text-decoration: underline;
                "
              >
                SURAT RUJUKAN
              </h3>
              <div>
                <p>Kepada Yth</p>
                <p>{{ formRujukan.tujuan }}</p>
              </div>
              <br />
              <div>
                <p>Dengan Hormat,</p>
                <p>
                  Mohon perawatan lebih lanjut penderita tersebut di bawah ini :
                </p>
              </div>
              <table dense style="width: 100%; margin-top: 20px">
                <tbody>
                  <tr>
                    <td>Nama</td>
                    <td>: {{ formRujukan.pasien.nama }}</td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ formRujukan.pasien.jenis_kelamin }}</td>
                  </tr>
                  <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td>
                      :
                      {{
                        `${formRujukan.pasien.tempat_lahir}, ${formRujukan.pasien.tanggal_lahir}`
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td>Tujuan Rujukan</td>
                    <td>: {{ formRujukan.tujuan }}</td>
                  </tr>
                  <tr>
                    <td>Diagnosa</td>
                    <td>: {{ formRujukan.diagnosa }}</td>
                  </tr>
                  <tr>
                    <td>Pengobatan</td>
                    <td>: {{ formRujukan.pengobatan }}</td>
                  </tr>
                  <tr>
                    <td>Kondisi</td>
                    <td>: {{ formRujukan.keadaan }}</td>
                  </tr>
                </tbody>
              </table>
              <v-row style="margin-top: 120px">
                <v-col cols="12">
                  <p style="text-align: right">
                    Bangkinang, {{ $moment().format('Do MMMM YYYY', 'id') }}
                  </p>
                </v-col>
              </v-row>
              <br />
              <v-row style="margin-top: 50px">
                <v-col cols="4"></v-col>
                <v-col cols="4"></v-col>
                <v-col cols="4">
                  <hr />
                  <p style="text-align: center">
                    {{ dokter.nama }}
                  </p>
                </v-col>
              </v-row>
            </v-form>
            <v-col cols="12">
              <v-btn
                dark
                color="primary"
                class="mt-3 float-right"
                :loading="isLoading"
                :disabled="!formSurat"
                @click="storeRujukan"
                >Selesai</v-btn
              >
            </v-col>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="5" v-if="dokter">
        <antrian-poli
          :excludePaid="1"
          :poli="dokter.poli_id"
          :status="null"
          :poliMenu="false"
          @antrian-selected="showDetail"
        ></antrian-poli>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-container fill-height>
        <v-row
          justify="center"
          align="center"
          align-content="center"
          no-gutters
        >
          <v-col cols="12">
            <v-img
              max-width="30vw"
              :src="'/pertanyaan.png'"
              class="mx-auto"
            ></v-img>
          </v-col>
          <v-col cols="12">
            <h2 class="mx-auto text-center center-text">
              Status anda tidak aktif. jika terjadi kesalahan, mohon hubungi
              admin
            </h2>
          </v-col>
        </v-row>
        <v-row justify="center" no-gutters> </v-row>
      </v-container>
    </v-row>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
  layout: 'dokter',
  mounted() {
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
      isRujuk: false,
      formDiagnosa: false,
      formSurat: false,
      form: {},
      formRujukan: {},
      resepObat: [],
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
    }
  },
  computed: {
    ...mapState('dokter', { dokter: (state) => state.currentDokter }),
    ...mapState('rekam-medis', { urlRekamMedis: (state) => state.url }),
    ...mapState('surat-rujukan', { urlSuratRujukan: (state) => state.url }),
    ...mapState('obat', {
      urlObat: (state) => state.url,
      obat: (state) => state.data,
    }),
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
    async rujukan() {
      this.formRujukan = this.$_.cloneDeep(this.form)
      this.formRujukan.pasien = this.$_.clone(this.pasien)
      await this.store()
      this.isRujuk = true
    },
    async store() {
      var form = this.form
      form.resep_obat = this.resepObat
      form.dokter_id = this.dokter.id
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
    storeRujukan() {
      var form = this.formRujukan
      form.dokter_id = this.dokter.id
      this.isLoading = true
      this.$axios
        .post(`${this.urlSuratRujukan}`, form)
        .then((response) => {
          if (response.data.status) {
            this.formRujukan = {}
            this.isRujuk = false
            this.print()
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
    async print() {
      // Pass the element id here
      // Get HTML to print from element
      const prtHtml = document.getElementById('print').innerHTML

      // Get all stylesheets HTML
      let stylesHtml = ''
      for (const node of [
        ...document.querySelectorAll('link[rel="stylesheet"], style'),
      ]) {
        stylesHtml += node.outerHTML
      }

      // Open the print window
      const WinPrint = window.open(
        '',
        '',
        'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0'
      )

      WinPrint.document.write(`<!DOCTYPE html>
      <html>
        <head>
          <style>
            tr{
              padding: 5px;
            }
          </style>
          ${stylesHtml}
        </head>
        <body>
          ${prtHtml}
        </body>
      </html>`)

      WinPrint.document.close()
      WinPrint.focus()
      WinPrint.print()
    },
  },
}
</script>
