<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">mdi-human-queue</v-icon>
      <span v-if="poliDetail">{{"Antrian Poli "+poliDetail.nama}}</span>
      <span v-else>Antrian</span>
    </v-card-title>
    <v-card-subtitle>Daftar pasien yang sedang dalam antrian</v-card-subtitle>
    <v-divider></v-divider>

    <v-card-text>
      <v-text-field
        @click:clear="search=''"
        clearable
        v-model="search"
        color="secondary"
        label="Pencarian"
        prepend-inner-icon="mdi-magnify"
        placeholder="Ketik untuk mulai mencari..."
      ></v-text-field>
      <!-- @keyup="searchAntrian()" -->
      <v-list>
        <v-list-item-group
          v-model="selectedItem"
          color="secondary"
        >
          <transition-group name="scale-transition">
            <v-list-item
              :three-line="index==0 && (search == ''||search == null)"
              v-for="(antrian,index) in originalAntrian"
              :key="antrian.id"
            >
              <v-list-item-avatar> {{index+1}} </v-list-item-avatar>
              <v-list-item-content @click="emitDetail(antrian)">
                <v-list-item-title>{{antrian.pasien.nama}}</v-list-item-title>
                <v-list-item-subtitle>{{"Poli "+antrian.poli.nama}}</v-list-item-subtitle>
                <v-list-item-subtitle v-if="index==0 && (search == ''||search == null)">
                  <v-chip
                    label
                    color="secondary"
                    class="black--text"
                    x-small
                  >Antrian sekarang</v-chip>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </transition-group>
        </v-list-item-group>
      </v-list>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapGetters, mapState } from 'vuex'
export default {
  props: {
    poli: null,
  },
  created() {
    // console.log(this.poli)
    if (this.poli !== null) {
      console.log('poli ada')
      this.getDetailPoli()
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
  },
  data() {
    return {
      search: '',
      selectedItem: 0,
      poliDetail: null,
      originalAntrian: null,
    }
  },
  methods: {
    ...mapGetters({ getAntrianPoliByID: 'antrian-poli/getAntrianPoliByID' }),
    emitDetail(item) {
      this.$emit('antrian-selected', item)
    },
    getFinalData() {
      var getData = this.getAntrianPoliByID(this.poli)
      this.originalAntrian = getData(this.poli)
      console.log('antrian', this.originalAntrian)
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
      this.originalAntrian = item
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