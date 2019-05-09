<template>
  <div>
    <h1>{{ title }}</h1>
    <template v-if="formDetails.length > 0">
      <table style="width:100%; margin-bottom:50px;">
        <template v-for="(formDetail, index) in formDetails">
        <tr>
          <td>{{formDetail.label}}</td>
          <td>
              <template v-if="formDetail.type == 'text'">
                <input v-model="formDetail.value" type="text" style="width:50%">
              </template>
              <template v-else-if="formDetail.type == 'text_area'">
                <textarea v-model="formDetail.value" style="width:50%"></textarea>
              </template>
               <template v-else-if="formDetail.type == 'file'">
                <input v-on:change="uploadFile($event, index)" type="file" style="width:50%">
              </template>
          </td>
        </tr>
      </template>
      </table>
       <button style="width:100px; height:30px;" v-on:click="submitForm()">Submit</button>
    </template>
  </div>
</template>

<script>

import axios from 'axios';

export default {

  data () {
    return {
      title: 'Just submit it!',
      formId: null,
      file: null,
      formDetails: []
    }
  },

  created () {
    // first get the parameter i.e form ID from URL
    this.formId = this.$route.params.formId;
    // then make an API call to get the details of the form
    this.getFormDetails();
  },

  methods: {

    getFormDetails() {
      // make API request to get details of spcific form
      axios.get('http://api.elmozaw-survey.test/api/forms/' + this.formId, {}).then(response => {
        // forms details data get responded, so set the return data to the variable to be used in componenet template
        this.formDetails = response.data;

      }).catch((e) => {
        // should catch the error here and display graceful message to user
        alert('Something went wrong!');
      })
    },

    submitForm() {
      // prepare data to post to server
      let formData = new FormData();
      formData.append('data', JSON.stringify(this.formDetails));
      // make an API request to submit the form to server and store to DB
      axios.post('http://api.elmozaw-survey.test/api/forms/' + this.formId, formData, {
      }).then(response => {
        alert('Successfully submitted!');
      }).catch(e => {
        // should catch the error here and display graceful message to user
        alert('Something went wrong!');
      })
    },

    // we are passing index here so that, we can get the details
    uploadFile($event, index) {
      let file = $event.target.files[0] || $event.dataTransfer.files[0];
      let formData = new FormData();
      formData.append('file', file);
      // whenever file is uploaded, we will trigger api call to upload it to the server
      axios.post('http://api.elmozaw-survey.test/api/upload/' + this.formDetails[index]['id'], formData, {
      }).then(response => {


      }).catch(e => {
        // should catch the error here and display graceful message to user
        alert('Something went wrong!');
      })
    }
  }

}
</script>

<style scoped>

</style>
