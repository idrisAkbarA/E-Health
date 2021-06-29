<template>
  <v-container>
    <v-row class="notprint">
      <v-col cols="12">
        <v-data-table
          item-key="name"
          class="elevation-1"
          loading-text="Loading... Please wait"
          :loading="isLoading"
          :headers="headers"
          :items="antrianObat"
        >
          <template v-slot:[`item.no`]="props">
            {{ props.index + 1 }}
          </template>
          <template v-slot:[`item.nama_pasien`]="{ item }">
            {{ item.rekam_medis ? item.rekam_medis.nama_pasien : item.nama }}
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
          <template v-slot:[`item.created_at`]="{ item }">
            {{ $moment(item.created_at).format('dddd, Do MMMM YYYY', 'id') }}
          </template>
          <template v-slot:top>
            <v-card flat>
              <v-card-title>
                <v-icon class="mr-4">mdi-history</v-icon> Riwayat Data Antrian
                Obat
              </v-card-title>
              <v-card-subtitle>Lihat riwayat data antrian obat</v-card-subtitle>
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
                            @click="getAntrianObat"
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
              <h3>Laporan Apoteker</h3>
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
              <!-- <th class="text-left">
                Pembayaran
              </th> -->
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
                <td>{{data.rekam_medis ? data.rekam_medis.nama_pasien : data.nama}}</td>
                <td>
                  <v-chip
                    outlined
                    class="ma-2"
                    :color="getStatusColor(data.status)"
                  >
                    {{ getStatusText(data.status) }}
                  </v-chip>
                </td>
                <!-- <td>
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
                </td> -->
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
  layout: 'apoteker',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.getAntrianObat()
  },

  data() {
    return {
      title: 'History',
      isLoading: false,
      modal: false,
      antrianObat: [],
      filter: {},
      statuses: [
        { status: 'null', text: 'Sedang Dibuat' },
        { status: 0, text: 'Obat Selesai' },
        { status: 1, text: 'Obat Diambil' },
      ],
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Pasien', value: 'nama_pasien' },
        { text: 'Status', value: 'status' },
        { text: 'Tanggal', value: 'created_at' },
      ],
    }
  },
  computed: {
    ...mapState('antrian-obat', { urlAntrianObat: (state) => state.url }),
  },
  methods: {
    async print() {
      // this.filter['isExport'] = true
      this.printData = this.antrianObat
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
    getAntrianObat() {
      this.isLoading = true
      this.$axios
        .get(this.urlAntrianObat, { params: this.filter })
        .then((response) => {
          if (response.data.status) {
            this.antrianObat = response.data.data
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
        default:
          return ''
      }
    },
    getStatusText(val) {
      switch (val) {
        case null:
          return 'Sedang Dibuat'
        case 0:
          return 'Obat Selesai'
        case 1:
          return 'Obat Diambil'
        default:
          return '-'
      }
    },
  },
}
</script>
<style>
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
