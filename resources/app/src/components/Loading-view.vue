<template>
  <div class="app_container">
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
  },
  watch: {
  }
}
</script>
