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
            <v-data-table>
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
                            <v-row>
                              <v-col>
                                <v-text-field label="Cari Nama/Nik">
                                </v-text-field>
                              </v-col>
                              <v-col>
                                <v-text-field label="Cari Nama/Nik">
                                </v-text-field>
                              </v-col>
                              <v-col>
                                <v-text-field label="Cari Nama/Nik">
                                </v-text-field>
                              </v-col>
                            </v-row>
                            <v-row>
                              <v-btn
                                color="primary"
                                class="mr-2"
                              >
                                <v-icon>mdi-magnify</v-icon> Cari
                              </v-btn>
                              <v-btn text> reset pencarian</v-btn>
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
  data() {
    return {
      title: 'History',
    }
  },
  methods: {
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