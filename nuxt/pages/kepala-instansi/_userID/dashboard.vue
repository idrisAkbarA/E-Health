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
                <span class="body 2">Dashboard Kepala Instansi</span>
              </v-card-title>
              <v-card-text>
                <h1>Selamat Datang Kepala Instansi</h1>
                <p>Selamat bekerja!</p>
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
  layout: 'kepala-instansi',
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
    this.getAntrianObat()
    this.getDokter()
  },
  data() {
    return {
      title: 'Dashboard Kepala Instansi',
    }
  },
  computed: {
    ...mapState('dokter', { dokter: (state) => state.data }),
    ...mapState('antrian-obat', { antrianObat: (state) => state.data }),
    ...mapState('antrian-poli', { antrianPoli: (state) => state.data }),
    isLoading: {
      get: function () {
        return this.$store.state.page.isLoading
      },
      set: function (v) {
        this.$store.commit('page/setLoading', v)
      },
    },
    stats() {
      return [
        {
          actionIcon: '',
          actionText: '...',
          color: 'primary',
          icon: 'mdi-calendar',
          title: 'Antrian Poli Hari ini',
          value: `${this.antrianPoli ? this.antrianPoli.length : 0}`,
        },
        {
          actionIcon: '',
          actionText: '...',
          color: 'success',
          icon: 'mdi-pill',
          title: 'Antrian Farmasi Hari ini',
          value: `${this.antrianObat ? this.antrianObat.length : 0}`,
        },
        {
          actionIcon: '',
          actionText: '...',
          color: 'info',
          icon: 'mdi-human-queue',
          title: 'Dokter Bertugas Hari ini',
          value: `${this.dokter ? this.dokter.length : 0}`,
        },
      ]
    },
  },
  methods: {
    ...mapActions({
      getDokter: 'dokter/getDokter',
      getAntrianObat: 'antrian-obat/getAntrianObat',
    }),
  },
}
</script>
