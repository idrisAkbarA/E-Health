<template>
  <v-container fill-height class="pa-0" fluid>
    <div class="wrapper">
      <div class="left">
        <div>Selamat Datang di Sistem Informasi Rawat Jalan</div>
        <div>
          <h1>Puskesmas Bangkinang Kota</h1>
        </div>
        <div>Selamat bertugas!</div>
      </div>
      <div class="right px-10">
        <login class="padding"></login>
      </div>
    </div>
  </v-container>
</template>

<script>
import Login from '~/components/Login.vue'
import VuetifyLogo from '~/components/VuetifyLogo.vue'

export default {
  middleware: ['auth-redirect'],
  components: {
    Login,
    VuetifyLogo,
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
      rgba(184, 194, 173, 0.6) 0%,
      rgba(247, 24, 113, 0.9) 100%
    ),
    url('/puskesmas-bangkinang.jpeg');
  background-size: cover;
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
@media screen and (max-width: 1000px) {
  .padding {
    padding-left: 160px !important;
    padding-right: 160px !important;
  }
  .wrapper {
    grid-template-columns: 1fr;
    grid-template-rows: 2fr 3fr;
  }
}
@media screen and (max-width: 600px) {
  .padding {
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
  .wrapper {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 3fr;
  }
}
</style>
