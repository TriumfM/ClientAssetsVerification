<template>
  <div>
    <div class="html_text--details" v-if="user.role_id !== 4">
      <div class="form-line" v-if="cCAsset.btn_c === false || details.call_veridied === false">
        <div class="cnf__input ">
          <label>Call content (1600/character)</label>
          <ckeditor :editor="editor" v-model="details.call_script"  type="classic"></ckeditor>
          <span class="error__span" v-if="errors.call_script">{{ errors.call_script[0] }}</span>
        </div>
      </div>
      <div class="cnf__input-html" v-if="cCAsset.btn_c">
        <label>Call content</label>
        <div class="view-html" v-html="details.call_script"></div>
      </div>
    </div>
    <div class="html_text--details" v-if="user.role_id === 4">
      <div class="cnf__input-html" >
        <label>Call content</label>
        <div class="view-html" v-html="details.call_script"></div>
      </div>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

  export default{
    props:['details','errors', 'cCAsset', 'step'],
    components: {

    },
    data () {
      return {
        editor: ClassicEditor,
        editorDisabled: true,
        user: {}
      }
    },
    computed: function () {
    },
    watch: {
    },
    mounted: function () {
      this.getUser()
    },
    methods: {
      getUser: function () {
        Http.get(`auth/details`)
          .then(response => {
            this.user = response.data
          })
      }
    }
  }
</script>


