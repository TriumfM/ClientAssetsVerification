<template>
  <div class="form-line">
    <div class="cnf__input ">
      <label>SMS content (1 sms/160 characters)</label>
      <textarea type="text" class="form-control cnt__textarea-lg" v-model="details.email_html"></textarea>
      <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
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
