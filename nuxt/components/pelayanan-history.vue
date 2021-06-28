<template>
  <v-container>
    <div :class="noRibbon ? '' : 'ribbon notprint'"></div>
    <div
      class="notprint"
      style="z-index: 2"
    >
      <v-card
        class="mt-5"
        flat
        style="z-index: 2"
        color="transparent"
      >
        <h1>Pusat Riwayat Antrian</h1>
        <h4>Lihat dan monitor detail riwayat antrian</h4>
        <h4>Klik antrian untuk melihat detail</h4>
        <v-row class="mt-10 mb-n6">
          <v-col
            cols="4"
            class="dflex"
          >
            <v-chip
              color="primary"
              label
            > Antrian Hari Ini </v-chip>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <antrian-poli
              :excludePaid="1"
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
        <v-chip
          color="primary"
          label
          class="mt-10 mb-2"
        >
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
                >{{ item.is_bayar ? 'Sudah Bayar' : 'Belum Bayar' }}</v-chip>
              </template>
              <template v-slot:[`item.created_at`]="{ item }">
                {{
                  $moment(item.created_at).format(
                    'dddd, Do MMMM YYYY HH:mm:ss',
                    'id'
                  )
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
                    <v-expansion-panels
                      focusable
                      hover
                    >
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
                                  v-model="filter.pembayaran"
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
                              <v-btn
                                text
                                @click="filter = {}"
                              >
                                reset pencarian</v-btn>
                              <v-spacer></v-spacer>
                              <v-btn
                                @click="print()"
                                color="primary"
                              >
                                <v-icon class="mr-2">mdi-printer</v-icon>Cetak Laporan
                              </v-btn>
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
    <div class="print">
      <v-card flat>
        <v-container>
          <v-row class="d-flex justify-center">
            <v-col cols="2">

              <v-img
                @load="setImageLoaded(1)"
                class="mx-auto"
                max-width="50"
                src="/logo-bangkinang.png"
              ></v-img>
            </v-col>
            <v-col
              cols="8"
              class="text-center"
            >
              <h4>PEMERINTAH KABUPATEN KAMPAR DINAS KESEHATAN</h4>
              <h4>UPT BLUD PUSKESMAS BANGKINANG KOTA</h4>
              <p>Jln. PROF. M. YAMIN, SH – BANGKINANG
                KODE POS : 28411
              </p>
            </v-col>
            <v-col cols="2">
              <v-img
                @load="setImageLoaded(1)"
                class="mx-auto"
                max-width="60"
                src="/icon.png"
              ></v-img>
            </v-col>
          </v-row>
          <v-row>
            <v-divider></v-divider>
          </v-row>
          <v-row>
            <div class="ml-4 mt-4">
              <h3>Laporan Pelayanan</h3>
              <p>Tanggal laporan dibuat:{{" "+this.$moment(new Date()).format('dddd, Do MMMM YYYY', 'id')}}</p>
            </div>
          </v-row>
        </v-container>
      </v-card>
      <v-simple-table v-if="!isLoading">

        <!-- height="500px" -->
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                #
              </th>
              <th class="text-left">
                Nama Pasien
              </th>
              <th class="text-left">
                Status
              </th>
              <th class="text-left">
                Pembayaran
              </th>
              <th class="text-left">
                Tanggal
              </th>
            </tr>
          </thead>
          <tbody>
            <template>
              <tr
                v-for="(data,index) in printData"
                :key="index"
              >
                <td>{{index+1}}</td>
                <td>{{data.nama_pasien}}</td>
                <td>{{getStatusText(data.status)}}</td>
                <td>
                  <v-chip
                    outlined
                    v-if="data.is_bayar"
                    color="success"
                  >{{data.is_bayar?"Sudah Bayar":"Belum Bayar"}}</v-chip>
                  <v-chip
                    outlined
                    v-else
                    color="secondary"
                  >{{data.is_bayar?"Sudah Bayar":"Belum Bayar"}}</v-chip>
                </td>
                <td>{{$moment(data.created_at).format("Do MMMM YYYY HH:mm:ss","id")}}</td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
    </div>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  props: {
    noRibbon: {
      default: false,
    },
  },
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
      image1: false,
      image2: false,
      printData: [],
      isExport: null,
      title: 'History',
      isLoading: false,
      modal: false,
      rekamMedis: [],
      filter: {},
      statuses: [
        { status: 'null', text: 'Sedang Mengantri' },
        { status: 0, text: 'Tidak Datang' },
        { status: 1, text: 'Selesai' },
        { status: 2, text: 'Skipped' },
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
    async print() {
      // this.filter['isExport'] = true
      this.printData = this.rekamMedis
      let setTheme = async () => {
        return new Promise((resolve) => {
          this.$vuetify.theme.dark = !this.$vuetify.theme.dark
          resolve()
          // while (this.image1 == true && this.image1 == true) {
          // }
        })
      }
      await setTheme()
      window.print()
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark
    },
    setImageLoaded(index) {
      if (index == 1) {
        this.image1 = true
      } else {
        this.image2 = true
      }
    },
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
.print {
  position: absolute;
  top: 0;
  /* display: none; */
  visibility: hidden;
}
@media print {
  * {
    color-adjust: exact;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  .notprint {
    display: none;
  }
  /* *:not(.print) {
    display: none;
  } */
  .print {
    display: block !important;
    visibility: visible;
  }
}
</style>
