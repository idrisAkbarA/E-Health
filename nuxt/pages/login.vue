<template>
  <v-container fill-height>
    <v-card
      style="z-index:2"
      class="mx-auto"
      flat
      width="400px"
    >
      <v-card-text>
        <login></login>
      </v-card-text>
    </v-card>
    <div class="ribbon"></div>
  </v-container>

</template>

<script>
import { mapMutations } from 'vuex'
export default {
  created() {
    var pathArray = window.location.pathname.split('/')
    this.loginUrl = pathArray[pathArray.length - 1]
  },
  methods: {
    ...mapMutations(['setUser']),
    async login() {
      this.isLoading = true
      var isCSRFOkay = await this.getCSRF()
      if (isCSRFOkay) {
        this.loginProcess()
      } else {
        this.isLoading = false
        console.log("Couldn't get CSRF Cookie")
        this.error = 'Maaf terjadi kesalahan, coba lagi dalam beberapa saat'
      }
    },
    async loginProcess() {
      // set api request url based on window url
      var data = {
        email: this.email,
        password: this.password,
      }
      await this.$auth.loginWith('local', { data })
    },
    getUser() {
      this.$axios.get('/api/user').then((response) => {
        console.log(response)
      })
    },
    getCSRF() {
      // return true if retrieved, false if didnt
      return this.$axios
        .get('/sanctum/csrf-cookie')
        .then((response) => {
          return true
        })
        .catch((err) => {
          return false
        })
    },
  },
  data() {
    return {
      loginUrl: '',
      isLoading: false,
      error: null,
      show1: false,
      email: '',
      username: '',
      password: '',
      rule: [(v) => !!v || 'Field ini wajib diisi'],
    }
  },
}
</script>

<style>
.ribbon {
  top: 0;
  left: 0;
  position: fixed;
  z-index: 1;
  background: rgb(0, 36, 15);
  background-image: linear-gradient(
    90deg,
    rgba(184, 194, 173, 1) 0%,
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
