<template>
  <v-container>
    <!-- DataTables -->
    <v-data-table
      item-key="name"
      class="elevation-1"
      loading-text="Loading... Please wait"
      :loading="isLoading"
      :headers="headers"
      :items="users"
      :search="search"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Daftar Petugas</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-tabs v-model="tab">
            <v-tab>Petugas</v-tab>
            <v-tab>Dokter</v-tab>
          </v-tabs>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark class="mb-2" @click="bottomSheet = true">
            Tambah Petugas
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
      <template v-slot:[`item.role`]="{ item }">
        <v-chip outlined class="ma-2" :color="getRoleColor(item.role)">
          {{ item.role }}
        </v-chip>
      </template>
      <template v-slot:[`item.poli`]="{ item }">
        <v-edit-dialog
          :return-value.sync="item.dokter.poli"
          @save="changePoli(item)"
          @close="changePoli(item)"
        >
          {{ item.dokter.poli }}
          <template v-slot:input>
            <v-select
              :items="poli"
              label="Poli"
              item-text="nama"
              item-value="id"
              v-model="item.dokter.poli_id"
            ></v-select>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:[`item.status`]="{ item }">
        <v-switch
          inset
          :color="item.dokter.is_aktif ? 'success' : ''"
          :label="item.dokter.is_aktif ? 'Aktif' : 'Non-Aktif'"
          @change="swithStatus(item)"
          v-model="item.dokter.is_aktif"
        ></v-switch>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-btn
          icon
          x-small
          class="mr-2"
          title="Ubah Password"
          @click="edit(item)"
        >
          <v-icon>mdi-form-textbox-password</v-icon>
        </v-btn>
        <v-btn
          icon
          x-small
          class="mr-2"
          title="Hapus"
          :disabled="$auth.user.id == item.id"
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
      <v-card height="280px">
        <v-card-title>
          <span>Kelola Petugas</span>
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
            <v-row align="center" v-if="!form.id">
              <v-col cols="6">
                <v-text-field
                  filled
                  color="#2C3E50"
                  label="Nama"
                  :rules="ruleRequired"
                  v-model="form.name"
                >
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-select
                  filled
                  :items="roles"
                  :rules="ruleRequired"
                  label="Role"
                  item-text="nama"
                  item-value="nama"
                  v-model="form.role"
                ></v-select>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  filled
                  :rules="ruleRequired"
                  color="#2C3E50"
                  label="Username"
                  v-model="form.username"
                >
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  filled
                  :rules="ruleRequired"
                  color="#2C3E50"
                  label="Password"
                  type="password"
                  hint="Password akan digunakan untuk login"
                  v-model="form.password"
                >
                </v-text-field>
              </v-col>
              <v-col cols="4" v-if="form.dokter">
                <v-text-field
                  filled
                  :rules="ruleRequired"
                  color="#2C3E50"
                  label="Tempat Tanggal Lahir"
                  v-model="form.dokter.tempat_tanggal_lahir"
                >
                </v-text-field>
              </v-col>
              <v-col cols="4" v-if="form.dokter">
                <v-select
                  filled
                  :rules="ruleRequired"
                  :items="['Laki-Laki', 'Perempuan']"
                  label="Jenis Kelamin"
                  v-model="form.dokter.jenis_kelamin"
                ></v-select>
              </v-col>
              <v-col cols="4" v-if="form.dokter">
                <v-select
                  filled
                  :rules="ruleRequired"
                  :items="poli"
                  label="Poli"
                  item-text="nama"
                  item-value="id"
                  v-model="form.dokter.poli_id"
                ></v-select>
              </v-col>
            </v-row>
            <v-row v-else>
              <v-col cols="6">
                <v-text-field
                  filled
                  type="password"
                  color="#2C3E50"
                  label="Password Baru"
                  v-model="form.password"
                >
                </v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  filled
                  type="password"
                  color="#2C3E50"
                  label="Konfirmasi Password"
                  hint="Ulangi password baru"
                  v-model="form.password2"
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
            Apakah anda yakin ingin menghapus petugas ini ?
          </p>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn text @click="dialogDelete = false"> Batal </v-btn>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark @click="destroy" :loading="isLoading">
            Ya
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
export default {
  layout: 'admin',
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    this.$store.state.poli.data === null && this.getPoli()
    this.$store.state.user.data === null && this.getUsers()
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Kelola Petugas',
      search: '',
      tab: null,
      isLoading: false,
      bottomSheet: false,
      dialogDelete: false,
      formCreate: false,
      form: {},
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
      roles: [
        { nama: 'Admin', color: 'info' },
        { nama: 'Pelayanan', color: 'purple' },
        { nama: 'Apoteker', color: 'warning' },
        { nama: 'Kasir', color: 'success' },
        { nama: 'Dokter', color: 'white' },
        { nama: 'Kepala Instansi', color: 'primary' },
      ],
    }
  },
  computed: {
    ...mapState('user', { urlUser: (state) => state.url }),
    ...mapState('poli', {
      urlPoli: (state) => state.url,
      poli: (state) => state.data,
    }),
    users: {
      get: function () {
        var users = this.$_.cloneDeep(this.$store.state.user.data) ?? []
        return users.filter((item) => {
          return this.tab ? item.role == 'Dokter' : item.role != 'Dokter'
        })
      },
      set: function (v) {
        this.$store.commit('user/SET_USERS', v)
      },
    },
    headers() {
      if (this.tab) {
        var headers = [
          {
            text: '#',
            align: 'start',
            value: 'no',
          },
          { text: 'Nama', value: 'name' },
          { text: 'Poli', value: 'poli' },
          { text: 'Username', value: 'username' },
          { text: 'Status', value: 'status' },
          { text: 'Actions', value: 'actions' },
        ]
      } else {
        var headers = [
          {
            text: '#',
            align: 'start',
            value: 'no',
          },
          { text: 'Nama', value: 'name' },
          { text: 'Username', value: 'username' },
          { text: 'Role', value: 'role' },
          { text: 'Actions', value: 'actions' },
        ]
      }
      return headers
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
    'form.role'(val) {
      if (val == 'Dokter') {
        this.form.dokter = {}
      } else {
        delete this.form.dokter
      }
    },
  },
  methods: {
    ...mapActions({ getUsers: 'user/getUsers', getPoli: 'poli/getPoli' }),
    submit() {
      const form = this.form
      if (!form.id) {
        this.store()
        return
      }
      this.update(form.id)
    },
    swithStatus(item) {
      this.form.dokter = { is_aktif: item.dokter.is_aktif }
      this.update(item.id)
    },
    changePoli(item) {
      this.form.dokter = { poli_id: item.dokter.poli_id }
      this.update(item.id)
    },
    edit(form) {
      this.form = this.$_.clone(form)
      this.bottomSheet = true
    },
    store() {
      this.isLoading = true
      this.$axios
        .post(this.urlUser, this.form)
        .then((response) => {
          if (response.data.status) {
            this.bottomSheet = false
            this.$snackbar('success', response.data.message)
            response.data.data.role == 'Dokter'
              ? (this.tab = 1)
              : (this.tab = 0)
          }
        })
        .catch((err) => {
          console.error(err)
          this.$snackbar('danger', err)
        })
        .then(() => {
          this.isLoading = false
          this.getUsers()
        })
    },
    update(id) {
      const form = this.form
      if (form.password != form.password2) {
        this.$snackbar('danger', 'Konfirmasi password harus sama')
        return
      }
      const urlUser = `${this.urlUser}/${id}`
      this.isLoading = true
      this.$axios
        .put(urlUser, form)
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
          this.getUsers()
        })
    },
    destroy() {
      const id = this.form.id
      const urlUser = `${this.urlUser}/${id}`
      this.isLoading = true
      this.$axios
        .delete(urlUser)
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
          this.getUsers()
        })
    },
    getRoleColor(role) {
      var color = ''
      this.roles.forEach((element) => {
        if (element.nama == role) {
          color = element.color
        }
      })
      return color
    },
  },
}
</script>
