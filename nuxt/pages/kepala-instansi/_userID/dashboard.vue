<template>
  <v-container>
    <div v-if="false">
      <v-row>
        <v-col cols="12">
          <v-card width="100%">
            <v-skeleton-loader width="100%" type="article"></v-skeleton-loader>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-skeleton-loader
              class="mx-auto"
              max-width="300"
              type="list-item-two-line"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-skeleton-loader
              class="mx-auto"
              max-width="300"
              type="list-item-two-line"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-skeleton-loader
              class="mx-auto"
              max-width="300"
              type="list-item-two-line"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <v-card width="100%">
            <v-skeleton-loader
              class="mx-auto"
              width="100%"
              type="table"
            ></v-skeleton-loader>
          </v-card>
        </v-col>
      </v-row>
    </div>
    <div v-if="true">
      <v-row justify="space-between">
        <v-col cols="12">
          <v-card dark :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              cover
            >
              <v-card-title>
                <span class="body 2">Dashboard Kepala Instansi</span>
              </v-card-title>
              <v-card-text>
                <h1>Selamat Datang Kepala Instansi</h1>
                <p>Selamat bekerja!</p>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
        <v-col>
          <v-card dark :height="100 * 1.2" :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              :src="'https://picsum.photos/200/100?random=3'"
            >
              <v-card-title>
                <span class="body 2">Total Antrian Poli Hari ini</span>
              </v-card-title>
              <v-card-text>
                <h1>20 Antrian</h1>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
        <v-col>
          <v-card dark :height="100 * 1.2" :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              :src="'https://picsum.photos/200/100?random=2'"
            >
              <v-card-title>
                <span class="body 2">Total Antrian Farmasi Hari ini</span>
              </v-card-title>
              <v-card-text>
                <h1>5 Antrian</h1>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
        <v-col>
          <v-card dark :height="100 * 1.2" :width="'100%'">
            <v-img
              gradient="to top right, rgba(58, 231, 87, 0.33), rgba(25,32,72,.7)"
              :src="'https://picsum.photos/200/100?random=1'"
            >
              <v-card-title>
                <span class="body 2">Dokter Bertugas Hari ini</span>
              </v-card-title>
              <v-card-text>
                <h1>15 Dokter</h1>
              </v-card-text>
            </v-img>
          </v-card>
        </v-col>
      </v-row>
      <v-card class="mt-10"> </v-card>
    </div>
  </v-container>
</template>

<script>
export default {
  layout: 'kepala-instansi',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  data() {
    return {
      title: 'Dashboard Kepala Instansi',
    }
  },
}
</script>
