<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User List
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <ul class="p-8">
            <li v-for="user in users" :key="user.id">
              {{ user.id }} - {{ user.name }} - {{ user.email }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout";

export default {
  components: {
    AppLayout,
  },
  props: {
    users: {
      type: Array,
    },
  },
};
</script>
