<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="8" class="mx-auto pb-10">
        <v-card v-if="dokter">
          <v-card-title>
            <v-icon class="mr-3">mdi-account</v-icon>
            <span>Profil</span>
          </v-card-title>
          <v-card-text class="pb-15" v-if="!isEdit">
            <v-simple-table>
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td>Nama</td>
                    <td>: {{ dokter.nama }}</td>
                  </tr>
                  <tr>
                    <td>Spesialis</td>
                    <td>: {{ dokter.spesialis }}</td>
                  </tr>
                  <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ dokter.jenis_kelamin }}</td>
                  </tr>
                  <tr>
                    <td>Tempat Tanggal Lahir</td>
                    <td>: {{ dokter.tempat_tanggal_lahir }}</td>
                  </tr>
                  <tr>
                    <td>Agama</td>
                    <td>: {{ dokter.agama ? dokter.agama : '-' }}</td>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <td>: {{ dokter.alamat ? dokter.alamat : '-' }}</td>
                  </tr>
                  <tr>
                    <td>Kontak</td>
                    <td>: {{ dokter.kontak ? dokter.kontak : '-' }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <v-divider class="my-1"></v-divider>
            <v-list dense>
              <v-subheader>Pendidikan</v-subheader>
              <p class="ml-2" v-if="!dokter.pendidikan">-</p>
              <v-list-item
                v-for="(row, index) in dokter.pendidikan"
                :key="'pendidikan-' + index"
              >
                <v-list-item-content>
                  <v-list-item-title> - {{ row }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
            <v-col cols="12 mt-2">
              <v-btn
                dark
                color="primary"
                class="mt-3 float-right"
                :loading="isLoading"
                @click="edit"
                >Ubah Profil</v-btn
              >
            </v-col>
          </v-card-text>
          <v-card-text class="pb-15" v-else>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  :rules="ruleRequired"
                  dense
                  filled
                  disabled
                  color="secondary"
                  label="Nama Lengkap"
                  v-model="form.nama"
                  prepend-inner-icon="mdi-account"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  :rules="ruleRequired"
                  dense
                  filled
                  color="secondary"
                  label="Spesialis"
                  v-model="form.spesialis"
                  prepend-inner-icon="mdi-stethoscope"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  :rules="ruleRequired"
                  dense
                  filled
                  color="secondary"
                  label="Tempat Lahir"
                  v-model="form.tempat_tanggal_lahir"
                  prepend-inner-icon="mdi-map-marker"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  :rules="ruleRequired"
                  dense
                  filled
                  color="secondary"
                  label="Tanggal Lahir"
                  v-model="form.tempat_tanggal_lahir"
                  prepend-inner-icon="mdi-calendar"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-select
                  :rules="ruleRequired"
                  color="secondary"
                  filled
                  label="Jenis Kelamin"
                  :items="['Laki-Laki', 'Perempuan']"
                  v-model="form.jenis_kelamin"
                  prepend-inner-icon="mdi-gender-male-female"
                >
                </v-select>
              </v-col>
              <v-col cols="6">
                <v-select
                  :rules="ruleRequired"
                  color="secondary"
                  filled
                  label="Agama"
                  :items="['Islam', 'Kristen', 'Budha', 'Hindu', 'Konghucu']"
                  v-model="form.agama"
                  prepend-inner-icon="mdi-home-assistant"
                >
                </v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  dense
                  filled
                  color="secondary"
                  label="Kontak"
                  v-model="form.kontak"
                  prepend-inner-icon="mdi-contacts"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  label="Alamat"
                  color="secondary"
                  filled
                  v-model="form.alamat"
                >
                </v-textarea>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-for="(row, index) in form.pendidikan"
                  :key="row"
                  :rules="ruleRequired"
                  dense
                  filled
                  color="secondary"
                  label="Pendidikan"
                  v-model="form.pendidikan[index]"
                  prepend-inner-icon="mdi-school"
                ></v-text-field>
                <v-col class="text-center">
                  <v-btn
                    class="mx-2"
                    fab
                    small
                    dark
                    color="primary"
                    title="tambah pendidikan"
                    @click="tambahPendidikan"
                  >
                    <v-icon dark> mdi-plus </v-icon>
                  </v-btn>
                </v-col>
              </v-col>
            </v-row>
            <v-col cols="12 mt-2">
              <v-btn
                dark
                color="primary"
                class="mt-3 float-right"
                :loading="isLoading"
                @click="update"
                >Simpan</v-btn
              >
            </v-col>
          </v-card-text>
        </v-card>
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
  },
  computed: {
    ...mapState('dokter', {
      urlDokter: (state) => state.url,
      dokter: (state) => state.currentDokter,
    }),
  },
  data() {
    return {
      title: 'Profil',
      isLoading: false,
      isEdit: false,
      form: {},
      ruleRequired: [(v) => !!v || 'Field ini wajib diisi!'],
    }
  },
  methods: {
    ...mapActions({ getDokterByUserId: 'dokter/getDokterByUserId' }),
    edit() {
      this.isEdit = true
      this.form = this.$_.cloneDeep(this.dokter)
    },
    tambahPendidikan() {
      this.form.pendidikan
        ? this.form.pendidikan.push('')
        : (this.form.pendidikan = [''])
    },
    update() {
      this.isLoading = true
      this.$axios
        .put(`${this.urlDokter}/${this.dokter.id}`, this.form)
        .then((response) => {
          if (response.data.status) {
            this.form = {}
            this.isEdit = false
            this.$snackbar('success', response.data.message)
          }
        })
        .catch((err) => {
          console.error(err)
          this.$snackbar('danger', err)
        })
        .then(() => {
          this.isLoading = false
          this.getDokterByUserId(this.$auth.user.id)
        })
    },
  },
}
</script>
