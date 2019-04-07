<template>
  <div class="app__container">
    <div class="img_loading_middle">
      <img src="@/assets/img/loading-animated.gif" alt="Loading.."/>
    </div>
  </div>
</template>
<script>

export default {
  name: 'app',
  computed: {
    route () {
      return this.$route.path
    }
  },
  components: {
  },
  mounted: function () {
    this.$router.push('clients')
  },
  watch: {
  }
}
</script>
