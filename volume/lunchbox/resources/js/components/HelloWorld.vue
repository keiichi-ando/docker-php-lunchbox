<template>
  <div class="hello">
    <h1 class="title">{{ msg }}</h1>
    <h2 class="subtitle">{{ submsg }}</h2>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  props : {
      msg: String,
      submsg: String
  }
//   data() {
//     return {
//       msg: "Welcome to your Vue.js App",
//     };
//   },
};
</script>

<style scoped>
</style>