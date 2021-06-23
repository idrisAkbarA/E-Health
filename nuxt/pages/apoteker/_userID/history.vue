<template>
  <v-container>
    <v-row>
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
            <v-chip outlined class="ma-2" :color="getStatusColor(item.status)">
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
                <v-expansion-panels focusable hover>
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
                              label="Cari Nama / NIK"
                              v-model="filter.nama"
                            >
                            </v-text-field>
                          </v-col>
                          <v-col>
                            <v-text-field label="Cari Nama/Nik"> </v-text-field>
                          </v-col>
                          <v-col>
                            <v-text-field label="Cari Nama/Nik"> </v-text-field>
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
                          <v-btn text @click="filter = {}">
                            reset pencarian</v-btn
                          >
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
      antrianObat: [],
      filter: {},
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
