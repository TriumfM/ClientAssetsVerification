<template>
  <div class="form-line">
    <div class="cnf__input ">
      <label>SMS content (1 sms/160 characters)</label>
      <textarea type="text" class="form-control cnt__textarea-lg" v-model="details.sms_script" :disabled="disabled"></textarea>
      <span class="error__span" v-if="errors.sms_script">{{ errors.sms_script[0] }}</span>
    </div>
  </div>
</template>

<script>
import {Http} from '@/helpers/http-helper'

export default{
  props:['details','errors','disabled'],
  data () {
    return {
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
