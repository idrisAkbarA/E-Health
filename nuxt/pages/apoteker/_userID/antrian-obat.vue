<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="5">
        <antrian-obat
          @antrian-selected="showDetail"
          @button-clicked="createAntrian"
        ></antrian-obat>
      </v-col>
      <v-col cols="7" v-if="formCreate">
        <v-card class="mb-10">
          <v-card-title>
            <v-icon class="mr-3">mdi-plus-box-multiple</v-icon>
            Tambah Antrian Obat
          </v-card-title>
          <v-card-subtitle
            >Tambah antrian baru untuk pembelian obat</v-card-subtitle
          >
          <v-divider></v-divider>
          <v-card-text class="pb-15">
            <v-text-field
              outlined
              color="secondary"
              label="Nama Pembeli"
              v-model="form.nama"
            ></v-text-field>
            <v-row v-for="(resep, index) in form.resep_obat" :key="index">
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
                  min="0"
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
              v-model="form.catatan"
            ></v-textarea>
            <v-col class="text-center">
              <v-btn
                class="mx-2"
                fab
                small
                dark
                color="primary"
                @click="tambahObat"
              >
                <v-icon dark> mdi-plus </v-icon>
              </v-btn>
            </v-col>
            <v-btn
              dark
              color="primary"
              class="mt-3 float-right"
              :loading="isLoading"
              @click="store"
              >Simpan</v-btn
            >
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="7" v-else>
        <v-card class="mb-10">
          <v-card-title>
            <v-icon class="mr-3">mdi-pill</v-icon>
            Detail Order
          </v-card-title>
          <v-card-subtitle>Rincian pemesanan obat</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text class="pb-10" v-if="!$_.isEmpty(selectedItem)">
            <v-card color="primary">
              <v-card-text class="pa-10">
                <v-row>
                  <span>Resep Obat</span>
                  <v-spacer></v-spacer>
                  <span
                    >Tanggal {{ $moment().format('Do MMMM YYYY', 'id') }}</span
                  >
                </v-row>
                <v-row class="mt-6">
                  <h2>
                    {{
                      selectedItem.rekam_medis
                        ? selectedItem.rekam_medis.nama_pasien
                        : selectedItem.nama
                    }}
                  </h2>
                </v-row>
                <v-row class="mt-7">
                  <div
                    style="width: 100%; background-color: white; height: 1px"
                  ></div>
                </v-row>
                <v-row class="mt-5">
                  <span>Status pembayaran : </span>&nbsp;
                  <span class="font-weight-bold">{{
                    selectedItem.is_bayar ? 'Sudah Bayar' : 'Belum Bayar'
                  }}</span>
                </v-row>
                <v-row>
                  <span>Status Obat : </span>&nbsp;<span
                    class="font-weight-bold"
                    >{{
                      selectedItem.status !== null
                        ? selectedItem.status
                          ? 'Sudah Diambil'
                          : 'Selesai Dibuat'
                        : 'Sedang Dibuat'
                    }}</span
                  >
                </v-row>
              </v-card-text>
            </v-card>
            <div class="mt-2">Rincian resep obat</div>
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
                  <template>
                    <tr
                      v-for="(item, index) in selectedItem.resep_obat"
                      :key="index"
                    >
                      <td>{{ item.obat.nama }}</td>
                      <td>{{ item.jumlah }}</td>
                      <td>{{ item.obat.satuan }}</td>
                      <td>Rp{{ $numberify(item.obat.harga) }}</td>
                      <td>Rp{{ $numberify(item.obat.harga * item.jumlah) }}</td>
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
                      <span>
                        Rp{{ $numberify(parseInt(selectedItem.total_harga)) }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <v-col cols="12">
              <v-textarea
                :value="selectedItem.catatan ? selectedItem.catatan : '-'"
                label="Catatan penggunaan dan dosis obat"
                outlined
                disabled
              ></v-textarea>
            </v-col>
            <v-card-actions>
              <v-btn
                block
                color="primary"
                :loading="isLoading"
                v-if="!selectedItem.status"
                @click="update(selectedItem.status != null)"
                >{{
                  selectedItem.status == null ? 'Obat Selesai' : 'Obat Diambil'
                }}</v-btn
              >
            </v-card-actions>
          </v-card-text>
          <v-card-text v-else>
            <p class="text-center">Pilih pesanan terlebih daluhu...</p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
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
  data() {
    return {
      title: 'Antrian Obat',
      isLoading: false,
      formCreate: false,
      selectedItem: {},
      obat: [],
      form: { resep_obat: [{}] },
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  computed: {
    ...mapState('antrian-obat', { urlAntrianObat: (state) => state.url }),
  },
  methods: {
    tambahObat() {
      this.form.resep_obat.push({})
    },
    createAntrian() {
      this.formCreate = true
      console.log(this.formCreate)
    },
    showDetail(data) {
      this.formCreate = false
      this.selectedItem = this.$_.clone(data)
    },
    update(status) {
      var form = this.selectedItem
      this.isLoading = true
      this.$axios
        .put(`${this.urlAntrianObat}/${form.id}`, { status: status })
        .then((response) => {
          if (response.data.status) {
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
        })
        .then(() => {
          this.isLoading = false
        })
    },
    store() {
      this.isLoading = true
      this.$axios
        .post(this.urlAntrianObat, this.form)
        .then((response) => {
          if (response.data.status) {
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
        })
        .then(() => {
          this.isLoading = false
        })
    },
  },
}
</script>
