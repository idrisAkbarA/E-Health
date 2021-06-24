<template>
  <v-container>
    <!-- DataTables -->
    <v-data-table
      item-key="name"
      class="elevation-1"
      loading-text="Loading... Please wait"
      :loading="isLoading"
      :headers="headers"
      :items="obat"
      :search="search"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Daftar Obat</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark class="mb-2" @click="bottomSheet = true">
            Tambah Obat
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
      <v-card height="250px">
        <v-card-title>
          <span>Kelola Obat</span>
          <v-spacer></v-spacer>
          <v-btn text class="mr-2" @click="bottomSheet = false">batal</v-btn>
          <v-btn
            color="primary"
            dark
            @click="submit"
            :loading="isLoading"
            :disabled="!formCreate"
            >Simpan</v-btn
          >
        </v-card-title>
        <v-card-text>
          <v-form v-model="formCreate">
            <v-row align="center">
              <v-col cols="6">
                <v-text-field
                  filled
                  :rules="ruleRequired"
                  color="#2C3E50"
                  label="Nama Obat"
                  v-model="form.nama"
                >
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-select
                  filled
                  :rules="ruleRequired"
                  :items="['Tablet', 'Cair', 'Kapsul', 'Kaplet']"
                  label="Bentuk Obat"
                  v-model="form.bentuk"
                ></v-select>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  filled
                  :rules="ruleRequired"
                  color="#2C3E50"
                  label="Satuan"
                  hint="Contoh: Butir, Bungkus, Mg, Ml"
                  v-model="form.satuan"
                >
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  filled
                  :rules="ruleRequired"
                  color="#2C3E50"
                  type="number"
                  label="Harga"
                  prefix="Rp."
                  hint="Harga per satuan"
                  v-model="form.harga"
                >
                </v-text-field>
              </v-col>
            </v-row>
          </v-form>
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
            Apakah anda yakin ingin menghapus obat ini ?
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
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
  layout: 'apoteker',
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.$store.state.obat.data === null && this.getObat()
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Kelola Obat',
      search: '',
      isLoading: false,
      bottomSheet: false,
      dialogDelete: false,
      formCreate: false,
      form: {},
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
      headers: [
        {
          text: '#',
          align: 'start',
          value: 'no',
        },
        { text: 'Nama Obat', value: 'nama' },
        { text: 'Bentuk Obat', value: 'bentuk' },
        { text: 'Satuan', value: 'satuan' },
        { text: 'Harga', value: 'harga' },
        { text: 'Actions', value: 'actions' },
      ],
    }
  },
  computed: {
    ...mapState('obat', { urlObat: (state) => state.url }),
    obat: {
      get: function () {
        return this.$store.state.obat.data ?? []
      },
      set: function (v) {
        this.$store.commit('obat/SET_OBAT', v)
      },
    },
  },
  watch: {
    bottomSheet(val) {
      if (!val) {
        this.form = {}
      }
    },
    dialogDelete(val) {
      if (!val) {
        this.form = {}
      }
    },
  },
  methods: {
    ...mapActions({ getObat: 'obat/getObat' }),
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
        .post(this.urlObat, this.form)
        .then((response) => {
          if (response.data.status) {
            this.bottomSheet = false
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
          this.$snackbar('danger', err)
        })
        .then(() => {
          this.isLoading = false
          this.getObat()
        })
    },
    update(id) {
      const urlObat = `${this.urlObat}/${id}`
      this.isLoading = true
      this.$axios
        .put(urlObat, this.form)
        .then((response) => {
          if (response.data.status) {
            this.bottomSheet = false
            this.form = {}
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
          this.$snackbar('danger', err)
        })
        .then(() => {
          this.isLoading = false
          this.getObat()
        })
    },
    destroy() {
      const id = this.form.id
      const urlObat = `${this.urlObat}/${id}`
      this.isLoading = true
      this.$axios
        .delete(urlObat)
        .then((response) => {
          if (response.data.status) {
            this.dialogDelete = false
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
          this.$snackbar('danger', err)
        })
        .then(() => {
          this.isLoading = false
          this.getObat()
        })
    },
  },
}
</script>
