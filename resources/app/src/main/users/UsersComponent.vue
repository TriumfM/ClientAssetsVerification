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
      <div class="table__row" v-for="n in 10">
        <div class='table__th--data'>
          <div class="table__th">Username: </div>
          <div class='table__td table_td--click'> DevolliU1</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th">Role: </div>
          <div class='table__td table_td--click'> Client Admin</div>
        </div>
        <div class='table__th--data'>
          <div class="table__th">Active: </div>
          <div class='table__td table_td--click'> True</div>
        </div>
        <div class="table__td--action">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy()">
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
                    <treeselect :options="roles" placeholder=" Choose role" v-model="details.role_id">
                      <label slot="option-label" slot-scope="{ node }">
                        {{ node.raw }}
                      </label>
                    </treeselect>
                    <span class="error__span" v-if="errors.role_id">{{ errors.role_id[0] }}</span>
                  </div>
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
      clients: [],
      brands: [],
      roles: ['Super Admin', 'Client Admin', 'Client User', 'Client Viewer'],
      details: {},
      errors: {},
      showModal: false,
      showLoading: false,
      modal: '',
    }
  },
  computed: {
  },
  watch: {
  },
  mounted: function () {
  },
  methods: {
    getAll: function () {
      Http.get(`/users`)
        .then(response => {
          this.clients = response.data
        })
    },
    getDetails: function (idUser) {
      this.errors = {}
      // Http.get(`/clients/` + idClient)
      //   .then(response => {
      //     this.details = response.data
      //   })
      //   .catch(e => {
      //     this.errors = e.body
      //   })
    },
    save: function (data) {
      let vm = this
      vm.errors = {}
      vm.showLoading = true
      if (data.id !== undefined) {
        Http.put('/clients/' + data.id, vm.details)
          .then(response => {
            vm.getAll()
            vm.errors = {}
            vm.showLoading = false
            swal({title: 'Success!', timer: 1000, text: null, type: 'success', showConfirmButton: false})
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
          })
      } else {
        Http.post(`/vehicles`, this.details)
          .then(response => {
            vm.getAll()
            this.showLoading = false
            vm.errors = {}
            vm.details = {}
            swal({title: 'Success!', timer: 1000, text: null, type: 'success', showConfirmButton: false})
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
          })
      }
    },
    destroy: function (idVehicle) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/vehicles/` + idVehicle)
          .then(response => {
            vm.getAll()
            swal({title: 'Success!', timer: 1000, text: null, type: 'success', showConfirmButton: false})
          })
          .catch(e => {
            swal({title: 'Error!', timer: 1500, text: null, type: 'error', showConfirmButton: false})
          })
      }, '')
    },
    modalAdd: function() {
      this.modal = 'Add new'
      this.showModal = true
    },
    modalEdit: function() {
      this.modal = 'Edit'
      this.showModal = true
    }
  }
}
</script>
