<template>
  <v-container>
    <!-- DataTables -->
    <v-data-table
      item-key="name"
      class="elevation-1"
      loading-text="Loading... Please wait"
      :loading="isLoading"
      :headers="headers"
      :items="poli"
      :search="search"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Daftar Poli</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark class="mb-2" @click="bottomSheet = true">
            Tambah Poli
          </v-btn>
        </v-toolbar>
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

    <!-- Bottom Sheet -->
    <v-bottom-sheet v-model="bottomSheet" scrollable inset>
      <v-card height="200px">
        <v-card-title>
          <span>Kelola Poli</span>
          <v-spacer></v-spacer>
          <v-btn text class="mr-2" @click="bottomSheet = false">batal</v-btn>
          <v-btn color="primary" dark @click="submit" :loading="isLoading"
            >Simpan</v-btn
          >
        </v-card-title>
        <v-card-text>
          <v-row align="center">
            <v-col cols="6">
              <v-text-field
                color="#2C3E50"
                label="Nama Poli"
                hint="*Contoh : Anak, Jiwa, Jantung"
                v-model="form.nama"
              >
              </v-text-field>
            </v-col>
            <v-col cols="6">
              <v-text-field
                color="#2C3E50"
                label="Keterangan"
                v-model="form.keterangan"
              >
              </v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-bottom-sheet>

    <!-- Dialog Delete -->
    <v-dialog v-model="dialogDelete" width="500">
      <v-card>
        <v-card-title class="headline">
          <v-icon>mdi-trash</v-icon>
          <v-divider class="mx-4" inset vertical></v-divider>
        </v-card-title>

        <v-card-text>
          <p class="text-center">
            Apakah anda yakin ingin menghapus poli ini ?
          </p>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn text @click="dialogDelete = false"> Batal </v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark @click="destroy"> Ya </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Snackbar -->
    <v-snackbar
      v-model="snackbar.show"
      timeout="2000"
      :color="snackbar.color ? snackbar.color : 'success'"
      outlined
    >
      {{ snackbar.message }}

      <template v-slot:action="{ attrs }">
        <v-btn
          :color="snackbar.color ? snackbar.color : 'success'"
          text
          v-bind="attrs"
          @click="snackbar.show = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script>
import { mapState } from 'vuex'

export default {
  layout: 'admin',
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.getPoli()
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Kelola Poly',
      search: '',
      isLoading: false,
      bottomSheet: false,
      dialogDelete: false,
      poli: [],
      form: {},
      snackbar: { show: false },
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Poli', value: 'nama' },
        { text: 'Keterangan', value: 'keterangan' },
        { text: 'Actions', value: 'actions' },
      ],
    }
  },
  computed: {
    urlPoli() {
      return this.$store.state.poli.url
    },
  },
  watch: {
    bottomSheet(val) {
      if (!val) {
        this.form = {}
      }
    },
  },
  methods: {
    getPoli() {
      this.isLoading = true
      this.$axios
        .get(this.urlPoli)
        .then((response) => {
          if (response.data.status) {
            this.poli = response.data.data
          }
        })
        .catch((err) => {
          console.error(err)
          this.snackbar = {
            show: true,
            message: err,
            color: 'danger',
          }
        })
        .then((this.isLoading = false))
    },
    submit() {
      const form = this.form
      if (!form.id) {
        this.store()
        return
      }
      this.update(form.id)
    },
    edit(form) {
      this.form = this.$_.clone(form)
      this.bottomSheet = true
    },
    store() {
      this.isLoading = true
      this.$axios
        .post(this.urlPoli, this.form)
        .then((response) => {
          if (response.data.status) {
            this.bottomSheet = false
            this.snackbar = {
              show: true,
              message: response.data.message,
            }
          }
        })
        .catch((err) => {
          console.error(err)
          this.snackbar = {
            show: true,
            message: err,
            color: 'danger',
          }
        })
        .then(() => {
          this.isLoading = false
          this.gePoli()
        })
    },
    update(id) {
      const urlPoli = `${this.urlPoli}/${id}`
      this.isLoading = true
      this.$axios
        .put(urlPoli, this.form)
        .then((response) => {
          if (response.data.status) {
            this.bottomSheet = false
            this.form = {}
            this.snackbar = {
              show: true,
              message: response.data.message,
            }
            this.getPoli()
          }
        })
        .catch((err) => {
          console.error(err)
          this.snackbar = {
            show: true,
            message: err,
            color: 'danger',
          }
        })
        .then((this.isLoading = false))
    },
    destroy() {
      const id = this.form.id
      const urlPoli = `${this.urlPoli}/${id}`
      this.isLoading = true
      this.$axios
        .delete(urlPoli)
        .then((response) => {
          if (response.data.status) {
            this.dialogDelete = false
            this.getPoli()
            this.snackbar = {
              show: true,
              message: response.data.message,
            }
          }
        })
        .catch((err) => {
          console.error(err)
          this.snackbar = {
            show: true,
            message: err,
            color: 'danger',
          }
        })
        .then((this.isLoading = false))
    },
  },
}
</script>
