<template>
  <div class="email">
    <div class="html_text--details" v-if="user.role_id != 4">
      <div class="form-line" v-if="cCAsset.btn_s == true && details.email_verified == 0">
        <div class="cnf__input col-md-12">
          <label>Subject</label>
          <input type="text" class="form-control" placeholder=" Enter subject" v-model="details.email_subject">
          <span class="error__span" v-if="errors.email_subject">{{ errors.email_subject[0] }}</span>
        </div>
        <div class="cnf__input ">
          <div class="box__source">
            <button :class="{'btn_source-html': true, 'active': showSource}" @click="showSource = !showSource">Source</button>
          </div>
          <label>Email HTML/Text</label>
          <ckeditor :editor="editor" v-model="details.email_html"  type="classic"></ckeditor>
          <div class="email_html-code" v-if="showSource">{{details.email_html}}</div>
          <span class="error__span" v-if="errors.email_html">{{ errors.email_html[0] }}</span>
        </div>
      </div>
      <div class="form-line" v-if="cCAsset.btn_s == false || details.email_verified == 1">
        <div class="cnf__input col-md-12">
          <label>Subject</label>
          <span class="form-control cursorDedault">{{details.email_subject}}</span>
        </div>
        <div class="cnf__input-html">
          <label>Email content </label>
          <div class="view-html" v-html="details.email_html"></div>
        </div>
      </div>
    </div>
    <div class="html_text--details"  v-if="user.role_id == 4">
      <div class="cnf__input col-md-12">
        <label>Subject</label>
        <span class="form-control cursorDedault">{{details.email_subject}}</span>
      </div>
      <div class="cnf__input-html">
        <label>Email content </label>
        <div class="view-html" v-html="details.email_html"></div>
      </div>
    </div>
  </div>
</template>

<script>
  import {Http} from '@/helpers/http-helper'
  import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

  export default{
    props:['details', 'errors', 'cCAsset', 'step'],
    data () {
      return {
        editor: ClassicEditor,
        editorDisabled: true,
        user: {},
        showSource: false
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
