<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">{{ icon ? icon : 'mdi-human-queue' }}</v-icon>
      <span v-if="header">{{ header }}</span>
      <span v-else-if="poliDetail">{{
        'Antrian Poli ' + poliDetail.nama
      }}</span>
      <span v-else>Antrian</span>
    </v-card-title>
    <v-card-subtitle>{{
      subHeader ? subHeader : 'Daftar pasien yang sedang dalam antrian'
    }}</v-card-subtitle>
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
      <!-- @keyup="searchAntrian()" -->
      <v-list v-if="originalAntrian.length > 0">
        <v-list-item-group
          v-model="selectedItem"
          color="secondary"
        >
          <transition-group name="scale-transition">
            <v-list-item
              :three-line="(index == 0 && (search == '' || search == null))||prioritas"
              v-for="(antrian, index) in originalAntrian.slice().reverse()"
              :key="antrian.id"
            >
              <v-list-item-avatar> {{ index + 1 }} </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>{{ antrian.pasien.nama }}</v-list-item-title>
                <v-list-item-subtitle>{{
                  'Poli ' + antrian.poli.nama
                }}</v-list-item-subtitle>
                <v-list-item-subtitle v-if="index == 0 && (search == '' || search == null)">
                  <v-chip
                    v-if="antrianSekarang == true"
                    label
                    color="secondary"
                    class="black--text"
                    x-small
                  >{{antrianSekarangLabel?antrianSekarangLabel:"Antrian Sekarang"}}</v-chip>
                  <v-chip
                    v-if="prioritas == true"
                    label
                    :color="antrian.prioritas_utama?'yellow':'pink lighten-3'"
                    class="black--text"
                    x-small
                  >{{antrian.prioritas_utama?"Pasien Prioritas":"Pasien Reguler"}}</v-chip>
                </v-list-item-subtitle>
                <v-list-item-subtitle v-if="prioritas && !(index == 0 && (search == '' || search == null)) ">
                  <v-chip
                    v-if="prioritas == true"
                    label
                    :color="antrian.prioritas_utama?'yellow':'pink lighten-3'"
                    class="black--text"
                    x-small
                  >{{antrian.prioritas_utama?"Pasien Prioritas":"Pasien Reguler"}}</v-chip>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </transition-group>
        </v-list-item-group>
      </v-list>
      <span
        v-else
        class="text-center"
      >Tidak ada antrian</span>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapGetters, mapState } from 'vuex'
export default {
  props: {
    icon: null,
    header: null,
    subHeader: null,
    poli: null,
    status: null,
    antrianSekarang: {
      default: true,
    },
    prioritas: {
      default: true,
    },
    antrianSekarangLabel: null,
  },
  mounted() {
    if (this.poli !== null) {
      console.log('poli ada')
      this.getDetailPoli()
    } else {
      this.getFinalData()
    }
  },
  computed: {
    ...mapState('antrian-poli', { AllAntrianData: (state) => state.data }),
  },
  watch: {
    AllAntrianData() {
      console.log('something change')
      this.getFinalData()
    },
    search() {
      this.searchAntrian()
    },
    poli() {
      this.getFinalData()
    },
    status() {
      this.getFinalData()
    },
    selectedItem(val) {
      var antrian = this.originalAntrian.slice().reverse()
      this.$emit('antrian-selected', val == undefined ? {} : antrian[val])
    },
  },
  data() {
    return {
      search: '',
      selectedItem: undefined,
      poliDetail: null,
      originalAntrian: [],
      antrianPrioritas: [],
      antrianReguler: [],
      // antrianSkipped: [],
    }
  },
  methods: {
    ...mapGetters({ getAntrianPoliByID: 'antrian-poli/getAntrianPoliByID' }),
    filterByStatus(data) {
      var filtered = data.filter((item) => {
        return item.status === this.status
      })
      return filtered
    },
    getFinalData() {
      var getData = this.getAntrianPoliByID(this.poli)
      if (this.prioritas) {
        console.log('prioritas')
        var antrian = this.filterByStatus(getData(this.poli))
        this.originalAntrian = this.mergeAntrian(antrian)
        return
      }
      this.originalAntrian = this.filterByStatus(getData(this.poli))
      console.log('antrian', this.originalAntrian)
    },
    mergeAntrian(antrian) {
      var antrianPrioritasTemp = []
      var antrianRegulerTemp = []
      // var antrianSkipped = []

      antrian.forEach((element) => {
        if (element.prioritas_utama) {
          antrianPrioritasTemp.push(element)
          return
        }
        return antrianRegulerTemp.push(element)
      })

      this.antrianPrioritas = antrianPrioritasTemp
      this.antrianReguler = antrianRegulerTemp
      return antrianRegulerTemp.concat(antrianPrioritasTemp)
    },
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
      })
    },
  },
}
</script>
