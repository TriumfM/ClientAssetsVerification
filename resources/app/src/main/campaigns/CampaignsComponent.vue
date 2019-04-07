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
      <div class="table__row" v-for="campaign in campaigns">
        <div class='table__th--data'>
          <div class='table__th'>Title:</div>
          <div class='table__td table_td--click'>{{campaign.title}}!</div>
        </div>
        <div class="table__tags">
          <span class="tag">{{campaign.client.name}}</span>
          <span class="tag">{{campaign.brand.name}}</span>
        </div>
        <div class="table__button">
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.sms_verified === false),'btn-success': (campaign.sms_verified === true)}" @click="showModalSMS = true, getDetails(campaign.id)">SMS</button>
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.call_verified === false),'btn-success': (campaign.call_verified === true)}" @click="showModalCall= true, getDetails(campaign.id)">Call</button>
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.email_verified === false),'btn-success': (campaign.email_verified === true)}" @click="showModalEmail = true, getDetails(campaign.id)">Email</button>
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
              <li class="dropdown__item" data-toggle="modal" v-on:click="getDetails(campaign.id), modalEdit()">
                <div class="dropdown__item--icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                <span class="dropdown__item--description">Edit</span>
              </li>
              <li class="dropdown__item" v-on:click="destroy(campaign.id)">
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
              <div :class="{'step': true, 'step_active': (step === 0)}" @click="step = 0" >
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
              <campaign-details-data v-if="step === 0" :details="details" :errors="errors"></campaign-details-data>
              <campaign-details-sms v-if="step === 1" :details="details" :errors="errors"></campaign-details-sms>
              <campaign-details-call v-if="step === 2" :details="details" :errors="errors"></campaign-details-call>
              <campaign-details-email v-if="step === 3" :details="details" :errors="errors"></campaign-details-email>
            </div>
            <div class="modal-footer-customize">
              <button class="btn btn-primary" @click="step++" v-if="step !== 3">Next</button>
              <button class="btn btn-primary" :disabled="showLoading" @click="save(details)" v-if="step === 3">
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
              <div class="modal-close" @click="showModalSMS = false, canChangeAsset = true"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-sms :details="details" :errors="errors" :disabled="canChangeAsset"></campaign-details-sms>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="!details.sms_verified">
              <button class="btn btn-success" @click="approve(details,'sms')" v-if="!details.sms_verified && canChangeAsset">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button class="btn btn-info btn-left" @click="canChangeAsset = false" v-if="!details.sms_verified && canChangeAsset">Change</button>
              <button class="btn btn-primary" @click="save(details)" v-if="!canChangeAsset">
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
              <div class="modal-close" @click="showModalCall = false, canChangeAsset = true"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-call :details="details" :errors="errors" :disabled="canChangeAsset"></campaign-details-call>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="!details.call_verified">
              <button class="btn btn-success" @click="approve(details,'sms')"v-if="!details.call_verified && canChangeAsset">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button class="btn btn-info btn-left" @click="canChangeAsset = false" v-if="!details.call_verified && canChangeAsset">Change</button>
              <button class="btn btn-primary" @click="save(details)" v-if="!canChangeAsset">
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
              <div class="modal-close" @click="showModalEmail = false, canChangeAsset = true"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-email :details="details" :errors="errors" :disabled="canChangeAsset"></campaign-details-email>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="!details.email_verified">
              <button class="btn btn-success" @click="approve(details,'email')" v-if="!details.email_verified && canChangeAsset">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button class="btn btn-info btn-left" @click="canChangeAsset = false" v-if="!details.email_verified && canChangeAsset">Change</button>
              <button class="btn btn-primary" @click="save(details)" v-if="!canChangeAsset">
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
      campaigns: {},
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
      canChangeAsset: true,
      modal: '',
      step: 0,
      normalizerName (node) {
        return {
          id: node.id,
          label: node.name
        }
      }
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
      Http.get(`/campaigns?include=client,brand`)
        .then(response => {
          this.campaigns = response.data
        })
    },
    getDetails: function (idCampaign) {
      this.errors = {}
      Http.get(`/campaigns/` + idCampaign)
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
        Http.put('/campaigns/' + data.id, vm.details)
          .then(response => {
            vm.getAll()
            vm.errors = {}
            vm.showLoading = false
            vm.showModal = false
            vm.canChangeAsset = true
            alert.success()
          })
          .catch(e => {
            vm.showLoading = false
            vm.errors = e.response.data.errors
            vm.step = 0
            if(vm.errors === {}) {
              alert.failed()
            }
          })
      } else {
        Http.post(`/campaigns`, this.details)
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
            vm.step = 0
            if(vm.errors === {}) {
              alert.failed()
            }
          })
      }
    },
    destroy: function (idBrand) {
      let vm = this
      alert.deletePopUp(function () {
        Http.delete(`/campaigns/` + idBrand)
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
      this.showModal = true
      this.details = {}
      this.step = 0
    },
    modalEdit: function() {
      this.modal = 'Edit'
      this.showModal = true
      this.step = 0
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
    approve: function (data,asset) {
      let vm = this
      vm.errors = {}
      vm.showLoading = true
      if(asset === 'sms') this.details.sms_verified = true
      if(asset === 'call') this.details.call_verified = true
      if(asset === 'email') this.details.email_verified = true
      Http.put('/campaigns/' + data.id, vm.details)
        .then(response => {
          vm.getAll()
          vm.showLoading = false
          alert.success()
        })
        .catch(e => {
          vm.showLoading = false
          vm.errors = e.response.data.errors
          if(asset === 'sms') this.details.sms_verified = false
          if(asset === 'call') this.details.call_verified = false
          if(asset === 'email') this.details.email_verified = false
          if(vm.errors === {}) {
            alert.failed()
          }
        })
    },
    sendEmail: function() {
    }
  }
}
</script>
