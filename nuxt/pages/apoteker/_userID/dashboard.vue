<template>
  <v-container>
    <div v-if="isLoading">
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
    <div v-else>
      <v-row justify="space-between">
        <v-col cols="12">
          <v-card dark :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              cover
            >
              <v-card-title>
                <span class="body 2">Dashboard Apoteker</span>
              </v-card-title>
              <v-card-text>
                <h1>Selamat Datang {{ $auth.user.name }}!</h1>
                <p>
                  Pilih menu antrian obat untuk melihat antrian hari ini <br />
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
              :src="'https://picsum.photos/200/100?random=3'"
            >
              <v-card-title>
                <span class="body 2">Total Obat</span>
              </v-card-title>
              <v-card-text>
                <h1>{{ obat ? obat.length : 0 }} Jenis</h1>
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
                <span class="body 2">Antrian Hari ini</span>
              </v-card-title>
              <v-card-text>
                <h1>{{ antrian ? antrian.length : 0 }} Orang</h1>
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
  layout: 'apoteker',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.$store.state.obat.data === null && this.getObat()
    this.$store.state['antrian-obat'].data === null && this.getAntrianObat()
  },

  data() {
    return {
      title: 'Dashboard Apoteker',
    }
  },
  computed: {
    ...mapState('obat', { obat: (state) => state.data }),
    ...mapState('antrian-obat', { antrian: (state) => state.data }),
    isLoading: {
      get: function () {
        return this.$store.state.page.isLoading
      },
      set: function (v) {
        this.$store.commit('page/setLoading', v)
      },
    },
  },
  methods: {
    ...mapActions({
      getObat: 'obat/getObat',
      getAntrianObat: 'antrian-obat/getAntrianObat',
    }),
  },
}
</script>
