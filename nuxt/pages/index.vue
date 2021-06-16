<template>
  <v-container fill-height class="pa-0" fluid>
    <div class="wrapper">
      <div class="left">
        <div>Selamat Datang di aplikasi</div>
        <div>
          <h1>E-Health Bangkinang</h1>
        </div>
        <div>Selamat bertugas!</div>
      </div>
      <div class="right px-10">
        <login></login>
      </div>
    </div>
  </v-container>
</template>

<script>
import Login from '~/components/Login.vue'
import VuetifyLogo from '~/components/VuetifyLogo.vue'

export default {
  components: {
    Login,
    VuetifyLogo,
  },
  mounted() {
    this.$echo.channel('antrian-poli').listen('AntrianPoli', (e) => {
      console.log(e)
    })
  },
}
</script>
<style>
.left {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-content: center;
  align-items: center;

  height: 100%;
  background-image: linear-gradient(
    90deg,
    rgba(184, 194, 173, 1) 0%,
    rgba(247, 24, 113, 1) 100%
  );
}
.right {
  height: 100%;
  box-shadow: 3px -2px 147px 23px rgba(0, 0, 0, 0.56);
  -webkit-box-shadow: 3px -2px 147px 23px rgba(0, 0, 0, 0.56);
  -moz-box-shadow: 3px -2px 147px 23px rgba(0, 0, 0, 0.56);
}
.wrapper {
  display: grid;
  grid-template-columns: 2fr 1fr;
  height: 100%;
  width: 100%;
}
</style>
