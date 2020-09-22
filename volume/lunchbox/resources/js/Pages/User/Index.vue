<template>
  <div class="p-4 text-white">
    <h1 class="text-lg font-bold">ユーザー一覧</h1>
    <ul>
      <li v-for="user in users" :key="user.id">{{ user.id }} {{ user.name }}</li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    users: {
      type: Array,
    },
  },
};
</script>