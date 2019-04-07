<template name="modal" v-if="showModal">
  <div class="form-line">
    <div class="cnf__input col-md-12">
      <label>Title</label>
      <input type="text" class="form-control" placeholder=" Enter title" v-model="details.title">
      <span class="error__span" v-if="errors.title">{{ errors.title[0] }}</span>
    </div>
    <div class="cnf__input col-md-6">
      <label>Client</label>
      <treeselect :options="clients" placeholder=" Choose client" :normalizer="normalizerName" v-model="details.client_id">
        <label slot="option-label" slot-scope="{ node }">
          {{ node.raw.name }}
        </label>
      </treeselect>
      <span class="error__span" v-if="errors.client_id">{{ errors.client_id[0] }}</span>
    </div>
    <div class="cnf__input col-md-6">
      <label>Brand</label>
      <treeselect :options="brands" placeholder=" Choose brand" :normalizer="normalizerName" v-model="details.brand_id">
        <label slot="option-label" slot-scope="{ node }">
          {{ node.raw.name }}
        </label>
      </treeselect>
      <span class="error__span" v-if="errors.brand_id">{{ errors.brand_id[0] }}</span>
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
  props:['details','errors'],
  components: {
    Treeselect
  },
  data () {
    return {
      clients: [],
      brands: [],
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
    this.fetchClients()
    this.fetchBrands()
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
          this.brands = response.data
        })
    },
  }
}
</script>
