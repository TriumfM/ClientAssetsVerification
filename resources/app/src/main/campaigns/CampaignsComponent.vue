<template>
  <div class="col-md-12 menu-content">
    <div class="menu-content_header">
      <h2 class="title_side" v-if="$route.name === 'campaigns'">All Campaigns</h2>
      <h2 class="title_side" v-if="$route.name === 'clients-campaigns'">Campaigns of client: {{client.name}}</h2>
      <h2 class="title_side" v-if="$route.name === 'brands-campaigns'">Campaigns of brands: {{brand.name}}</h2>
      <div class="add_new-button">
        <button class="btn btn-primary" @click="modalAdd()" v-if="user.role_id === 1 || user.role_id === 2">Add new</button>
      </div>
    </div>
    <div class="horizontal__line"></div>
    <div class="table__main">
      <div class="table__row" v-for="campaign in campaigns">
        <div class='table__th--data'>
          <div class='table__th'>Title:</div>
          <div class='table__td table_td--click'>{{campaign.title}}</div>
        </div>
        <div class="table__tags">
          <span class="tag">{{campaign.client.name}}</span>
          <span class="tag">{{campaign.brand.name}}</span>
        </div>
        <div class="table__button">
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.sms_verified === false),'btn-success': (campaign.sms_verified === true)}" @click="openModal(campaign.id, 'sms'), modalAsset('sms', campaign.sms_verified)">SMS</button>
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.call_verified === false),'btn-success': (campaign.call_verified === true)}" @click="openModal(campaign.id, 'call'), modalAsset('call', campaign.call_verified)">Call</button>
          <button :class="{'btn': true, 'btn__': true, 'btn-danger': (campaign.email_verified === false),'btn-success': (campaign.email_verified === true)}" @click="openModal(campaign.id, 'email'), modalAsset('email', campaign.email_verified)">Email</button>
        </div>
        <div class="table__td--action" v-if="user.role_id !== 4">
          <div class="dropdown">
            <div class="icon__dropdown"  id="dropdownRowBuilding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <i class="fa fa-ellipsis-v" ></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-main dropdown-menu-right" aria-labelledby="dropdownRowBuilding">
              <li class="dropdown__item" data-toggle="modal" v-on:click="returnBack()"  v-if="user.role_id === 1 || user.role_id === 2">
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
              <div class="form-line" v-if="step === 1">
                <div class="cnf__input" v-if="(details.sms_verified === false || modal==='Add new')">
                  <label>SMS content (1 sms/160 characters)</label>
                  <textarea type="text" class="form-control cnt__textarea-lg" v-model="details.sms_script" :disabled="disabled"></textarea>
                  <span class="error__span" v-if="errors.sms_script">{{ errors.sms_script[0] }}</span>
                </div>
                <div class="cnf__input cursorDedault" v-if="details.sms_verified === true">
                  <label>SMS content</label>
                  <span class="form-control cnt__textarea-lg">{{ details.sms_script }}</span>
                </div>
              </div>
              <div class="form-line" v-if="step === 2">
                <div class="form-line" v-if="(details.call_verified === false || modal==='Add new')">
                  <div class="cnf__input ">
                    <label>Call content (1600/character)</label>
                    <ckeditor :editor="editor" v-model="details.call_script"  type="classic"></ckeditor>
                    <span class="error__span" v-if="errors.call_script">{{ errors.call_script[0] }}</span>
                  </div>
                </div>
                <div class="cnf__input-html" v-if="details.call_verified === true">
                  <label>Call content</label>
                  <div class="view-html" v-html="details.call_script"></div>
                </div>
              </div>
              <div class="form-line" v-if="step === 3">
                <div class="form-line" v-if="(details.call_verified === false || modal==='Add new')">
                  <div class="cnf__input col-md-12">
                    <label>Subject</label>
                    <input type="text" class="form-control" placeholder=" Enter subject" v-model="details.email_subject">
                    <span class="error__span" v-if="errors.email_subject">{{ errors.email_subject[0] }}</span>
                  </div>
                  <div class="cnf__input ">
                    <label>Email HTML/Text</label>
                    <ckeditor :editor="editor" v-model="details.email_html"  type="classic"></ckeditor>
                    <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
                  </div>
                </div>
                <div class="cnf__input col-md-12" v-if="details.call_verified === true">
                  <label>Subject</label>
                  <span class="form-control cursorDedault">{{details.email_subject}}</span>
                </div>
                <div class="cnf__input-html" v-if="details.call_verified === true">
                  <label>Email content </label>
                  <div class="view-html" v-html="details.email_html"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id !== 4">
              <button class="btn btn-primary" @click="step++" v-if="step !== 3">Next</button>
              <button class="btn btn-primary" :disabled="showLoading" @click="save(details, null)" v-if="step === 3">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="modal-sms" v-if="showModalSMS">
      <div class="modal-mask ">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header-customize">
              <span :class="{'modal-title': true, 'text-success': details.sms_verified, 'text-danger': !details.sms_verified}">SMS</span>
              <div class="modal-close" @click="showModalSMS = false, changeAssetControl(true, false, false)"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-sms :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-sms>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id !== 4">
              <button class="btn btn-success" @click="approve(details,'sms')" v-if="cCAsset.btn_a">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button :class="{'btn': true, 'btn-info': true, 'btn-left': (cCAsset.btn_a)}" @click="changeAssetControl(true, false, false)" v-if="cCAsset.btn_c">Change</button>
              <button class="btn btn-primary" @click="save(details, 'sms')" v-if="cCAsset.btn_s">
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
          <div class="modal-container modal-container_lg">
            <div class="modal-header-customize ">
              <span :class="{'modal-title': true, 'text-success': details.call_verified, 'text-danger': !details.call_verified}">Call</span>
              <div class="modal-close" @click="showModalCall = false, changeAssetControl(true, false, false)"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-call :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-call>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id !== 4">
              <button class="btn btn-success" @click="approve(details,'call')" v-if="cCAsset.btn_a">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button :class="{'btn': true, 'btn-info': true, 'btn-left': (cCAsset.btn_a)}" @click="changeAssetControl(true, false, false)" v-if="cCAsset.btn_c">Change</button>
              <button class="btn btn-primary" @click="save(details, 'call')" v-if="cCAsset.btn_s">
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
              <span :class="{'modal-title': true, 'text-success': details.email_verified, 'text-danger': !details.email_verified}">Email</span>
              <div class="modal-close" @click="showModalEmail = false, changeAssetControl(true, false, false)"><i class="fa fa-times"></i></div>
            </div>
            <div class="modal-body-customize">
              <div class="container container_100">
                <campaign-details-email :details="details" :errors="errors" :disabled="disabled" :cCAsset="cCAsset"></campaign-details-email>
              </div>
            </div>
            <div class="modal-footer-customize" v-if="user.role_id !== 4">
              <button class="btn btn-success" @click="approve(details,'email')" v-if="cCAsset.btn_a">
                <i class="fa fa-refresh fa-spin" v-if="showLoading"></i> Approve
              </button>
              <button :class="{'btn': true, 'btn-info': true, 'btn-left': (cCAsset.btn_a)}" @click="changeAssetControl(true, false, false)" v-if="cCAsset.btn_c">Change</button>
              <button class="btn btn-primary" @click="save(details, 'email')" v-if="cCAsset.btn_s">
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
        client: {},
        brand: {},
        user: {},
        showModal: false,
        showModalSMS: false,
        showModalCall: false,
        showModalEmail: false,
        approveMode: true,
        showLoading: false,
        disabled: false,
        cCAsset: {
          btn_s: true,
          btn_c:  false,
          btn_a: false,
        },
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
      '$route': function () {
        if (this.$route.path === '/campaigns') {
          this.getAll()
        }
      },
    },
    mounted: function () {
      this.getUser()
      this.getAll()
    },
    methods: {
      getAll: function () {
        if(this.$route.name === 'clients-campaigns' ) {
          this.getClientDetails(this.$route.params.clientId)
          Http.get(`/campaigns/clients/`+ this.$route.params.clientId + '?include=client,brand')
            .then(response => {
              this.campaigns = response.data
            })
        } else if(this.$route.name === 'brands-campaigns' ) {
          this.getBrandDetails(this.$route.params.brandId)
          Http.get(`/campaigns/brands/`+ this.$route.params.brandId + '?include=client,brand')
            .then(response => {
              this.campaigns = response.data
            })
        } else {
          Http.get(`/campaigns?include=client,brand`)
            .then(response => {
              this.campaigns = response.data
            })
        }
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
      save: function (data ,asset) {
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

              if (asset === 'sms') {
                if(vm.details.sms_verified) {
                  vm.changeAssetControl(false, true, false)
                } else {
                  vm.changeAssetControl(false, true, true)
                }
              } else if (asset === 'call') {
                if(vm.details.call_verified && asset === 'call') {
                  vm.changeAssetControl(false, true, false)
                } else {
                  vm.changeAssetControl(false, true, true)
                }
              } else if (asset === 'email') {
                if(vm.details.email_verified && asset === 'email') {
                  vm.changeAssetControl(false, true, false)
                } else {
                  vm.changeAssetControl(false, true, true)
                }
              }
              alert.success()
            })
            .catch(e => {
              vm.showLoading = false
              vm.errors = e.response.data.errors
              vm.changeAssetControl(true, false, false)
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
            this.changeAssetControl(false, true, false)
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
      },
      changeAssetControl: function (s,c,a) {
        var vm = this
        vm.cCAsset.btn_s = s
        vm.cCAsset.btn_c = c
        vm.cCAsset.btn_a = a
        vm.disabled = c


      },
      modalAsset :function (asset, verified) {
        var vm = this
        if(asset === 'sms' || asset === 'call' || asset === 'email') {
          if(verified === true) {
            this.changeAssetControl(false, true, false)
          } else {
            this.changeAssetControl(true, false, false)
          }
        }
      },
      openModal: function (campaignID, asset) {
        this.getDetails(campaignID)
        if(asset === 'sms') {
          this.showModalSMS = true
        } else if (asset === 'call') {
          this.showModalCall = true
        } else if (asset === 'email'){
          this.showModalEmail = true
        }
      },
      getClientDetails: function (clientID) {
        this.errors = {}
        Http.get(`/clients/` + clientID)
          .then(response => {
            this.client = response.data
          })
          .catch(e => {
          })
      },
      getBrandDetails: function (brandID) {
        this.errors = {}
        Http.get(`/brands/` + brandID)
          .then(response => {
            this.brand = response.data
          })
          .catch(e => {
          })
      },
      getUser: function () {
        Http.get(`auth/details`)
          .then(response => {
            this.user = response.data
            if (response.data.role_id === 4) {
              this.changeAssetControl(false,false,false)
            }
          })
      }
    }
  }
</script>
