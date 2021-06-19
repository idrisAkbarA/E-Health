<template>
  <ganti-password :id="parseInt($route.params.userID)"></ganti-password>
</template>

<script>
export default {
  mounted() {
    this.$store.commit('page/setTitle', this.title)
    // console.log('params', this.$route.params)
  },
  head() {
    return {
      title: this.title,
    }
  },
  computed: {
    userID() {
      return parseInt(this.$route.params.userID)
    },
  },
  data() {
    return {
      title: 'Ganti Password',
    }
  },
  layout: 'pelayanan',
}
</script>