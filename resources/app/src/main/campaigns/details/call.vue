<template>
  <div class="html_text--details">
    <div class="form-line">
      <div class="cnf__input ">
        <label>Call HTML/Text</label>
        <textarea type="text" class="form-control cnt__textarea-lg" v-model="callHTML" :disabled="disabled"></textarea>
        <span class="error__span" v-if="errors.call_script">{{ errors.call_script[0] }}</span>
      </div>
    </div>
    <div class="cnf__input-html" v-if="callHTML !== null && callHTML !== ''">
       <label>Call content (1500 characters)</label>
       <div class="view-html" v-html="callHTML"></div>
     </div>
  </div>
</template>

<script>
import {Http} from '@/helpers/http-helper'

export default{
  props:['details','errors','disabled'],

  data () {
    return {
      callHTML: null
    }
  },
  computed: {
    callSync: function () {
      return this.details.call_script
    }
  },
  watch: {
    callHTML: function () {
      this.details.call_script = this.callHTML
    },
    callSync: function () {
      this.callHTML = this.callSync
    }
  },
  mounted: function () {
  },
  methods: {
  }
}
</script>


