<template>
  <v-card>
    <v-card-title>
      <v-icon class="mr-3">mdi-human-queue</v-icon>
      Antrian
    </v-card-title>
    <v-card-subtitle>Daftar pasien yang sedang dalam antrian</v-card-subtitle>
    <v-divider></v-divider>

    <v-card-text>
      <v-text-field
        color="secondary"
        label="Pencarian"
        prepend-inner-icon="mdi-magnify"
        placeholder="Ketik untuk mulai mencari..."
      ></v-text-field>
      <v-list>
        <v-list-item
          v-for="(antrian,index) in originalAntrian"
          :key="index"
        >
          <v-list-item-avatar> {{index+1}} </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>{{antrian.pasien.nama}}</v-list-item-title>
            <v-list-item-subtitle>Psychiatry</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
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
  mounted() {},
  computed: {
    ...mapState('antrian-poli', { AllAntrianData: (state) => state.data }),
  },
  watch: {
    AllAntrianData() {
      console.log('something change')
      var getData = this.getAntrianPoliByID(this.poli)
      this.originalAntrian = getData(this.poli)
    },
  },
  data() {
    return {
      originalAntrian: null,
    }
  },
  methods: {
    ...mapGetters({ getAntrianPoliByID: 'antrian-poli/getAntrianPoliByID' }),
  },
}
</script>