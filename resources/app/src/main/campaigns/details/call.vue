<template>
  <div class="html_text--details">
    <div class="form-line">
      <div class="cnf__input ">
        <label>Call HTML/Text</label>
        <textarea type="text" class="form-control cnt__textarea-lg" v-model="callHTML"></textarea>
        <span class="error__span" v-if="errors.callHTML">{{ errors.call_html[0] }}</span>
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

  data () {
    return {
      details: {},
      errors: {},
      callHTML: null
    }
  },
  computed: {
  },
  watch: {
    callHTML: function () {
      this.details.call_html = this.callHTML
    }
  },
  mounted: function () {
  },
  methods: {
  }
}
</script>


