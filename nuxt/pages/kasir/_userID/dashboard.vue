<template>
  <v-container>
    <div v-if="false">
      <v-row>
        <v-col cols="12">
          <v-card width="100%">
            <v-skeleton-loader width="100%" type="article"></v-skeleton-loader>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-skeleton-loader
              class="mx-auto"
              max-width="300"
              type="list-item-two-line"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-skeleton-loader
              class="mx-auto"
              max-width="300"
              type="list-item-two-line"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-skeleton-loader
              class="mx-auto"
              max-width="300"
              type="list-item-two-line"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <v-card width="100%">
            <v-skeleton-loader
              class="mx-auto"
              width="100%"
              type="table"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
      </v-row>
    </div>
    <div v-if="true">
      <v-row justify="space-between">
        <v-col cols="12">
          <v-card dark :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              cover
            >
              <v-card-title>
                <span class="body 2">Dashboard Kasir</span>
              </v-card-title>
              <v-card-text>
                <h1>Selamat Datang {{ $auth.user.name }}!</h1>
                <p>
                  Pilih menu kasir untuk memulai <br />
                  Selamat bekerja!
                </p>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
        <v-col>
          <v-card dark :height="100 * 1.2" :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              :src="'https://picsum.photos/200/100?random=1'"
            >
              <v-card-title>
                <span class="body 2">Hari ini</span>
              </v-card-title>
              <v-card-text>
                <h1>
                  {{ $moment(new Date()).format('dddd, Do MMMM YYYY', 'id') }}
                </h1>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
        <v-col>
          <v-card dark :height="100 * 1.2" :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              :src="'https://picsum.photos/200/100?random=2'"
            >
              <v-card-title>
                <span class="body 2">Total Sudah Bayar</span>
              </v-card-title>
              <v-card-text>
                <h1>
                  {{
                    rekamMedis !== null
                      ? filterStatusBayar(rekamMedis, true).length +
                        filterStatusBayar(antrianObat, true).length
                      : 0
                  }}
                </h1>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
        <v-col>
          <v-card dark :height="100 * 1.2" :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              :src="'https://picsum.photos/200/100?random=1'"
            >
              <v-card-title>
                <span class="body 2">Total Belum Bayar</span>
              </v-card-title>
              <v-card-text>
                <h1>
                  {{
                    rekamMedis !== null
                      ? filterStatusBayar(rekamMedis, false).length +
                        filterStatusBayar(antrianObat, false).length
                      : 0
                  }}
                </h1>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
      </v-row>
      <!-- Tabel -->
      <v-card class="mt-10"> </v-card>
    </div>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  layout: 'kasir',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.antrianObat === null && this.getAntrianObat()
    this.getRekamMedis()
  },
  data() {
    return {
      title: 'Dashboard Kasir',
      rekamMedis: null,
    }
  },
  computed: {
    ...mapState('rekam-medis', { urlRekamMedis: (state) => state.url }),
    ...mapState('antrian-obat', { antrianObat: (state) => state.data }),
  },
  methods: {
    ...mapActions({ getAntrianObat: 'antrian-obat/getAntrianObat' }),
    getRekamMedis() {
      var params = {
        date: [this.$moment().format('YYYY-MM-Do', 'id')],
      }
      this.isLoading = true
      this.$axios
        .get(`${this.urlRekamMedis}/history`, { params: params })
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
    filterStatusBayar(item, val) {
      return item.filter((elem) => {
        return elem.is_bayar == val
      })
    },
  },
}
</script>
