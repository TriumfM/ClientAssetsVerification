<template>
  <div :class="{'menu':true, 'sidebar':true,}">
    <div class="logo">
      <div class="first__letters">s
        <p>JD</p>
      </div>
      <p class="user__name">John Doe</p>
    </div>
    <div class="user__actions">
      <a @click="logout()"><i class="fa fa-power-off" aria-hidden="true"></i></a>
    </div>
    <div class='list'>
      <router-link to="/clients" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] === 'clients')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-building-o"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Clients</span>
        </div>
      </router-link>
      <router-link to="/brands" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] === 'brands')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-square-o"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Brands</span>
        </div>
      </router-link>
      <router-link to="/campaigns" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] === 'campaigns')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-sticky-note"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Campaigns</span>
        </div>
      </router-link>
      <router-link to="/users" :class="{'list__tile--link' : true, 'list__tile--link-active' : (routes[1] === 'users')}">
        <span class="active__span"></span>
        <div :class="{'list__tile__icon':true, 'active__icon': true}">
          <i class="fa fa-users"></i>
        </div>
        <div :class="{'list__tile__title':true}">
          <span>Users</span>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script>

export default {
  props: [],
  data () {
    return {
      routes: []
    }
  },
  filters: {
    capitalize: function (value) {
      if (!value) return ''
      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
  watch: {
    '$route': function () {
      this.watchRoute()
    }
  },
  mounted: function () {
    this.watchRoute()
  },
  methods: {
    watchRoute: function () {
      this.routes = String(this.$route.path).split('/')
      if (this.routes[2] === undefined) {
        this.routes[2] = 'clients'
      }
    },
  }
}
</script>
