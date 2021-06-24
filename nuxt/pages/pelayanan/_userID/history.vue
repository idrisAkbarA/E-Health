<template>
  <pelayanan-history></pelayanan-history>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  layout: 'pelayanan',
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

