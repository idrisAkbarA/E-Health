<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">mdi-medical-bag</v-icon>
      Antrian Obat
    </v-card-title>
    <v-card-subtitle>Antrian pembelian obat</v-card-subtitle>
    <v-divider></v-divider>
    <v-data-table
      item-key="name"
      class="elevation-1"
      loading-text="Loading... Please wait"
      :loading="isLoading"
      :headers="headers"
      :items="antrian"
      :search="search"
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
      <template v-slot:[`item.actions`]="{ item }">
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
      search: '',
      antrian: [],
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Pembeli', value: 'nama' },
        { text: 'Status', value: 'status' },
        { text: 'Pembayaran', value: 'is_bayar' },
        { text: 'Actions', value: 'actions' },
      ],
    }
  },
  mounted() {
    //
  },
  computed: {
    ...mapState('antrian-obat', { urlAntrianObat: (state) => state.url }),
  },
  methods: {
    getAntrianObat() {
      this.$axios
        .get(urlAntrianObat)
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
  },
}
</script>
