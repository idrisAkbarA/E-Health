<template>
  <v-container fill-height>
    <v-container>
      <v-row dense>
        <v-col>
          <h2>Login</h2>
          Silahkan login untuk masuk ke aplikasi
        </v-col>
      </v-row>
      <v-row
        dense
        v-if="error"
      >
        <v-col>
          <p class="red--text">{{ error }}</p>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-text-field
            :rules="rule"
            prepend-inner-icon="mdi-account-circle"
            hide-details="auto"
            color="secondary"
            label="Username"
            v-model="username"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-text-field
            :rules="rule"
            prepend-inner-icon="mdi-lock"
            color="secondary"
            v-model="password"
            :type="show1 ? 'text' : 'password'"
            @keyup.enter="login()"
            label="Password"
            @click:append="show1 = !show1"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row
        class="mt-3"
        align="center"
        dense
      >
        <v-col cols="6">
          <v-btn
            :loading="isLoading"
            @click="login()"
            color="primary"
            dark
          >Login</v-btn>
        </v-col>
        <v-col>
          <br>
          <span>
            <a href="/lupa-password">Lupa Password?</a>
          </span>
        </v-col>
      </v-row>
    </v-container>

  </v-container>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
  created() {
    console.log(this)
    // var pathArray = window.location.pathname.split('/')
    // this.loginUrl = pathArray[pathArray.length - 1]
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
        username: this.username,
        password: this.password,
      }
      await this.$auth
        .loginWith('local', { data })
        .then(() => {
          this.redirect(this)
          console.log('logged in')
        })
        .catch((error) => {
          console.log('auth', error)
          this.isLoading = false
          this.error = 'Maaf terjadi kesalahan, coba lagi dalam beberapa saat'
        })
    },
    redirect(that) {
      switch (that.$auth.user.role) {
        case 'Admin':
          console.log('im an admin')
          that.$router.replace(`/admin/${that.$auth.user.id}/dashboard`)
          break
        case 'Apoteker':
          that.$router.replace(`/apoteker/${that.$auth.user.id}/dashboard`)
          break
        case 'Dokter':
          that.$router.replace(`/dokter/${that.$auth.user.id}/dashboard`)
          break
        case 'Kepala Instansi':
          that.$router.replace(
            `/kepala-instansi/${that.$auth.user.id}/dashboard`
          )
          break
        case 'Pelayanan':
          that.$router.replace(`/pelayanan/${that.$auth.user.id}/dashboard`)
          break

        default:
          break
      }
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
a {
  color: #b8c2ad !important;
}
</style>
