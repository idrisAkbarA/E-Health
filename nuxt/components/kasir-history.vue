<template>
  <v-container>
    <div :class="noRibbon?'':'ribbon notprint'"></div>
    <div
      class="notprint"
      style="z-index:2"
    >
      <v-card
        class="mt-5 "
        flat
        style="z-index:2"
        color="transparent"
      >
        <h1>
          Pusat Riwayat Pembayaran
        </h1>
        <h4>Lihat dan monitor pembayaran</h4>
        <h4>Klik antrian untuk melihat detail</h4>
        <v-row class="mt-10 mb-n6">
          <v-col
            cols="4"
            class="dflex"
          >
            <v-chip
              color="primary"
              label
            >
              Antrian Hari Ini
            </v-chip>
          </v-col>

        </v-row>
        <v-row>
          <v-col>
            <antrian-poli
              :height="450"
              :excludePaid="1"
              :poliMenu="true"
              header="Sedang Dalam Antrian Pembayaran"
              subHeader="Daftar pasien yang sedang mengantri"
              :poli="null"
              :status="1"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
          <v-col>
            <antrian-poli
              :height="450"
              :paidOnly="true"
              :poliMenu="true"
              icon="mdi-cash-check"
              header="Sudah Bayar"
              subHeader="Daftar antrian yang sudah bayar"
              :poli="null"
              :status="1"
              :antrianSekarang="false"
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
            <v-card flat>
              <v-card-title>
                <v-icon class="mr-4">mdi-history</v-icon> Riwayat Data Pasien
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
                        <v-icon class="mr-4">mdi-filter</v-icon> <span>Pencarian</span>
                      </v-row>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content class="blue-grey darken-4">
                      <v-container>
                        <v-form
                          ref="form"
                          v-model="valid"
                        >

                          <v-row>
                            <v-col>
                              <v-text-field
                                prepend-inner-icon="mdi-account"
                                color="secondary"
                                label="Cari Nama"
                                v-model="nama"
                              >
                              </v-text-field>
                            </v-col>
                            <v-col>
                              <v-select
                                hide-details
                                prepend-inner-icon="mdi-bank"
                                :items="listPoli ? listPoliWithAll : []"
                                item-text="nama"
                                item-value="id"
                                v-model="poli"
                                color="secondary"
                                label="Pilih Poli"
                              ></v-select>
                            </v-col>
                            <v-col>
                              <v-select
                                hide-details
                                prepend-inner-icon="mdi-cash-multiple"
                                :items="status_bayar"
                                item-text="nama"
                                item-value="status"
                                v-model="status"
                                color="secondary"
                                label="Status bayar"
                              ></v-select>
                            </v-col>
                            <v-col>
                              <v-dialog
                                ref="dialog"
                                v-model="modal"
                                :return-value.sync="date"
                                persistent
                                width="290px"
                              >
                                <template v-slot:activator="{ on, attrs }">
                                  <v-text-field
                                    v-model="date"
                                    color="secondary"
                                    label="Tanggal"
                                    prepend-inner-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  range
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
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-btn
                              :loading="isLoading"
                              color="primary"
                              class="mr-2"
                              @click="getData()"
                            >
                              <v-icon>mdi-magnify</v-icon> Cari
                            </v-btn>
                            <v-btn
                              text
                              @click="resetDataNValidation()"
                            > reset pencarian</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn
                              @click="print()"
                              color="primary"
                            >
                              <v-icon class="mr-2">mdi-printer</v-icon>Cetak Laporan
                            </v-btn>
                          </v-row>
                        </v-form>
                      </v-container>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </v-card-text>
            </v-card>
            <transition
              name="fade-transition"
              mode="out-in"
            >
              <v-card
                v-if="isLoading"
                width="100%"
              >
                <v-skeleton-loader
                  class="mx-auto"
                  width="100%"
                  type="table-row"
                ></v-skeleton-loader>
                <v-skeleton-loader
                  class="mx-auto"
                  width="100%"
                  type="table-row"
                ></v-skeleton-loader>
                <v-skeleton-loader
                  class="mx-auto"
                  width="100%"
                  type="table-row"
                ></v-skeleton-loader>
                <v-skeleton-loader
                  class="mx-auto"
                  width="100%"
                  type="table-row"
                ></v-skeleton-loader>
              </v-card>
            </transition>
            <transition
              name="fade-transition"
              mode="out-in"
            >

              <v-simple-table v-if="!isLoading">
                <!-- height="500px" -->
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">
                        #
                      </th>
                      <th class="text-left">
                        Nama
                      </th>
                      <th class="text-left">
                        Poli
                      </th>
                      <th class="text-left">
                        Status Bayar
                      </th>
                      <th class="text-left">
                        Tanggal Dibuat
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <template>
                      <tr
                        v-for="(data,index) in dataHistory.data"
                        :key="index"
                      >
                        <td>{{index+1}}</td>
                        <td>{{data.pasien.nama}}</td>
                        <td>{{data.nama_poli}}</td>
                        <td>
                          <v-chip
                            v-if="data.is_bayar"
                            class="black--text"
                            color="success"
                          >{{data.is_bayar?"Sudah Bayar":"Belum Bayar"}}</v-chip>
                          <v-chip
                            v-else
                            class="black--text"
                            color="secondary"
                          >{{data.is_bayar?"Sudah Bayar":"Belum Bayar"}}</v-chip>
                        </td>
                        <td>{{$moment(data.created_at).format("Do MMMM YYYY","id")}}</td>
                      </tr>
                    </template>
                  </tbody>
                </template>
              </v-simple-table>
            </transition>
            <v-card>
              <v-card-text>
                <v-container>
                  <v-row align="center">
                    <v-spacer></v-spacer>
                    <span class="mr-2">Item per Halaman:</span>
                    <div
                      class="mr-2"
                      style="width:75px"
                    >
                      <v-select
                        :items="dataPerPage"
                        v-model="perPage"
                        dense
                        solo-inverted
                        color="secondary"
                        hide-details
                      ></v-select>

                    </div>
                    <span> {{"Halaman "+dataHistory.current_page+" dari "+dataHistory.last_page}}</span>
                    <v-btn
                      :disabled="!dataHistory.prev_page_url"
                      @click="goPrev()"
                      icon
                    >
                      <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn
                      :disabled="!dataHistory.next_page_url"
                      @click="goNext()"
                      icon
                    >
                      <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                  </v-row>
                </v-container>
              </v-card-text>
            </v-card>
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
              <h3>Laporan Kasir</h3>
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
                Nama
              </th>
              <th class="text-left">
                Poli
              </th>
              <th class="text-left">
                Status Bayar
              </th>
              <th class="text-left">
                Tanggal Dibuat
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
                <td>{{data.pasien.nama}}</td>
                <td>{{data.nama_poli}}</td>
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
                <td>{{$moment(data.created_at).format("Do MMMM YYYY","id")}}</td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
    </div>
  </v-container>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import AntrianPoli from './antrian-poli.vue'
