<template>
  <div id="app" class="app__container">
    <router-view :class="{'col-md-12':true, 'noPadding': true }"/>
  </div>
</template>

<script>
import LeftMenu from '@/navigation/LeftMenu'

export default {
  name: 'app',
  computed: {
    route () {
      return this.$route.path
    }
  },
  components: {
    LeftMenu
  },
  watch: {
    route: function () {
      if (this.$route.path === '/') {
        // if (localStorage.getItem('vuex') !== '') {
        this.$router.push('clients')
        // } else {
        //   localStorage.setItem('vuex', '')
        //   this.$router.push('root')
        // }
      }
    }
  },
  mounted: function () {
    if (this.$route.path === '/') {
      console.log('123')
      // if (localStorage.getItem('vuex') === '') {
      this.$router.push('clients')
      // } else {
      //   this.$router.push('dashboard')
      // }
    }
  }
}
</script>

