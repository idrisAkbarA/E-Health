<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">mdi-medical-bag</v-icon>
      <span>Antrian Obat</span>
    </v-card-title>
    <v-card-subtitle
      ><strong>Kamis, 24 Juni 2021</strong> | Antrian hari ini
    </v-card-subtitle>
    <v-card-actions>
      <v-btn
        color="primary"
        block
        depressed
        class="mb-2"
        @click="createAntrian"
      >
        Tambah Antrian
      </v-btn>
    </v-card-actions>
    <v-divider></v-divider>

    <v-card-text>
      <v-text-field
        @click:clear="search = ''"
        clearable
        v-model="search"
        color="secondary"
        label="Pencarian"
        prepend-inner-icon="mdi-magnify"
        placeholder="Ketik untuk mulai mencari..."
      ></v-text-field>
      <v-list v-if="antrian.length > 0">
        <v-list-item-group v-model="selectedItem" color="secondary">
          <transition-group name="scale-transition">
            <v-list-item
              @click="emitData(row)"
              :three-line="index == 0 && (search == '' || search == null)"
              v-for="(row, index) in antrian.slice().reverse()"
              :key="row.id"
            >
              <v-list-item-avatar> {{ index + 1 }} </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>{{
                  row.rekam_medis ? row.rekam_medis.nama_pasien : row.nama
                }}</v-list-item-title>
                <v-list-item-subtitle>{{ 'Poli ' }}</v-list-item-subtitle>
                <v-list-item-subtitle>
                  <v-chip
                    label
                    x-small
                    class="black--text"
                    :color="row.is_bayar ? 'success' : 'secondary'"
                    >{{ row.is_bayar ? 'Sudah Bayar' : 'Belum Bayar' }}</v-chip
                  >
                  <v-chip
                    label
                    :color="
                      row.status !== null
                        ? row.status
                          ? 'success'
                          : 'info'
                        : 'warning'
                    "
                    class="black--text"
                    x-small
                    >{{
                      row.status !== null
                        ? row.status
                          ? 'Sudah Diambil'
                          : 'Selesai Dibuat'
                        : 'Sedang Dibuat'
                    }}</v-chip
                  >
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </transition-group>
        </v-list-item-group>
      </v-list>
      <span v-else class="text-center">Tidak ada antrian</span>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapGetters, mapState } from 'vuex'
export default {
  props: {
    // status: null,
  },
  mounted() {
    // this.getFinalData()
  },
  computed: {
    ...mapState('antrian-obat', { antrianState: (state) => state.data }),
    antrian: {
      get: function () {
        return this.$store.state['antrian-obat'].data
      },
      set: function (v) {
        this.$store.commit('antrian-obat/SET_DATA', v)
      },
    },
  },
  watch: {
    antrianState() {
      this.emitData({})
    },
    search() {
      this.searchAntrian()
    },
  },
  data() {
    return {
      search: '',
      selectedItem: undefined,
      originalAntrian: [],
      antrianPrioritas: [],
      antrianReguler: [],
    }
  },
  methods: {
    ...mapGetters({ getAntrianObat: 'antrian-obat/getAntrian' }),
    emitData(data) {
      this.$emit('antrian-selected', data)
    },
    createAntrian() {
      this.$emit('button-clicked')
    },
    filterByStatus(data) {
      var filtered = data.filter((item) => {
        return item.status === this.status
      })
      return filtered
    },
    getFinalData() {
      var data = this.getAntrianObat()
      console.log('antrian', data)
      this.originalAntrian = this.filterByStatus(data)
    },
    // mergeAntrian(antrian) {
    //   var antrianPrioritasTemp = []
    //   var antrianRegulerTemp = []
    //   // var antrianSkipped = []

    //   antrian.forEach((element) => {
    //     if (element.prioritas_utama) {
    //       antrianPrioritasTemp.push(element)
    //       return
    //     }
    //     return antrianRegulerTemp.push(element)
    //   })

    //   this.antrianPrioritas = antrianPrioritasTemp
    //   this.antrianReguler = antrianRegulerTemp
    //   return antrianRegulerTemp.concat(antrianPrioritasTemp)
    // },
    searchAntrian() {
      if (this.search === '' || this.search === null) {
        this.getFinalData()
        return
      }
      let eachIndex = (e) => {
        // console.log('Looping each index element ', e)
        return e.pasien.nama.toLowerCase().includes(this.search.toLowerCase())
      }
      var item = this.originalAntrian.filter((item) => eachIndex(item))
      this.originalAntrian = this.filterByStatus(item)
    },
    getDetailPoli() {
      var url = this.$store.state.poli.url
      this.$axios.get(url + '/' + this.poli).then((response) => {
        console.log('get detail poli', response)
        this.poliDetail = response.data.data
        this.getFinalData()
      })
    },
  },
}
</script>
