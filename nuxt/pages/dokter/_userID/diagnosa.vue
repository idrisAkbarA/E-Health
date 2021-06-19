<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="7">
        <v-card>
          <v-card-title>
            <v-icon class="mr-3">mdi-stethoscope</v-icon>
            Diagnosa
          </v-card-title>
          <v-card-subtitle>Catat hasil diagnosa pemeriksaan</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text>
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
                    :color="is_resep ? 'success' : ''"
                    :label="is_resep ? 'Aktif' : 'Non-Aktif'"
                    v-model="is_resep"
                  ></v-switch>
                  <v-row v-if="is_resep">
                    <v-col cols="8">
                      <v-select
                        outlined
                        :items="obat"
                        item-text="nama"
                        item-value="id"
                        label="Nama Obat"
                      ></v-select>
                    </v-col>
                    <v-col cols="4">
                      <v-text-field
                        outlined
                        type="number"
                        color="secondary"
                        label="Jumlah"
                        suffix=""
                      ></v-text-field>
                    </v-col>
                    <v-col class="text-center">
                      <v-btn class="mx-2" fab small dark color="primary">
                        <v-icon dark> mdi-plus </v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="5">
        <antrian-poli
          :poli="1"
          @antrian-selected="showDetail"
          status="null"
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
      is_resep: false,
      antrian: {},
      form: {},
      rekamMedis: {
        id: 1,
        pasien_id: 1,
        dokter_id: null,
        poli_id: 1,
        diagnosa: null,
        pengobatan: null,
        resep_obat_id: null,
        total_biaya: null,
        status: null,
        is_bayar: 0,
        created_at: '2021-06-19T08:00:31.000000Z',
        updated_at: '2021-06-19T08:00:32.000000Z',
        pasien: {
          id: 1,
          nama: 'Test',
          nik: '112312',
          tempat_lahir: 'Pekanbaru',
          tanggal_lahir: '2021-06-19',
          jenis_kelamin: 'Laki-Laki',
          agama: 'Kristen',
          pendidikan: null,
          pekerjaan: null,
          alamat: null,
          kontak: null,
          riwayat_penyakit_pribadi: null,
          riwayat_penyakit_keluarga: null,
          riwayat_alergi: null,
          created_at: '2021-06-19T08:15:32.000000Z',
          updated_at: '2021-06-19T08:15:32.000000Z',
        },
        poli: {
          id: 1,
          nama: 'Anak',
          penanggungjawab: 'Dr. Idris',
          keterangan:
            'Poli Spesialis Anak adalah layanan pemeriksaan dan pengobatan terhadap bayi dan anak.',
          created_at: '2021-06-18T12:34:46.000000Z',
          updated_at: '2021-06-18T12:34:46.000000Z',
        },
      },
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
      return this.rekamMedis.pasien
    },
  },
  watch: {
    is_resep(val) {
      if (val) {
        this.form.resep_obat = []
      } else {
        delete this.form.resep_obat
      }
    },
  },
  methods: {
    ...mapActions({ getObat: 'obat/getObat' }),
    showDetail(data) {
      console.log(data)
    },
  },
}
</script>
