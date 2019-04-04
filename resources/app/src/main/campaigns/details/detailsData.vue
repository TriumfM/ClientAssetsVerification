<template name="modal" v-if="showModal">
  <div class="form-line">
    <div class="cnf__input col-md-12">
      <label>Title</label>
      <input type="text" class="form-control" placeholder=" Enter title" v-model="details.title">
      <span class="error__span" v-if="errors.title">{{ errors.title[0] }}</span>
    </div>
    <div class="cnf__input col-md-6">
      <label>Client</label>
      <treeselect :options="clients" placeholder=" Choose client" v-model="details.client_id">
        <label slot="option-label" slot-scope="{ node }">
          {{ node.raw }}
        </label>
      </treeselect>
      <span class="error__span" v-if="errors.role_id">{{ errors.role_id[0] }}</span>
    </div>
    <div class="cnf__input col-md-6">
      <label>Brand</label>
      <treeselect :options="clients" placeholder=" Choose brand" v-model="details.brand_id">
        <label slot="option-label" slot-scope="{ node }">
          {{ node.raw }}
        </label>
      </treeselect>
      <span class="error__span" v-if="errors.role_id">{{ errors.role_id[0] }}</span>
    </div>
    <div class="cnf__input ">
      <label>Description</label>
      <textarea type="text" class="form-control cnt__textarea-174" v-model="details.description"></textarea>
      <span class="error__span" v-if="errors.description">{{ errors.description[0] }}</span>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'

  import Treeselect from '@riophae/vue-treeselect'
  import '@riophae/vue-treeselect/dist/vue-treeselect.css'

  export default{

    components: {
      Treeselect
    },
    data () {
      return {
        clients: {},
        brands: {},
        details: {},
        errors: {}
      }
    },
    computed: {
    },
    watch: {
    },
    mounted: function () {
    },
    methods: {
      fetchClients: function () {
        Http.get(`/clients`)
          .then(response => {
            this.clients = response.data
          })
      },
      fetchBrands: function () {
        Http.get(`/brands`)
          .then(response => {
            this.clients = response.data
          })
      },
    }
  }
</script>
