<template>
  <div class="html_text--details">
    <div class="form-line">
      <div class="cnf__input col-md-12">
        <label>Subject</label>
        <input type="text" class="form-control" placeholder=" Enter subject" v-model="details.email_subject" :disabled="disabled">
        <span class="error__span" v-if="errors.email_subject">{{ errors.email_subject[0] }}</span>
      </div>
      <div class="cnf__input ">
        <label>Email HTML/Text</label>
        <textarea type="text" class="form-control cnt__textarea-233" v-model="emailHTML" :disabled="disabled"></textarea>
        <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
      </div>
    </div>
    <div class="cnf__input-html" v-if="emailHTML !== null && emailHTML !== ''">
      <label>Email content </label>
      <div class="view-html" v-html="emailHTML"></div>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'

  export default{
    props:['details','errors','disabled'],
    data () {
      return {
        emailHTML: null
      }
    },
    computed: {
      emailSync: function () {
        return this.details.email_html
      }
    },
    watch: {
      emailHTML: function () {
        this.details.email_html = this.emailHTML
      },
      emailSync: function () {
        this.emailHTML = this.emailSync
      }
    },
    mounted: function () {
      this.emailHTML=details.email_html
    },
    methods: {
    }
  }
</script>
