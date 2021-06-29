<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="6" class="mx-auto pb-10">
        <v-card v-if="dokter">
          <v-card-title>
            <v-icon class="mr-3">mdi-account</v-icon>
            <span>Profil</span>
          </v-card-title>
          <v-card-text v-if="!isEdit">
            <v-row>
              <v-col cols="4">
                <v-badge color="secondary" bottom offset-x="30" offset-y="30">
                  <template v-slot:badge>
                    <v-icon
                      color="primary"
                      title="Ubah Foto"
                      @click="$refs.photo.$refs.input.click()"
                      >mdi-camera-plus-outline</v-icon
                    >
                  </template>
                  <v-avatar size="150">
                    <v-img
                      lazy-src="https://picsum.photos/id/11/10/6"
                      src="https://picsum.photos/id/11/500/300"
                      class="rounded-circle"
                    ></v-img>
                  </v-avatar>
                </v-badge>
                <v-file-input
                  class="d-none"
                  ref="photo"
                  v-model="photo"
                  @change="changePhoto"
                ></v-file-input>
              </v-col>
              <v-col cols="8">
                <v-list-item three-line>
                  <v-list-item-content>
                    <v-list-item-title class="text-h5 mt-4 mb-1">
                      {{ dokter.nama }}
                    </v-list-item-title>
                    <v-list-item-subtitle
                      >Poli {{ dokter.poli }}</v-list-item-subtitle
                    >
                  </v-list-item-content>
                  <v-btn
                    fab
                    dark
                    small
                    color="primary"
                    class="mt-3 float-right"
                    title="Ubah Profil"
                    :loading="isLoading"
                    @click="edit"
                    ><v-icon dark> mdi-pencil </v-icon></v-btn
                  >
                </v-list-item>
                <v-chip
                  class="mt-4 ml-4"
                  :color="dokter.is_aktif ? 'success' : 'red'"
                  outlined
                  >{{ dokter.is_aktif ? 'Aktif' : 'Non-Aktif' }}</v-chip
                >
              </v-col>
            </v-row>
            <v-divider class="my-2"></v-divider>
            <v-row class="px-5">
              <v-col cols="12" class="mt-5">
                <v-list>
                  <v-list-item two-line>
                    <v-list-item-content>
                      <v-list-item-subtitle
                        >Tempat Tanggal Lahir</v-list-item-subtitle
                      >
                      <v-list-item-title>{{
                        dokter.tempat_tanggal_lahir
                      }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item two-line>
                    <v-list-item-content>
                      <v-list-item-subtitle>Jenis Kelamin</v-list-item-subtitle>
                      <v-list-item-title>{{
                        dokter.jenis_kelamin
                      }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item two-line>
                    <v-list-item-content>
                      <v-list-item-subtitle>Agama</v-list-item-subtitle>
                      <v-list-item-title>{{
                        dokter.agama ? dokter.agama : '-'
                      }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item two-line>
                    <v-list-item-content>
                      <v-list-item-subtitle>Spesialis</v-list-item-subtitle>
                      <v-list-item-title>{{
                        dokter.spesialis ? dokter.spesialis : '-'
                      }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item two-line>
                    <v-list-item-content>
                      <v-list-item-subtitle>Alamat</v-list-item-subtitle>
                      <v-list-item-title>{{
                        dokter.alamat ? dokter.alamat : '-'
                      }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item two-line>
                    <v-list-item-content>
                      <v-list-item-subtitle>Kontak</v-list-item-subtitle>
                      <v-list-item-title>{{
                        dokter.kontak ? dokter.kontak : '-'
                      }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <v-list subheader>
                  <v-subheader>Pendidikan</v-subheader>
                  <v-list-item
                    v-for="(row, index) in dokter.pendidikan"
                    :key="'pendidikan-' + index"
                  >
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-icon>mdi-school</v-icon> {{ row }}</v-list-item-title
                      >
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-col>
            </v-row>
            <v-col cols="12 mt-2"> </v-col>
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
      photo: null,
      formHeader: null,
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
    changePhoto() {
      var formData = new FormData()
      var file = this.photo
      formData.append('file', file)
      formData.append('filse', 'file')
      console.log(formData)
      this.form = formData
      this.formHeader = {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      }
      this.update()
    },
    update() {
      this.isLoading = true
      this.$axios
        .put(`${this.urlDokter}/${this.dokter.id}`, this.form, null)
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
