<template>
  <div id="app">

    <div>
      <img width="100px"  src="./assets/elmo.png">
    </div>
    <div>
      <router-link
        :to="{ name: 'Home' }"
        tag="a"> HOME
      </router-link>
   </div>

    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    /*text-align: center;*/
    color: #2c3e50;
    margin-top: 50px;
  }

  .label-line {
    margin-top:20px;
  }

  .input-text {
    width:300px;
    padding:10px;
  }

  .textarea {
    width:300px;
    padding:10px;
    height:200px;
  }
</style>
