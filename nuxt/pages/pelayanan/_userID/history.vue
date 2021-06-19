<template>
  <v-container>
    <div class="ribbon"></div>
    <div style="z-index:2">
      <v-card
        class="mt-5"
        flat
        style="z-index:2"
        color="transparent"
      >
        <h1>
          Pusat Riwayat Antrian
        </h1>
        <h4>Lihat dan monitor detail riwayat antrian</h4>
        <h4>Klik antrian untuk melihat detail</h4>
        <v-row class="mt-10">
          <v-col>
            <antrian-poli
              :poli="null"
              :status="null"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
          <v-col>
            <antrian-poli
              icon="mdi-check"
              header="Antrian Selesai"
              subHeader="Daftar antrian yang sudah selesai"
              :poli="null"
              :status="null"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
          <v-col>
            <antrian-poli
              :poli="null"
              :status="null"
              @antrian-selected="test"
            ></antrian-poli>
          </v-col>
        </v-row>
      </v-card>
    </div>
  </v-container>
</template>

<script>
import AntrianPoli from '../../../components/antrian-poli.vue'
export default {
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  layout: 'pelayanan',
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
  methods: {
    test(item) {
      console.log('current selected', item)
    },
  },
}
</script>
<style>
.ribbon {
  top: 0;
  left: 0;
  position: fixed;
  z-index: 0;
  background: rgb(0, 36, 15);
  background-image: linear-gradient(
    90deg,
    rgb(170, 185, 153) 0%,
    rgba(247, 24, 113, 1) 100%
  );
  background-size: cover;
  background-position: center;
  /* background-size: contain; */
  /* background: url("/images/bg.jpg"); */
  /* background: #33691e; */
  width: 100%;
  height: 400px;
}
</style>