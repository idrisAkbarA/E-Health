<template>
  <v-container>
    <v-row>
      <v-col cols="6">
        <v-card>
          <v-card-title>Selamat Datang Administrator</v-card-title>
          <v-card-subtitle
            >Sistem Informasi Rawat Jalan Puskesmas Bangkinang
            Kota</v-card-subtitle
          >
          <v-card-text>Selamat Bekerja !</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card>
          <v-card-title>Kamis</v-card-title>
          <v-card-subtitle>24 Juni 2021</v-card-subtitle>
          <v-card-text>Hari ini</v-card-text>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card>
          <v-card-title>12 Dokter</v-card-title>
          <v-card-subtitle>Sedang Bertugas</v-card-subtitle>
          <v-card-text>Hari ini</v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
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
      title: 'Dashboard Admin',
    }
  },
  layout: 'admin',
}
</script>
