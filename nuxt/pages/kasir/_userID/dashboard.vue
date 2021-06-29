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
        <v-col
          v-for="({ actionIcon, actionText, ...attrs }, i) in stats"
          :key="i"
          cols="12"
          md="6"
          lg="4"
        >
          <material-stat-card v-bind="attrs">
            <template #actions>
              <v-icon class="mr-2" small v-text="actionIcon" />
              <div class="text-truncate">
                {{ actionText }}
              </div>
            </template>
          </material-stat-card>
        </v-col>
      </v-row>
      <v-card class="mt-10"> </v-card>
    </div>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import MaterialStatCard from '../../../components/MaterialStatsCard.vue'

export default {
  layout: 'kasir',
  head() {
    return {
      title: this.title,
    }
  },
  components: {
    MaterialStatCard,
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
    stats() {
      return [
        {
          actionIcon: '',
          actionText: '...',
          color: 'primary',
          icon: 'mdi-calendar',
          title: this.$moment(new Date()).format('dddd, Do MMMM YYYY', 'id'),
          value: 'Hari ini',
        },
        {
          actionIcon: '',
          actionText: '...',
          color: 'success',
          icon: 'mdi-cash-check',
          title: 'Sudah Bayar',
          value: `${
            this.rekamMedis !== null
              ? this.filterStatusBayar(this.rekamMedis, true).length +
                this.filterStatusBayar(this.antrianObat, true).length
              : 0
          }`,
        },
        {
          actionIcon: '',
          actionText: '...',
          color: 'info',
          icon: 'mdi-cash-remove',
          title: 'Belum Bayar',
          value: `${
            this.rekamMedis !== null
              ? this.filterStatusBayar(this.rekamMedis, false).length +
                this.filterStatusBayar(this.antrianObat, false).length
              : 0
          }`,
        },
      ]
    },
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
