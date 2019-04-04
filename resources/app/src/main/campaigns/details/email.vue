<template>
  <div class="form-line">
    <div class="cnf__input col-md-12">
      <label>Subject</label>
      <input type="text" class="form-control" placeholder=" Enter subject" v-model="details.email_subject">
      <span class="error__span" v-if="errors.email_subject">{{ errors.email_subject[0] }}</span>
    </div>
    <div class="cnf__input ">
      <label>Email content</label>
      <textarea type="text" class="form-control cnt__textarea-233" v-model="details.email_html"></textarea>
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
