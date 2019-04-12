<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">Asset request</h2>
    </div>
    <div class="horizontal__line"></div>
    <div class="table_4td">
      <div class="table__row" v-for="n in 10">
        <div class='table__th--data'>
          <div class="table__th">User: </div>
          <div class='table__td table_td--click'>user.name</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th">Campaign:</div>
          <div class='table__td table_td--click'>campaign.name</div>
        </div>
        <div class='table__th--data'>
          <div class='table__td table_td--click'>SMS</div>
        </div>
        <div class="table__button">
          <button :class="{'btn': true, 'btn__': true, 'btn__asset': true, 'btn-danger': true}">
            <i class="fa fa-times"> </i>
          </button>
          <button :class="{'btn': true, 'btn__': true, 'btn__asset': true, 'btn-success': true}">
            <i class="fa fa-check"> </i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {Http} from '@/helpers/http-helper'
import alert from '@/services/sweetAlert.js'

export default {
  data() {
    return {
      assets: {},
      errors: {},
      showModal: false,
      showLoading: false,
      user: {},
      modal: '',
    }
  },
  computed: {},
  watch: {
    showModal: function () {
    }
  },
  mounted: function () {
    // this.getUser()
    this.getAll()
  },
  methods: {
    getAll: function () {
      Http.get(`/clients`)
        .then(response => {
          this.clients = response.data
        })
    },
    save: function (data) {
      let vm = this
      vm.errors = {}
      vm.showLoading = true
      Http.post(`/clients`, this.details)
        .then(response => {
          vm.getAll()
          vm.showLoading = false
          alert.success()
        })
        .catch(e => {
          vm.showLoading = false
          vm.errors = e.response.data.errors
          if (vm.errors === {}) {
            alert.failed()
          }
          console.log(vm.errors)
        })
    }
  },
  destroy: function (idAsset) {
    let vm = this
    alert.deletePopUp(function () {
      Http.delete(`/clients/` + idAsset)
        .then(response => {
          vm.getAll()
          alert.success()
        })
        .catch(e => {
          alert.failed()
        })
    }, '')
  },

  getUser: function () {
    Http.get(`auth/details`)
      .then(response => {
        this.user = response.data
        if (response.data.role_id !== 1) {
          this.$router.push('brands')
        }
      })
  }
}
</script>
