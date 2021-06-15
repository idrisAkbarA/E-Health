<template>
  <v-container fill-height>
    <v-card
      class="mx-auto"
      flat
      :width="windowWidth<=600?'90%':'65%'"
    >
      <v-card-text>
        <v-container>
          <v-row dense>
            <v-col>
              <h2>Login</h2>
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
                color="green"
                :label="loginUrl == 'login' ? 'Email' : 'Username'"
                v-model="email"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col>
              <v-text-field
                :rules="rule"
                prepend-inner-icon="mdi-lock"
                color="green"
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
                color="green"
                dark
              >Login</v-btn>
            </v-col>
            <v-col
              :cols="windowWidth<=600?12:6"
              v-if="loginUrl == 'login'"
            >
              <span>
                Belum memiliki akun? Daftar <a href="/pendaftaran">di sini</a>.
              </span>
              <br>
              <span>
                <a href="/lupa-password">Lupa Password?</a>
              </span>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
    <v-card>
      <v-btn @click="getUser()">test get user</v-btn>
    </v-card>
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

<style></style>
