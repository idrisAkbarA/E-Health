<template>
  <v-container>
    <div class="ribbon"></div>
    <div style="z-index: 2">
      <v-card class="mt-5" flat style="z-index: 2" color="transparent">
        <h1>Pusat Riwayat Antrian</h1>
        <h4>Lihat dan monitor detail riwayat antrian</h4>
        <h4>Klik antrian untuk melihat detail</h4>
        <v-row class="mt-10 mb-n6">
          <v-col cols="4" class="dflex">
            <v-chip color="primary" label> Antrian Hari Ini </v-chip>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <antrian-poli
              height="400"
              :poliMenu="true"
              header="Sedang Dalam Antrian"
              subHeader="Daftar pasien yang sedang mengantri"
              :poli="null"
              :status="null"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
          <v-col>
            <antrian-poli
              height="400"
              :poliMenu="true"
              icon="mdi-check"
              header="Antrian Selesai"
              subHeader="Daftar antrian yang sudah selesai"
              :poli="null"
              :status="1"
              :antrianSekarang="false"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
          <v-col>
            <antrian-poli
              height="400"
              :poliMenu="true"
              :antrianSekarang="false"
              icon="mdi-debug-step-over"
              header="Dilewati"
              subHeader="Daftar pasien yang tidak hadir setelah dipanggil"
              :poli="null"
              :status="2"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
        </v-row>
        <v-chip color="primary" label class="mt-10 mb-2">
          Riwayat Seluruhnya
        </v-chip>
        <v-row>
          <v-col cols="12">
            <v-data-table
              item-key="name"
              class="elevation-1"
              loading-text="Loading... Please wait"
              :loading="isLoading"
              :headers="headers"
              :items="rekamMedis"
            >
              <template v-slot:[`item.no`]="props">
                {{ props.index + 1 }}
              </template>
              <template v-slot:[`item.status`]="{ item }">
                <v-chip
                  outlined
                  class="ma-2"
                  :color="getStatusColor(item.status)"
                >
                  {{ getStatusText(item.status) }}
                </v-chip>
              </template>
              <template v-slot:[`item.is_bayar`]="{ item }">
                <v-chip
                  class="black--text"
                  :color="item.is_bayar ? 'success' : 'sedondary'"
                  >{{ item.is_bayar ? 'Sudah Bayar' : 'Belum Bayar' }}</v-chip
                >
              </template>
              <template v-slot:[`item.created_at`]="{ item }">
                {{
                  $moment(item.created_at).format('dddd, Do MMMM YYYY', 'id')
                }}
              </template>
              <template v-slot:top>
                <v-card flat>
                  <v-card-title>
                    <v-icon class="mr-4">mdi-history</v-icon> Riwayat Data
                    Pasien
                  </v-card-title>
                  <v-card-subtitle>Lihat riwayat data pasien</v-card-subtitle>
                  <v-card-text>
                    <v-expansion-panels focusable hover>
                      <v-expansion-panel>
                        <v-expansion-panel-header class="pink darken-4">
                          <v-row align="center">
                            <v-icon class="mr-4">mdi-filter</v-icon>
                            <span>Pencarian</span>
                          </v-row>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content class="blue-grey darken-4">
                          <v-container>
                            <v-row>
                              <v-col>
                                <v-text-field
                                  filled
                                  color="secondary"
                                  label="Nama / NIK"
                                  prepend-inner-icon="mdi-account"
                                  v-model="filter.nama"
                                >
                                </v-text-field>
                              </v-col>
                              <v-col>
                                <v-select
                                  filled
                                  color="secondary"
                                  label="Status"
                                  item-text="text"
                                  item-value="status"
                                  prepend-inner-icon="mdi-list-status"
                                  :items="statuses"
                                  v-model="filter.status"
                                >
                                </v-select>
                              </v-col>
                              <v-col>
                                <v-select
                                  filled
                                  color="secondary"
                                  label="Pembayaran"
                                  item-text="text"
                                  item-value="status"
                                  prepend-inner-icon="mdi-cash"
                                  :items="[
                                    { status: 0, text: 'Belum Bayar' },
                                    { status: 1, text: 'Sudah Bayar' },
                                  ]"
                                  v-model="filter.status"
                                >
                                </v-select>
                              </v-col>
                              <v-col>
                                <v-dialog
                                  ref="dialog"
                                  v-model="modal"
                                  :return-value.sync="filter.date"
                                  persistent
                                  width="290px"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      filled
                                      readonly
                                      v-on="on"
                                      v-bind="attrs"
                                      label="Tanggal"
                                      color="secondary"
                                      prepend-inner-icon="mdi-calendar"
                                      v-model="filter.date"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    scrollable
                                    range
                                    header-color="primary"
                                    color="secondary"
                                    locale="id-ID"
                                    v-model="filter.date"
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
                                      @click="$refs.dialog.save(filter.date)"
                                    >
                                      OK
                                    </v-btn>
                                  </v-date-picker>
                                </v-dialog>
                              </v-col>
                            </v-row>
                            <v-row>
                              <v-btn
                                color="primary"
                                class="mr-2"
                                @click="getRekamMedis"
                              >
                                <v-icon>mdi-magnify</v-icon> Cari
                              </v-btn>
                              <v-btn text @click="filter = {}">
                                reset pencarian</v-btn
                              >
                            </v-row>
                          </v-container>
                        </v-expansion-panel-content>
                      </v-expansion-panel>
                    </v-expansion-panels>
                  </v-card-text>
                </v-card>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
      </v-card>
    </div>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  layout: 'pelayanan',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.getRekamMedis()
  },
  data() {
    return {
      title: 'History',
      isLoading: false,
      modal: false,
      rekamMedis: [],
      filter: {},
      statuses: [
        { status: 'null', text: 'Sedang Mengantri' },
        { status: 0, text: 'Tidak Datang' },
        { status: 1, text: 'Selesai' },
      ],
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Pasien', value: 'nama_pasien' },
        { text: 'Status', value: 'status' },
        { text: 'Pembayaran', value: 'is_bayar' },
        { text: 'Tanggal', value: 'created_at' },
      ],
    }
  },
  computed: {
    ...mapState('rekam-medis', { urlRekamMedis: (state) => state.url }),
  },
  methods: {
    getRekamMedis() {
      this.isLoading = true
      this.$axios
        .get(`${this.urlRekamMedis}/history`, { params: this.filter })
        .then((response) => {
          if (response.data.status) {
            this.rekamMedis = response.data.data
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
    getStatusColor(val) {
      switch (val) {
        case null:
          return 'warning'
        case 0:
          return 'info'
        case 1:
          return 'success'
        case 2:
          return 'red'
        default:
          return ''
      }
    },
    getStatusText(val) {
      switch (val) {
        case null:
          return 'Sedang Mengantri'
        case 0:
          return 'Tidak Datang'
        case 1:
          return 'Selesai'
        case 2:
          return 'Skipped'
        default:
          return '-'
      }
    },
    test(item) {
      console.log('current selected', item)
    },
  },
}
</script>
<style>
.ribbon {
  top: 0;
  left: 0;
  position: absolute;
  z-index: 0;
  background: rgb(0, 36, 15);
  background-image: linear-gradient(
    90deg,
    rgb(170, 185, 153) 0%,
    rgba(247, 24, 113, 1) 100%
  );
  background-size: cover;
  background-position: center;
  /* background-size: contain; */
  /* background: url("/images/bg.jpg"); */
  /* background: #33691e; */
  width: 100%;
  height: 400px;
}
</style>
