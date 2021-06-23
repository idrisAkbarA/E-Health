<template>
  <v-container fill-height class="pb-10">
    <div class="ribbon"></div>
    <v-row style="height: 100%">
      <v-col cols="4">
        <antrian-poli
          header="Antrian Pembayaran"
          subHeader="Daftar antrian pembayaran. Klik untuk melihat rincian"
          :poli="null"
          :status="1"
          @antrian-selected="setDetail"
        ></antrian-poli>
      </v-col>
      <v-col cols="8">
        <v-container>
          <v-row>
            <v-card width="100%">
              <v-card-title>
                <v-icon class="mr-4">mdi-cash-register</v-icon> Rincian
                Transaksi
              </v-card-title>
              <v-card-subtitle>
                Berikut rincian biaya pengobatan di Puskesmas Bangkinang Kota
              </v-card-subtitle>
              <transition name="fade-transition" mode="out-in">
                <v-card-text
                  :key="0"
                  v-if="currentSelected && isLoading == false"
                >
                  <v-card color="primary">
                    <v-card-text class="pa-10">
                      <v-row>
                        <span>Invoice untuk</span>
                        <v-spacer></v-spacer>
                        <span
                          >Tanggal
                          {{ $moment().format('Do MMMM YYYY', 'id') }}</span
                        >
                      </v-row>
                      <v-row class="mt-6">
                        <h2>{{ currentSelected.pasien.nama }}</h2>
                      </v-row>
                      <v-row>
                        <span>{{ currentSelected.pasien.alamat }}</span>
                      </v-row>
                      <v-row class="mt-7">
                        <div
                          style="
                            width: 100%;
                            background-color: white;
                            height: 1px;
                          "
                        ></div>
                      </v-row>
                      <v-row class="mt-5">
                        <span>Diperiksa oleh </span>&nbsp;
                        <span class="font-weight-bold">{{
                          detailDokter.nama
                        }}</span>
                      </v-row>
                      <v-row>
                        <span>Poli</span>&nbsp;<span class="font-weight-bold">{{
                          currentSelected.poli.nama
                        }}</span>
                      </v-row>
                    </v-card-text>
                  </v-card>
                  <div class="mt-2">Rincian layanan/obat</div>
                  <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">Item</th>
                          <th class="text-left">Jumlah</th>
                          <th class="text-left">Satuan</th>
                          <th class="text-left">Harga</th>
                          <th class="text-left">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Diagnosa</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>
                            Rp{{ $numberify(currentSelected.total_biaya) }}
                          </td>
                        </tr>
                        <template v-if="detailObat">
                          <tr
                            v-for="(item, index) in detailObat.resep_obat"
                            :key="index"
                          >
                            <td>{{ item.obat.nama }}</td>
                            <td>{{ item.jumlah }}</td>
                            <td>{{ item.obat.satuan }}</td>
                            <td>Rp{{ $numberify(item.obat.harga) }}</td>
                            <td>
                              Rp{{ $numberify(item.obat.harga * item.jumlah) }}
                            </td>
                          </tr>
                        </template>

                        <v-divider inset></v-divider>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>
                            <span class="font-weight-bold">Total Biaya:</span>
                            <br />
                            <span v-if="detailObat">
                              Rp{{
                                $numberify(
                                  parseInt(currentSelected.total_biaya) +
                                    parseInt(detailObat.total_harga)
                                )
                              }}
                            </span>
                            <span v-else>
                              Rp{{ $numberify(currentSelected.total_biaya) }}
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                </v-card-text>
                <v-card-text :key="1" v-else-if="isLoading">
                  <v-card width="100%">
                    <v-skeleton-loader
                      width="100%"
                      type="article"
                    ></v-skeleton-loader>
                  </v-card>
                  <v-card width="100%">
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
                </v-card-text>
                <v-card-text :key="2" v-else>
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
                          Klik antrian terlebih dahulu untuk melihat rincian
                        </h2>
                      </v-col>
                    </v-row>
                    <v-row justify="center" no-gutters> </v-row>
                  </v-container>
                </v-card-text>
              </transition>
            </v-card>
          </v-row>
          <v-row>
            <transition name="fade-transition" mode="out-in">
              <v-card v-if="currentSelected && isLoading == false" width="100%">
                <!-- <v-card-title>
                <v-icon class="mr-4">mdi-account-cash</v-icon> Aksi
              </v-card-title> -->
                <v-card-actions>
                  <v-btn block color="primary">Terima Pembayaran</v-btn>
                </v-card-actions>
              </v-card>
            </transition>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AntrianPoli from '../../../components/antrian-poli.vue'
import antrianObat from '../../apoteker/_userID/antrian-obat.vue'
export default {
  components: { antrianObat, AntrianPoli },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Kasir',
      currentSelected: null,
      detailObat: null,
      detailDokter: null,
      isLoading: false,
    }
  },
  layout: 'kasir',
  methods: {
    async setDetail(item) {
      this.isLoading = true
      this.currentSelected = item
      this.detailObat = item.resep_obat ? item.resep_obat : null
      var url = '/api/dokter/' + this.currentSelected.dokter_id
      await this.$axios.get(url).then((response) => {
        console.log(response.data)
        this.detailDokter = response.data.data
      })
      this.isLoading = false
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
