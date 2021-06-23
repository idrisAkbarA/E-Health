<template>
  <v-container>
    <div class="ribbon"></div>
    <div style="z-index:2">
      <v-card
        class="mt-5"
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
              :height="600"
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
              :height="600"
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
            <v-data-table
              :headers="headers"
              :items="dataHistory"
            >
              <template v-slot:top>
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
                                    v-model="nama.nama"
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
                                    v-model="poli"
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
                                </v-col>
                              </v-row>
                              <v-row>
                                <v-btn
                                  color="primary"
                                  class="mr-2"
                                >
                                  <v-icon>mdi-magnify</v-icon> Cari
                                </v-btn>
                                <v-btn
                                  text
                                  @click="resetDataNValidation()"
                                > reset pencarian</v-btn>
                              </v-row>
                            </v-form>
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
import { mapGetters, mapState } from 'vuex'
import AntrianPoli from '../../../components/antrian-poli.vue'
export default {
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  layout: 'kasir',
  head() {
    return {
      title: this.title,
    }
  },
  computed: {
    ...mapState('poli', { listPoli: (state) => state.data }),
    listPoliWithAll() {
      var temp = JSON.parse(JSON.stringify(this.listPoli))
      var all = {
        id: null,
        nama: 'Semua Poli',
      }
      temp.push(all)
      return temp
    },
  },
  data() {
    return {
      nama: { nama: null },
      poli: { poli: null },
      tanggal: null,
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
    test(item) {
      console.log('current selected', item)
    },
    resetDataNValidation() {
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
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