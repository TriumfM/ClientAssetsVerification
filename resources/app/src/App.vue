<template>
  <div id="app" class="app__container">
    <router-view :class="{'col-md-12':true, 'noPadding': true }"/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

