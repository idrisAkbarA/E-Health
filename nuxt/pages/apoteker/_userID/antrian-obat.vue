<template>
  <v-container fill-height>
    <v-row style="height: 100%">
      <v-col cols="7">
        <antrian-obat></antrian-obat>
      </v-col>
      <v-col cols="5">
        <v-card class="mb-10">
          <v-card-title>
            <v-icon class="mr-3">mdi-plus-box-multiple</v-icon>
            Tambah Antrian Obat
          </v-card-title>
          <v-card-subtitle
            >Tambah antrian baru untuk pembelian obat</v-card-subtitle
          >
          <v-divider></v-divider>
          <v-card-text class="pb-15">
            <v-text-field
              outlined
              color="secondary"
              label="Nama Pembeli"
              v-model="form.nama"
            ></v-text-field>
            <v-row v-for="(resep, index) in form.resep_obat" :key="index">
              <v-col cols="8">
                <v-select
                  outlined
                  :items="obat"
                  item-text="nama"
                  item-value="id"
                  label="Nama Obat"
                  v-model="resep.obat"
                ></v-select>
              </v-col>
              <v-col cols="4">
                <v-text-field
                  outlined
                  type="number"
                  min="0"
                  color="secondary"
                  label="Jumlah"
                  suffix="Satuan"
                  v-model="resep.jumlah"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-textarea
              outlined
              label="Catatan"
              hint="catatan dosis dan penggunaan obat"
              v-model="form.catatan"
            ></v-textarea>
            <v-col class="text-center">
              <v-btn
                class="mx-2"
                fab
                small
                dark
                color="primary"
                @click="tambahObat"
              >
                <v-icon dark> mdi-plus </v-icon>
              </v-btn>
            </v-col>
            <v-btn
              dark
              color="primary"
              class="mt-3 float-right"
              :loading="isLoading"
              @click="store"
              >Simpan</v-btn
            >
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  layout: 'apoteker',
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Antrian Obat',
      isLoading: false,
      obat: [],
      form: { resep_obat: [{}] },
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  methods: {
    tambahObat() {
      this.form.resep_obat.push({})
    },
    store() {
      //
    },
  },
}
</script>
