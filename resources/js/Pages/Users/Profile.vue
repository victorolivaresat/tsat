<template>
  <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow">

    <div class="flex flex-col items-center pb-10">
      <img class="w-24 h-24 my-6 rounded-full shadow-lg" src="https://picsum.photos/200" alt="Profile image" />
      <h5 class="mb-1 text-xl font-medium text-gray-900">{{ auth.user.first_name }} {{
        auth.user.last_name }}</h5>
      <span class="text-sm text-gray-500 ">{{ auth.user.email }}</span>
      <span class="text-sm text-gray-500 ">{{ auth.user.roles.join(', ') }}</span>
      <div class="flex mt-4 md:mt-6">
        <a href="#"
          class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg">
          Apuesta Total
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'

export default {
  components: {
    Head
  },
  layout: Layout,
  props: {
    auth: Object
  }
}
</script>

<style scoped>
.min-h-screen {
  min-height: 100vh;
}
</style>
