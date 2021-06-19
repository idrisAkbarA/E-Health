<template>
  <div>
    <ganti-password :id="parseInt($route.params.userID)"></ganti-password>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  head() {
    return {
      title: this.title,
    }
  },
  data() {
    return {
      title: 'Ganti Password',
    }
  },
  layout: 'apoteker',
}
</script>