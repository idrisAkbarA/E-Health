<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">mdi-human-queue</v-icon>
      Antrian
    </v-card-title>
    <v-card-subtitle>Daftar pasien yang sedang dalam antrian</v-card-subtitle>
    <v-divider></v-divider>
    <v-card-text>
      <v-list>
        <v-list-item>
          <v-list-item-avatar> 1 </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>Charles Augustus Milverton</v-list-item-title>
            <v-list-item-subtitle>Psychiatry</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  mounted() {
    this.$echo.channel('antrian-poli').listen('AntrianPoli', (e) => {
      console.log(e)
    })
  },
}
</script>