<template>
  <div>
    <h1>wow bisa</h1>
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
      title: 'Dashboard Pelayanan',
    }
  },
  layout: 'pelayanan',
}
</script>