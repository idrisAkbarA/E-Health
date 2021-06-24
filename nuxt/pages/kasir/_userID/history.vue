<template>
  <kasir-history></kasir-history>
</template>

<script>
export default {
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  layout: 'kasir',
  head() {
    return {
      title: this.title,
    }
  },
}
</script>

