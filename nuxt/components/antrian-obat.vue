<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">mdi-medical-bag</v-icon>
      Antrian Obat
    </v-card-title>
    <v-card-subtitle
      ><strong>Kamis, 24 Juni 2021</strong> | Antrian pembelian obat hari
      ini</v-card-subtitle
    >
    <v-divider></v-divider>
    <v-data-table
      item-key="name"
      class="elevation-1"
      show-expand
      loading-text="Loading... Please wait"
      :headers="headers"
      :loading="isLoading"
      :items="antrian"
      :single-expand="true"
      :search="search"
      :expanded.sync="expanded"
    >
      <template v-slot:top>
        <!-- <v-toolbar flat>
          <v-toolbar-title>Daftar Obat</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark class="mb-2"> Tambah Obat </v-btn>
        </v-toolbar> -->
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          class="mx-4"
          single-line
          hide-details
        ></v-text-field>
      </template>
      <template v-slot:[`item.no`]="props">
        {{ props.index + 1 }}
      </template>
      <template v-slot:[`item.nama`]="{ item }">
        {{ item.nama ? item.nama : item.rekam_medis.nama_pasien }}
      </template>
      <template v-slot:[`item.is_bayar`]="{ item }">
        <v-icon
          :color="item.is_bayar ? 'success' : 'red'"
          :title="item.is_bayar ? 'Sudah Bayar' : 'Belum bayar'"
          >{{ item.is_bayar ? 'mdi-cash-check' : 'mdi-cash-remove' }}</v-icon
        >
      </template>
      <template v-slot:[`item.status`]="{ item }">
        <v-chip outlined class="ma-2" :color="getStatusColor(item.status)">
          {{
            item.status !== null
              ? item.status
                ? 'Obat sudah diambil'
                : 'Obat sudah selesai'
              : 'Obat sedang dibuat'
          }}
        </v-chip>
      </template>
      <!-- <template v-slot:[`item.actions`]="{ item }">
        <v-btn icon x-small class="mr-2" title="Edit" @click="edit(item)">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn
          icon
          x-small
          class="mr-2"
          title="Hapus"
          @click="
            dialogDelete = true
            form = item
          "
        >
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </template> -->
      <template v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length">More info about {{ item.name }}</td>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  data() {
    return {
      isLoading: false,
      selectedRow: 0,
      search: '',
      expanded: [],
      antrian: [],
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Pembeli', value: 'nama' },
        { text: 'Pembayaran', value: 'is_bayar' },
        { text: 'Status', value: 'status' },
        // { text: 'Actions', value: 'actions' },
      ],
    }
  },
  mounted() {
    this.getAntrianObat()
  },
  computed: {
    ...mapState('antrian-obat', { urlAntrianObat: (state) => state.url }),
  },
  methods: {
    getAntrianObat() {
      this.$axios
        .get(`${this.urlAntrianObat}/antrian`)
        .then((response) => {
          if (response.data.status) {
            this.antrian = response.data.data
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
    info(item) {
      console.log('info', item)
    },
    getStatusColor(status) {
      return status !== null ? (status ? 'secondary' : 'success') : 'info'
    },
  },
}
</script>
