<template>
  <v-container
    fill-height
    class="pb-10"
  >
    <v-row style="height: 100%">
      <v-col cols="7">
        <v-card>
          <v-card-title>
            <v-icon class="mr-3">mdi-plus-box-multiple</v-icon>
            Tambah Antrian
          </v-card-title>
          <v-card-subtitle>Tambah antrian baru untuk pasien baru atau lama</v-card-subtitle>
          <v-divider></v-divider>
          <v-card-text>
            <v-expansion-panels
              focusable
              hover
            >
              <v-expansion-panel>
                <v-expansion-panel-header class="pink darken-4">
                  <v-list class="pink darken-4">
                    <v-list-item three-line>
                      <v-list-item-avatar>
                        <v-icon>mdi-account-plus</v-icon>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title>Pasien Baru</v-list-item-title>
                        <v-list-item-subtitle>
                          <p>
                            Daftarkan pasien yang belum pernah berobat lalu
                            tambahkan ke antrian
                          </p>
                        </v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-expansion-panel-header>
                <v-expansion-panel-content class="blue-grey darken-4">
                  <tambah-pasien></tambah-pasien>
                </v-expansion-panel-content>
              </v-expansion-panel>
              <v-expansion-panel>
                <v-expansion-panel-header class="pink darken-4">
                  <v-list class="pink darken-4">
                    <v-list-item three-line>
                      <v-list-item-avatar>
                        <v-icon>mdi-account</v-icon>
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title>Pasien Lama</v-list-item-title>
                        <v-list-item-subtitle>
                          <p>
                            Tambahkan pasien yang sudah pernah berobat kedalam
                            antrian
                          </p>
                        </v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-expansion-panel-header>
                <v-expansion-panel-content class="blue-grey darken-4">
                  <tambah-pasien-lama></tambah-pasien-lama>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="5">
        <antrian-poli
          :poli="null"
          :status="null"
          :excludePaid="1"
          :poliMenu="true"
          @antrian-selected="test"
        ></antrian-poli>
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
      title: 'Pelayanan',
      antrian: {},
      tab: 1,
    }
  },
  methods: {
    test(item) {
      console.log('current selected', item)
    },
  },
  layout: 'pelayanan',
}
</script>
