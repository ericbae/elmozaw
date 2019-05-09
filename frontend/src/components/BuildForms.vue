<template>
  <div>
    <h1>{{ title }}</h1>
    <template v-if="formId != null">
       <table>
          <tr>
           <td>Form name:</td>
           <td><input type="text" v-model="formName"></td>
         </tr>
         <tr>
           <td>Label</td>
           <td><input type="text" v-model="label"></td>
         </tr>
         <tr>
           <td>Type</td>
           <td>
              <select class="select-standard"
                v-model="type">
                <option value="text">Text Field</option>
                <option value="text_area">Text Area</option>
                <option value="file">File</option>
              </select>
           </td>
         </tr>
       </table>
       <button v-on:click="addElements()" style="margin-bottom:20px; width:100px; height:30px;">Add Elements</button>
    </template>
  </div>
</template>

<script>

import axios from 'axios';

export default {

  data () {
    return {
      title: 'Build awesome forms',
      formName: null,
      formId: null,
      label: null,
      type: null
    }
  },

  created () {
    // once the build form component has been created, MAKE an api call to create the new form in API and use that ID of form
    // to add associated elements to it
    axios.post('http://api.elmozaw-survey.test/api/build-forms/build', {}, {
    }).then(response => {
      this.formId = response.data;

    }).catch(e => {
      // should catch the error here and display graceful message to user
      alert('Something went wrong!');
    })
  },

  methods: {

    addElements() {
      // make a request to the API to add element to existing form
      axios.post('http://api.elmozaw-survey.test/api/build-forms/build/' + this.formId, {
        // data to be posted to the server
        formName: this.formName,
        label: this.label,
        type: this.type
      }, {
      }).then(response => {
        alert('Successfully added an element, keep adding!');
        // reset the 'label' and 'type' variable so that user can start from fresh before adding new elements
        this.label = null;
        this.type = null;
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
