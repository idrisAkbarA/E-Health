<template>
  <v-app id="inspire">
    <v-navigation-drawer
      :src="'/drawer-bg.jpg'"
      v-model="drawer"
      app
      clipped
      :floating="true"
      :permanent="windowWidth <= 600 ? false : permanent"
      :expand-on-hover="windowWidth <= 600 ? false : expandOnHover"
      :mini-variant="windowWidth <= 600 ? false : miniVariant"
      dark
    >
      <vue-scroll :ops="scrollOps">
        <v-card
          v-if="windowWidth <= 600"
          class="d-flex justify-center pt-4 pr-2 pl-2"
          flat
          tile
        >
          <v-img
            max-width="70"
            :src="'/images/LogoUIN.png'"
          ></v-img>
          <v-card-text>Sistem Informasi Rawat Jalan Puskesmas Bangkinang Kota</v-card-text>
        </v-card>
        <v-card
          v-if="windowWidth <= 600"
          class="d-flex justify-center pr-2 pl-2"
          flat
          tile
        >
          <v-card-text>
            Selamat datang {{ $auth.user.name }}
            <br />
            <v-btn
              class="mt-2"
              outlined
              color="green darken-2"
              small
              block
              @click="logout"
            >
              <v-icon>mdi-logout-variant</v-icon>keluar
            </v-btn>
          </v-card-text>
        </v-card>
        <v-list dense>
          <v-list-item
            v-for="(page, i) in pages"
            :key="'key-' + i"
            :to="page.to"
            :two-line="page.subtitle ? true : false"
            router
            exact
          >
            <v-list-item-action>
              <v-icon>{{ page.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ page.title }}</v-list-item-title>
              <v-list-item-subtitle v-if="page.subtitle">{{
                page.subtitle
              }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </vue-scroll>
    </v-navigation-drawer>

    <v-app-bar
      app
      dense
      clipped-left
    >
      <v-app-bar-nav-icon @click.stop="toggleDrawer(windowWidth <= 600)"></v-app-bar-nav-icon>
      <div style="width: 100%; -webkit-app-region: drag">
        <v-toolbar-title>
          <span
            v-if="!$vuetify.breakpoint.mobile"
            class="font-weight-bold ml-4"
          ></span>

          <span>{{ title }}</span>
        </v-toolbar-title>
      </div>
      <v-btn
        v-if="windowWidth >= 600"
        small
        text
        @click="logout"
      >
        <v-icon>mdi-logout-variant</v-icon>keluar
      </v-btn>
    </v-app-bar>

    <v-main class="bg-pattern">
      <transition
        name="slide-fade"
        mode="out-in"
      >
        <nuxt />
      </transition>

      <!-- <v-fade-transition mode="in" hide-on-leave="true">
        <router-view></router-view>
      </v-fade-transition>-->
    </v-main>
    <v-snackbar
      :value="snackbar.value"
      timeout="2000"
      :color="snackbar.color ? snackbar.color : 'success'"
      outlined
    >
      {{ snackbar.message }}
    </v-snackbar>
  </v-app>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex'
export default {
  middleware: ['admin'],
  methods: {
    toggleDrawer(bool) {
      if (!bool) {
        this.miniVariant = !this.miniVariant
        this.expandOnHover = !this.expandOnHover
      } else {
        this.drawer = !this.drawer
      }
    },
    checkRoute(name) {
      return this.$route.name == name
    },
    async logout() {
      await this.$auth.logout()
    },
  },
  props: {
    source: String,
  },
  computed: {
    snackbar: {
      get: function () {
        return this.$store.state.snackbar.data
      },
      set: function (v) {
        this.$store.commit('snackbar/set', v)
      },
    },
    title() {
      return this.$store.state.page.title
    },
    pages() {
      let petugas = this.$route.params.userID
      return [
        {
          icon: 'mdi-view-dashboard',
          title: 'Dashboard',
          to: `/admin/${petugas}/dashboard`,
        },
        {
          icon: 'mdi-lock',
          title: 'Ubah Password',
          to: `/admin/${petugas}/ganti-password`,
        },
        {
          icon: 'mdi-bank',
          title: 'Kelola Poly',
          to: `/admin/${petugas}/kelola-poly`,
        },
        {
          icon: 'mdi-account-details',
          title: 'Kelola Petugas',
          to: `/admin/${petugas}/kelola-petugas`,
        },
      ]
    },
  },
  data: () => ({
    drawer: false,
    permanent: true,
    miniVariant: true,
    expandOnHover: true,
    scrollOps: {
      scrollPanel: {
        easing: 'easeInQuad',
        speed: 800,
        scrollingX: false,
      },
      bar: {
        background: '#FFEBEE',
      },
      vuescroll: {
        mode: 'native',
        wheelScrollDuration: 0,
        locking: true,
      },
    },
  }),
  mounted() {
    console.log(this.$route)
    console.log(this.$route.matched)
  },
}
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.2s ease-out;
}
.slide-fade-leave-active {
  transition: all 0.2s ease-in;
}
.slide-fade-enter
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: scale(1.1);

  opacity: 0;
}
.slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: scale(0.9);

  opacity: 0;
}
/* The emerging W3C standard
   that is currently Firefox-only */
*::-webkit-scrollbar {
  width: 7px;

  margin: 10px;
  transition: 1s ease;
}

/* Track */

*::-webkit-scrollbar-track {
  background: transparent;
  /* background: #F9F9F9; */

  margin: 10px;
}

/* Handle */

*::-webkit-scrollbar-thumb {
  transition: 1s ease;
  background: #f79593;
  opacity: 0.5;
  border-radius: 25px;

  margin: 10px;
}

/* Handle on hover */

*::-webkit-scrollbar-thumb:hover {
  transition: 1s ease;
  background: #ff8481;
}
.bg-pattern {
  background: url('/pattern.svg') repeat;
  background-size: 400px;
}
a {
  text-decoration: none !important;
}
</style>
