<template>
  <apoteker-history></apoteker-history>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  layout: 'apoteker',
  head() {
    return {
      title: this.title,
    }
  },
  mounted() {
    this.$store.commit('page/setTitle', this.title)
  },
  data() {
    return {
      title: 'History',
    }
  },
}
</script>
