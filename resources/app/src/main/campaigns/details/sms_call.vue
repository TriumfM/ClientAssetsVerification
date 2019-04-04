<template>
  <div class="form-line">
    <div class="cnf__input ">
      <label>SMS content(160 characters)</label>
      <textarea type="text" class="form-control cnt__textarea" v-model="details.email_html"></textarea>
      <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
    </div>
    <div class="cnf__input ">
      <label>Call content(1500 characters)</label>
      <textarea type="text" class="form-control cnt__textarea-188" v-model="details.call"></textarea>
      <span class="error__span" v-if="errors.call">{{ errors.call[0] }}</span>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'

  export default{

    data () {
      return {
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
    }
  }
</script>
