<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="7">
        <v-card>
          <v-card-title>
            <v-icon class="mr-3">mdi-stethoscope</v-icon>
            Diagnosa
          </v-card-title>
          <v-card-subtitle>Catat hasil diagnosa pemeriksaan</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text>
            <v-row>
              <v-col cols="4"> Nama Pasien </v-col>
              <v-col cols="8"> : Charles Augustus Milverton </v-col>
              <v-col cols="4"> Jenis Kelamin </v-col>
              <v-col cols="8"> : Laki-Laki </v-col>
              <v-col cols="4"> Tempat Tanggal Lahir </v-col>
              <v-col cols="8"> : London, 19 Juni 1988 </v-col>
              <v-col cols="4"> Alamat </v-col>
              <v-col cols="8"> : Kings St. 201 </v-col>
              <v-col cols="4"> Kontak </v-col>
              <v-col cols="8"> : +01 1289-1232 </v-col>
            </v-row>
            <v-divider class="my-4"></v-divider>
            <v-expansion-panels focusable hover>
              <v-expansion-panel>
                <v-expansion-panel-header class="pink darken-4">
                  Diagnosa
                </v-expansion-panel-header>
                <v-expansion-panel-content class="blue-grey darken-4">
                  <p class="text-secondary mt-3">Hasil diagnosa pasien</p>
                  <v-form>
                    <v-row>
                      <v-col cols="12">
                        <v-textarea
                          outlined
                          color="secondary"
                          label="Diagnosa"
                          v-model="form.diagnosa"
                        ></v-textarea>
                        <v-textarea
                          outlined
                          color="secondary"
                          label="Pengobatan"
                          v-model="form.pengobatan"
                        ></v-textarea>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-expansion-panel-content>
              </v-expansion-panel>
              <v-expansion-panel>
                <v-expansion-panel-header class="pink darken-4">
                  Resep Obat
                </v-expansion-panel-header>
                <v-expansion-panel-content class="blue-grey darken-4">
                  <p class="text-secondary mt-3">
                    Resep obat akan langsung dikirim ke bagian Farmasi.
                  </p>
                  <v-switch
                    inset
                    small
                    :color="is_resep ? 'success' : ''"
                    :label="is_resep ? 'Aktif' : 'Non-Aktif'"
                    v-model="is_resep"
                  ></v-switch>
                  <v-row>
                    <v-col cols="8">
                      <v-select
                        outlined
                        :items="items"
                        label="Nama Obat"
                      ></v-select>
                    </v-col>
                    <v-col cols="4">
                      <v-text-field
                        outlined
                        type="number"
                        color="secondary"
                        label="Jumlah"
                        suffix=""
                      ></v-text-field>
                    </v-col>
                    <v-col class="text-center">
                      <v-btn class="mx-2" fab small dark color="primary">
                        <v-icon dark> mdi-plus </v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="5">
        <v-card>
          <v-card-title>
            <v-icon class="mr-3">mdi-human-queue</v-icon>
            Antrian
          </v-card-title>
          <v-card-subtitle
            >Daftar pasien yang sedang dalam antrian</v-card-subtitle
          >
          <v-divider></v-divider>
          <v-card-text>
            <v-list>
              <v-list-item>
                <v-list-item-avatar> 1 </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title
                    >Charles Augustus Milverton</v-list-item-title
                  >
                  <v-list-item-subtitle>Psychiatry</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  layout: 'dokter',
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Diagnosa',
      is_resep: false,
      antrian: {},
      form: {},
      tab: 1,
    }
  },
  method: {
    //
  },
}
</script>
