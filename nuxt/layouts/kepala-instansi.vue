<template>
  <v-app id="inspire">
    <v-navigation-drawer
      class="notprint"
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
          <v-card-text>Aplikasi PMB Pascasarjana</v-card-text>
        </v-card>
        <v-card
          v-if="windowWidth <= 600"
          class="d-flex justify-center pr-2 pl-2"
          flat
          tile
        >
          <v-card-text>
            Selamat datang {{ $route.params.userID }}
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
            :key="'PMB-' + i"
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
      class="notprint"
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
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3"
          dark
          v-if="checkRoute('Kelola Petugas')"
          @click="setBottomSheetToTrue"
        >
          <v-icon> mdi-plus</v-icon> tambah petugas
        </v-btn>
      </v-slide-y-transition>
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3"
          dark
          v-if="checkRoute('Kelola Soal')"
          @click="setBottomSheetToTrue"
        >
          <v-icon left> mdi-plus</v-icon> tambah soal
        </v-btn>

      </v-slide-y-transition>
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3 ml-2"
          dark
          v-if="checkRoute('Kelola Soal')"
          @click="setBottomSheetToTrue2"
        >
          <v-icon left> mdi-file-excel</v-icon> Import soal
        </v-btn>

      </v-slide-y-transition>
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3"
          dark
          v-if="checkRoute('Kelola Periode')"
          @click="setBottomSheetToTrue"
        >
          <v-icon> mdi-plus</v-icon> tambah periode
        </v-btn>
      </v-slide-y-transition>
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3"
          dark
          v-if="checkRoute('Kelola Jurusan')"
          @click="setBottomSheetToTrue"
        >
          <v-icon> mdi-plus</v-icon> tambah jurusan
        </v-btn>
      </v-slide-y-transition>
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3"
          dark
          v-if="checkRoute('Kelola Temu Ramah') && currentPeriode"
          @click="setBottomSheetToTrue"
        >
          <v-icon> mdi-plus</v-icon> tambah jadwal
        </v-btn>
      </v-slide-y-transition>
      <v-slide-y-transition>
        <v-btn
          small
          class="green darken-3"
          dark
          v-if="checkRoute('Kelola Kategori')"
          @click="setBottomSheetToTrue"
        >
          <v-icon> mdi-plus</v-icon> tambah kategori
        </v-btn>
      </v-slide-y-transition>

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
      bottom
      :color="snackbar.color"
      outlined
    >
      {{ snackbar.message}}
    </v-snackbar>
  </v-app>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex'
export default {
  middleware: ['kepala-instansi'],
  created() {
    this.getPoli()
  },
  mounted() {
    this.getAntrianPoli()
    this.$echo.channel('antrian-poli').listen('AntrianPoli', (e) => {
      console.log('update', e)
      this.$store.commit('antrian-poli/setData', e.rekamMedis)
    })
    this.getAntrianObat()
    this.$echo.channel('antrian-obat').listen('AntrianObatEvent', (e) => {
      console.log('update:', e)
      this.$store.commit('antrian-obat/SET_DATA', e.antrianObat)
    })
  },
  methods: {
    ...mapActions({
      getAntrianObat: 'antrian-obat/fetchData',
      getPoli: 'poli/getPoli',
      getAntrianPoli: 'antrian-poli/fetchData',
    }),
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
          to: `/kepala-instansi/${petugas}/dashboard`,
        },
        {
          icon: 'mdi-lock',
          title: 'Ubah Password',
          to: `/kepala-instansi/${petugas}/ganti-password`,
        },
        {
          icon: 'mdi-text-box',
          title: 'Laporan',
          to: `/kepala-instansi/${petugas}/laporan`,
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
