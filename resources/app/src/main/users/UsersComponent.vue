<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">All Users</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <div class="table_3td">
      <div class="table__row" v-for="user in users">
        <div class='table__th--data'>
          <div class="table__th">Username: </div>
          <div class='table__td table_td--click'>{{user.username}}</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th"></div>
          <div class='table__td table_td--click'>user.role</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th"></div>
          <div class='table__td table_td--click'><i :class="{'fa': true, 'fa-circle': true, 'text-success': (user.active === 1), 'text-danger': (user.active === false)}"></i></div>
        </div>
        <div class="table__td--action">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(user.id), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy(user.id)">
                <div class="dropdown__item--icon"><i class="fa fa-trash" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Delete</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <transition name="modal" v-if="showModal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header-customize">
              <span class="modal-title">{{modal}}</span>
              <div class="modal-close" @click="showModal = false"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <div class="form-line">
                  <div class="cnf__input col-md-6">
                    <label>First name</label>
                    <input type="text" class="form-control" placeholder=" Enter first name" v-model="details.first_name">
                    <span class="error__span" v-if="errors.first_name">{{ errors.first_name[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Last name</label>
                    <input type="text" class="form-control" placeholder=" Enter last name" v-model="details.last_name">
                    <span class="error__span" v-if="errors.last_name">{{ errors.last_name[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder=" Enter username" v-model="details.username">
                    <span class="error__span" v-if="errors.username">{{ errors.username[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder=" Enter email" v-model="details.email">
                    <span class="error__span" v-if="errors.email">{{ errors.email[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Password</label>
                    <input type="text" class="form-control" placeholder=" Enter email" v-model="details.password">
                    <span class="error__span" v-if="errors.password">{{ errors.password[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-6">
                    <label>Confirm Password</label>
                    <input type="text" class="form-control" placeholder=" Enter email" v-model="details.cnf_password">
                    <span class="error__span" v-if="errors.cnf_password">{{ errors.cnf_password[0] }}</span>
                  </div>
                  <div class="cnf__input col-md-12">
                    <label>Role</label>
                    <treeselect :options="roles" placeholder=" Choose role" :normalizer='normalizer' v-model="details.role">
                      <label slot="option-label" slot-scope="{ node }">
                      {{ node.raw.name }}
                      </label>
                    </treeselect>
                    <span class="error__span" v-if="errors.role_id">{{ errors.role_id[0] }}</span>
                  </div>
                  <!--<div class="cnf__input col-md-6">-->
                    <!--<label>Client</label>-->
                    <!--<treeselect :options="roles" placeholder=" Choose client" v-model="details.client_id">-->
                      <!--<label slot="option-label" slot-scope="{ node }">-->
                        <!--{{ node.raw }}-->
                      <!--</label>-->
                    <!--</treeselect>-->
                    <!--<span class="error__span" v-if="errors.role_id">{{ errors.role_id[0] }}</span>-->
                  <!--</div>-->
                  <!--<div class="cnf__input col-md-6">-->
                    <!--<label>Brands</label>-->
                    <!--<treeselect :options="roles" placeholder=" Choose brands" v-model="details.brands">-->
                      <!--<label slot="option-label" slot-scope="{ node }">-->
                        <!--{{ node.raw }}-->
                      <!--</label>-->
                    <!--</treeselect>-->
                    <!--<span class="error__span" v-if="errors.brands">{{ errors.brands[0] }}</span>-->
                  <!--</div>-->
                  <div class="cnf__input ">
                    <input type="checkbox" v-model="details.active">
                    <label>Active</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-light" @click="showModal = false">Close</button>
              <button class="btn btn-primary" :disabled="showLoading" @click="save()">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import {Http} from '@/helpers/http-helper'

import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import alert from '@/services/sweetAlert.js'
import swal from 'sweetalert2/dist/sweetalert2.js'

export default{
  components: {
    Treeselect
  },
  data () {
    return {
      users: {},
      clients: [],
      brands: [],
      roles: [{name:'Super Admin'}, {name:'Client Admin'}, {name:'Client User'}, {name:'Client Viewer'}],
      details: {},
      errors: {},
      showModal: false,
      showLoading: false,
      modal: '',
      normalizer (node) {
        return {
          id: node.name,
          label: node.name
        }
      },
    }
  },
  computed: {
  },
  watch: {
  },
  mounted: function () {
    this.getAll()
  },
  methods: {
    getAll: function () {
      Http.get(`/users`)
        .then(response => {
          this.users = response.data
        })
    },
    getDetails: function (idUser) {
      this.errors = {}
      Http.get(`/users/` + idUser)
        .then(response => {
          this.details = response.data
        })
        .catch(e => {
          this.errors = e.body
        })
    },
    save: function (data) {
      let vm = this
      vm.errors = {}
      vm.showLoading = true
      if (data.id !== undefined) {
        Http.put('/users/' + data.id, vm.details)
          .then(response => {
            vm.getAll()
            vm.errors = {}
            vm.showLoading = false
            vm.showModal = false
            alert.success()
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
            console.log(vm.errors)
            if(vm.errors === {}) {
              alert.failed()
            }
          })
      } else {
        Http.post(`/users`, this.details)
          .then(response => {
            vm.getAll()
            vm.showLoading = false
            vm.showModal = false
            vm.errors = {}
            vm.details = {}
            alert.success()
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
            if(vm.errors === {}) {
              alert.failed()
            }
            console.log(vm.errors)
          })
      }
    },
    destroy: function (idUser) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/users/` + idUser)
          .then(response => {
            vm.getAll()
            alert.success()
          })
          .catch(e => {
            alert.failed()
          })
      }, '')
    },
    modalAdd: function() {
      this.modal = 'Add new'
      this.details = {}
      this.showModal = true
    },
    modalEdit: function() {
      this.modal = 'Edit'
      this.showModal = true
    }
  }
}
</script>
