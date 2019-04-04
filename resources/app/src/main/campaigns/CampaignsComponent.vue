<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side">All Campaigns</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
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
          <button class="btn btn__ btn-danger" @click="showModalSMS = true">SMS</button>
          <button class="btn btn__ btn-success" @click="showModalCall = true">Call</button>
          <button class="btn btn__ btn-danger" @click="showModalEmail = true">Email</button>
        </div>
        <div class="table__td--action">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="returnBack()">
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
              <div :class="{'step': true, 'step_active': (step === 0)}" @click="step = 0">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Details</span>
              </div>
              <div class="line"></div>
              <div :class="{'step': true, 'step_active': (step === 1)}" @click="step = 1">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">SMS</span>
              </div>
              <div class="line"></div>
              <div :class="{'step': true, 'step_active': (step === 2)}" @click="step = 2">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Call</span>
              </div>
              <div class="line"></div>
              <div :class="{'step': true, 'step_active': (step === 3)}" @click="step = 3">
                <div class="icon"><i class="fa fa-circle"></i></div>
                <span class="details">Email</span>
              </div>
              <i class="fa fa-times close_modal" @click="showModal = false"></i>
            </div>
            <div class="modal-body-customize modal-body-stepper">
              <campaign-details-data v-if="step === 0"></campaign-details-data>
              <campaign-details-sms v-if="step === 1"></campaign-details-sms>
              <campaign-details-call v-if="step === 2"></campaign-details-call>
              <campaign-details-email v-if="step === 3"></campaign-details-email>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-primary" @click="step++" v-if="step !== 3">Next</button>
              <button class="btn btn-primary" :disabled="showLoading" @click="save()" v-if="step === 3">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-sms" v-if="showModalSMS">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header-customize">
              <span class="modal-title">SMS</span>
              <div class="modal-close" @click="showModalSMS = false"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <div class="form-line">
                  <div class="cnf__input ">
                    <label>SMS content(160 characters)</label>
                    <textarea type="text" class="form-control cnt__textarea-188" v-model="details.email_html" :disabled="approveMode"></textarea>
                    <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-success" @click="approve()" v-if="approveMode">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button class="btn btn-info btn-left" @click="approveMode = false" v-if="approveMode">Change</button>
              <button class="btn btn-primary" @click="approveMode = true" v-if="!approveMode">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-call" v-if="showModalCall">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header-customize">
              <span class="modal-title">Call</span>
              <div class="modal-close" @click="showModalCall = false"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <div class="form-line">
                  <div class="cnf__input ">
                    <label>Call content(1500 characters)</label>
                    <textarea type="text" class="form-control cnt__textarea-188" v-model="details.call" :disabled="approveMode"></textarea>
                    <span class="error__span" v-if="errors.call">{{ errors.call[0] }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-success" @click="approve()" v-if="approveMode">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button class="btn btn-info btn-left" @click="approveMode = false" v-if="approveMode">Change</button>
              <button class="btn btn-primary" @click="approveMode = true" v-if="!approveMode">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-email" v-if="showModalEmail">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container modal-container_lg">
            <div class="modal-header-customize">
              <span class="modal-title">Email</span>
              <div class="modal-close" @click="showModalEmail = false"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <div class="form-line">
                  <div class="cnf__input col-md-12">
                    <label>Subject</label>
                    <input type="text" class="form-control" placeholder=" Enter subject" v-model="details.email_subject" :disabled="approveMode">
                    <span class="error__span" v-if="errors.email_subject">{{ errors.email_subject[0] }}</span>
                  </div>
                  <div class="cnf__input ">
                    <label>Email content</label>
                    <textarea type="text" class="form-control cnt__textarea-233" v-model="details.email_html" :disabled="approveMode"></textarea>
                    <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-success" @click="approve()" v-if="approveMode">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button class="btn btn-info btn-left" @click="approveMode = false" v-if="approveMode">Change</button>
              <button class="btn btn-primary" @click="approveMode = true" v-if="!approveMode">
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

import CampaignDetailsEmail from '@/main/campaigns/details/email'
import CampaignDetailsSms from '@/main/campaigns/details/sms'
import CampaignDetailsCall from '@/main/campaigns/details/call'
import CampaignDetailsData from '@/main/campaigns/details/detailsData'

export default{
  components: {
    Treeselect,
    CampaignDetailsEmail,
    CampaignDetailsSms,
    CampaignDetailsCall,
    CampaignDetailsData
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
      showModalSMS: false,
      showModalCall: false,
      showModalEmail: false,
      approveMode: true,
      showLoading: false,
      showFilter: false,
      modal: '',
      step: 0
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
    },
    returnBack: function() {
      swal.fire({
        title: 'Are you sure?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        closeOnConfirm: false,
        customClass: 'sweetalert-sm'
      })
    },
    approve: function () {
      this.returnBack()
    },
    sendEmail: function() {
    }
  }
}
</script>
