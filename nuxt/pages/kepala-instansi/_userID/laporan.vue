<template>
  <v-container>
    <v-card>
      <v-card-title>
        Pusat Laporan
      </v-card-title>
      <v-card-subtitle>
        Daftar Laporan Aplikasi Puskesmas Bangkinang Kota
      </v-card-subtitle>
      <v-card-text>
        <v-tabs
          v-model="tab"
          align-with-title
          color="secondary"
        >
          <v-tabs-slider color="yellow"></v-tabs-slider>

          <v-tab>
            Pelayanan

          </v-tab>
          <v-tab>
            Kasir

          </v-tab>
          <v-tab>
            Apoteker

          </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item class="bg-pattern">
            <pelayanan-history :noRibbon="true"></pelayanan-history>
          </v-tab-item>
          <v-tab-item class="bg-pattern">
            <kasir-history :noRibbon="true"></kasir-history>
          </v-tab-item>
          <v-tab-item>
            <apoteker-history></apoteker-history>
          </v-tab-item>
        </v-tabs-items>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  layout: 'kepala-instansi',
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
      tab: 1,
      title: 'Laporan',
    }
  },
  methods: {},
}
</script>
<style>
.bg-pattern {
  background: url('/pattern.svg') repeat;
  background-size: 400px;
}
</style>
