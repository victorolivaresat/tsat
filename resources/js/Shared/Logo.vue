<template>
  <img :src="getImageUrl()" class="block w-200"/>
</template>

<script>

import logo from '@/assets/images/logo.png'

export default {
  methods: {
    getImageUrl() {
      return logo
    }
  }
};
</script>

