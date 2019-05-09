<template>
  <div>
    <h1>{{ title }}</h1>
    <button v-on:click="navigate('BuildForms')" style="margin-bottom:20px; width:100px; height:30px;">ADD A FORM</button>
    <template v-if="forms.length > 0">
        <table style="width:100%" border="1">
          <tr>
            <th>Name</th>
            <th>Created on</th>
            <th>Actions</th>
          </tr>
          <template v-for="(form, index) in forms">
            <tr>
              <td>{{form.name}}</td>
              <td>{{form.created_at}}</td>
              <td>
                <button v-on:click="navigate('SubmitForms', form.id)">View/Submit</button>	&nbsp;
                <button v-on:click="deleteForm(form.id)">Delete</button>
              </td>
            </tr>
          </template>
        </table>
    </template>
    <template v-else>
        <h3>No forms have been created. Add some!</h3>
    </template>
  </div>
</template>

<script>

import axios from 'axios';

export default {

  data () {
    return {
      title: 'Welcome to the survey creator app',
      forms : [] // placeholder data to store the forms
    }
  },

  created () {
    // upon the component is created, make an api to the server get the list of forms
    this.getForms();
  },

  methods: {
    navigate(componentName, formId = null) {
      if (formId == null) {
        this.$router.push({ name : componentName })
      } else {
        this.$router.push({ name : componentName, params: {formId: formId} })
      }
    },

    getForms() {
      axios.get('http://api.elmozaw-survey.test/api/forms', {}).then(response => {
        // forms data get responded, so set the return data to the variable
        this.forms = response.data;
      }).catch((e) => {
        // should catch the error here and display graceful message to user
        alert('Something went wrong!');
      })
    },

    deleteForm(formId) {
      // make api request to delete the form
       axios.delete('http://api.elmozaw-survey.test/api/forms/' + formId, {
       }).then(response => {
        // successfully deleted, make an request to server to get updated list of forms so that our component in FE is up to date.
        this.getForms();
        alert('Successfully deleted!');

      }).catch(e => {
         // should catch the error here and display graceful message to user
         alert('Something went wrong!');
      })
    }
  }

}

</script>

<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