export default {
  props: {
    noRibbon: {
      default: false,
    },
  },

  components: {
    'antrian-poli': AntrianPoli,
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.getData()
  },
  layout: 'kasir',
  head() {
    return {
      title: this.title,
    }
  },
  watch: {
    perPage(v) {
      if (!this.isExport) {
        this.getData()
      }
    },
    date(v) {
      console.log('date', v)
    },
    tanggal(v) {
      console.log('tanggal', v)
    },
  },
  computed: {
    ...mapState('poli', { listPoli: (state) => state.data }),
    listPoliWithAll() {
      var temp = JSON.parse(JSON.stringify(this.listPoli))
      var all = {
        id: null,
        nama: 'Semua Poli',
      }
      var none = {
        id: '-',
        nama: 'Tidak memiliki poli',
      }
      temp.push(all)
      temp.push(none)
      return temp
    },
    tanggal() {
      if (!this.date) {
        return null
      }
      if (!this.date[1]) {
        var temp = []
        temp[0] = this.date[0]
        temp[1] = this.date[0]
        return temp
      }
      return this.date
    },
  },
  data() {
    return {
      printData: [],
      isExport: null,
      perPage: 5,
      dataPerPage: [5, 15, 30],
      dataHistory: [],
      isLoading: false,
      status: null,
      valid: false,
      nama: null,
      poli: null,
      statusBayar: { statusBayar: null },
      date: null,
      modal: false,
      status_bayar: [
        { status: 0, nama: 'Belum Bayar' },
        { status: 1, nama: 'Sudah Bayar' },
      ],
      poli: null,
      title: 'History',
      headers: [
        {
          text: 'Nama',
          align: 'start',
          sortable: false,
          value: 'nama',
        },
        { text: 'Poli', value: 'poli' },
        { text: 'Status Bayar', value: 'status_bayar' },
        { text: 'Tanggal', value: 'tanggal' },
      ],
      dataHistory: [
        {
          nama: 'Charles',
          poli: 'Umum',
          status_bayar: 'Lunas',
          tanggal: '2 Desember 2019',
        },
        {
          nama: 'Charles',
          poli: 'Umum',
          status_bayar: 'Lunas',
          tanggal: '2 Desember 2019',
        },
        {
          nama: 'Charles',
          poli: 'Umum',
          status_bayar: 'Lunas',
          tanggal: '2 Desember 2019',
        },
        {
          nama: 'Charles',
          poli: 'Umum',
          status_bayar: 'Lunas',
          tanggal: '2 Desember 2019',
        },
      ],
    }
  },
  methods: {
    async print() {
      this.isExport = true
      var temp = this.perPage
      this.perPage = null
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark
      await this.getData()
      this.perPage = temp
      window.print()
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark
    },
    test(item) {
      console.log('current selected', item)
    },
    goNext() {
      var page = this.dataHistory.next_page_url.split('=')[1]
      this.getData(page)
    },
    goPrev() {
      var page = this.dataHistory.prev_page_url.split('=')[1]
      this.getData(page)
    },
    async getData(page) {
      this.isLoading = true
      var url = this.$store.state.pasien.urlAntrian
      await this.$axios
        .get(url, {
          params: {
            isExport: this.isExport,
            nama: this.nama,
            poli: this.poli,
            tanggal: this.tanggal,
            status_bayar: this.status,
            perPage: this.perPage,
            page,
          },
          // responseType: this.isExport ? 'blob' : null,
        })
        .then((response) => {
          console.log(response.data)
          if (this.isExport) {
            this.printData = response.data
            console.log(this.printData)
            // this.$download(response.data, 'file.pdf')
          } else {
            this.dataHistory = response.data
          }
        })
        .finally(() => {
          ;(this.isExport = false), (this.isLoading = false)
        })
    },
    resetDataNValidation() {
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
      this.date = null
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
  top: 0;
  position: fixed;
  z-index: 999;
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
