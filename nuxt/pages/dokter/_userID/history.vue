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
          :items="rekamMedis"
        >
          <template v-slot:[`item.no`]="props">
            {{ props.index + 1 }}
          </template>
          <template v-slot:[`item.status`]="{ item }">
            <v-chip outlined class="ma-2" :color="getStatusColor(item.status)">
              {{ getStatusText(item.status) }}
            </v-chip>
          </template>
          <template v-slot:[`item.created_at`]="{ item }">
            {{ $moment(item.created_at).format('Do MMMM YYYY', 'id') }}
          </template>
          <template v-slot:top>
            <v-card flat>
              <v-card-title>
                <v-icon class="mr-4">mdi-history</v-icon> Riwayat Data Pasien
              </v-card-title>
              <v-card-subtitle>Lihat riwayat data pasien</v-card-subtitle>
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
                              filled
                              color="secondary"
                              label="Nama / NIK"
                              prepend-inner-icon="mdi-account"
                              v-model="filter.nama"
                            >
                            </v-text-field>
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
                            @click="getRekamMedis"
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
  layout: 'dokter',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.getRekamMedis()
  },
  data() {
    return {
      title: 'History',
      isLoading: false,
      modal: false,
      rekamMedis: [],
      filter: {},
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Pasien', value: 'nama_pasien' },
        { text: 'Diagnosa', value: 'diagnosa' },
        { text: 'Tanggal', value: 'created_at' },
      ],
    }
  },
  computed: {
    ...mapState('dokter', { urlDokter: (state) => state.url }),
  },
  methods: {
    getRekamMedis() {
      this.isLoading = true
      this.$axios
        .get(`${this.urlDokter}/rekam-medis`, { params: this.filter })
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
    getStatusColor(val) {
      switch (val) {
        case null:
          return 'warning'
        case 0:
          return 'secondary'
        case 1:
          return 'success'
        case 2:
          return 'white'
        default:
          return ''
      }
    },
    getStatusText(val) {
      switch (val) {
        case null:
          return 'Sedang Mengantri'
        case 0:
          return 'Tidak Datang'
        case 1:
          return 'Selesai'
        case 2:
          return 'Skipped'
        default:
          return '-'
      }
    },
  },
}
</script>
