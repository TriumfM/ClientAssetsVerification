<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">All Campaigns</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <!--<div class="filter__search">-->
      <!--<div class="search__row">-->
        <!--<div class="input-group" id="adv-search">-->
          <!--<input type="text" class="form-control" placeholder="Search by campaign title ..." v-model="search.identifier_name" v-on:keyup.enter="getAll()"/>-->
          <!--<div class="input-group-btn">-->
            <!--<div class="btn-group" role="group">-->
              <!--<div>-->
                <!--<button type="button" class="btn btn__filter-open dropdown-toggle" v-on:click="showFilter = !showFilter"><span class="caret"></span></button>-->
              <!--</div>-->
            <!--</div>-->
          <!--</div>-->
          <!--<div class="dropdown_filter-content">-->
            <!--<transition name="fade">-->
              <!--<div class="dropdown__filter" v-if="showFilter">-->
                <!--<div class="option__filter">-->
                  <!--<span class="option__filter-name"> Campaign:</span>-->
                  <!--<div class="option__filter-value">-->
                    <!--<input type="text" class="option__filter-value&#45;&#45;input" v-model="search.identifier_name"/>-->
                  <!--</div>-->
                <!--</div>-->
                <!--<div class="option__filter-submit">-->
                  <!--<div class="btn_submit&#45;&#45;search">-->
                    <!--<button class="btn btn-light" v-on:click="getAll()">Search</button>-->
                  <!--</div>-->
                <!--</div>-->
              <!--</div>-->
            <!--</transition>-->
          <!--</div>-->
        <!--</div>-->
      <!--</div>-->
    <!--</div>-->
    <div class="table__main">
      <div class="table__row" v-for="n in 10">
        <div class='table__th--data'>
          <div class='table__th'>Title:</div>
          <div class='table__td table_td--click'>Me qumshtin Vita u rrita!</div>
        </div>
        <div class="table__tags">
          <span class="tag">Devolli</span>
          <span class="tag">Vita</span>
        </div>
        <div class="table__button">
          <button class="btn btn__ btn-danger">SMS</button>
          <button class="btn btn__ btn-success">Call</button>
          <button class="btn btn__ btn-danger">Email</button>
        </div>
        <div class="table__td--action">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-send" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Send to client</span>
              </li>
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Return back</span>
              </li>
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
          <div class="modal-container modal-container_lg">
            <div class="modal-header-stepper">
              <router-link to="/campaigns/data" class="step">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Details</span>
              </router-link>
              <div class="line"></div>
              <router-link to="/campaigns/sms" class="step">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">SMS</span>
              </router-link>
              <div class="line"></div>
              <router-link to="/campaigns/call" class="step">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Call</span>
              </router-link>
              <div class="line"></div>
              <router-link to="/campaigns/email" class="step">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Email</span>
              </router-link>
            </div>
            <div class="modal-body-customize">
              <router-view></router-view>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-primary">Next</button>
              <button class="btn btn-primary" @click="showModal = false">Close</button>
              <!--<button class="btn btn-primary" :disabled="showLoading" @click="save()">-->
                <!--<i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save-->
              <!--</button>-->
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
        search: {},
        errors: {},
        showModal: false,
        showLoading: false,
        showFilter: false,
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
