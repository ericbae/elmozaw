<template>
  <div>
    <h1>{{ title }}</h1>
    <template v-if="formId != null">
      <template v-if="addedElements.length > 0">
        <table style="width:100%" border="1">
          <tr>
            <th>Label</th>
            <th>Type</th>
          </tr>
          <template v-for="(addedElement, index) in addedElements">
            <tr>
              <td>{{addedElement.label}}</td>
              <td>{{addedElement.type}}</td>
            </tr>
          </template>
        </table>
    </template>
    <div style="margin-left:20px;">
      <div>
        <h3>Form name</h3>
        <input type="text" v-model="formName" class="input-text">
      </div>

      <br/>
      <div class="label-line">
        Label
      </div>

      <div class="">
        <input type="text" v-model="label" class="input-text">
      </div>

      <div class="label-line">
        Type
      </div>

      <div class="">
        <select class="select-standard"
          v-model="type">
          <option value="text">Text Field</option>
          <option value="text_area">Text Area</option>
          <option value="file">File</option>
        </select>
      </div>


      <div class="label-line">
        <button v-on:click="addElements()" style="margin-bottom:20px; width:100px; height:30px;">Add Elements</button>
      </div>
    </div>
    </template>
  </div>
</template>

<script>

import axios from 'axios';

export default {

  data () {
    return {
      title: 'Build awesome forms',
      addedElements: [],
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
        // populate the array with added elements so that we can display to the user
        this.addedElements.push({
          'label': this.label,
          'type': this.type
        });
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
