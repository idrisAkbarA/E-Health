<template>
  <div class="bg-pattern">
    <error404 v-if="error.statusCode === 404"></error404>
    <error401 v-if="error.statusCode === 401"></error401>
    <h1 v-else>
      {{error}}
      {{ otherError }}
      {{error.statusCode}}
    </h1>
  </div>
</template>

<script>
export default {
  layout: 'empty',
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      pageNotFound: '404 Not Found',
      otherError: 'An error occurred',
    }
  },
  head() {
    const title =
      this.error.statusCode === 404 ? this.pageNotFound : this.otherError
    return {
      title,
    }
  },
}
</script>

<style scoped>
h1 {
  font-size: 20px;
}
.bg-pattern {
  background: url('/pattern.svg') repeat;
  background-size: 400px;
}
</style>
