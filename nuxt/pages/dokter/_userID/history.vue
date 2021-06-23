<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table>
          <template v-slot:top>
            <v-card flat>
              <v-card-title>
                <v-icon class="mr-4">mdi-history</v-icon> Riwayat Data Pasien
              </v-card-title>
              <v-card-subtitle>Lihat riwayat data pasien</v-card-subtitle>
              <v-card-text>
                <v-expansion-panels focusable hover>
                  <v-expansion-panel>
                    <v-expansion-panel-header class="pink darken-4">
                      <v-row align="center">
                        <v-icon class="mr-4">mdi-filter</v-icon>
                        <span>Pencarian</span>
                      </v-row>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content class="blue-grey darken-4">
                      <v-container>
                        <v-row>
                          <v-col>
                            <v-text-field label="Cari Nama/Nik"> </v-text-field>
                          </v-col>
                          <v-col>
                            <v-text-field label="Cari Nama/Nik"> </v-text-field>
                          </v-col>
                          <v-col>
                            <v-text-field label="Cari Nama/Nik"> </v-text-field>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-btn color="primary" class="mr-2">
                            <v-icon>mdi-magnify</v-icon> Cari
                          </v-btn>
                          <v-btn text> reset pencarian</v-btn>
                        </v-row>
                      </v-container>
                    </v-expansion-panel-content>
                  </v-expansion-panel>
                </v-expansion-panels>
              </v-card-text>
            </v-card>
          </template>
        </v-data-table>
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
      title: 'History',
    }
  },
  layout: 'dokter',
}
</script>
