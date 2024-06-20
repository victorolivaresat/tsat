<template>
    <div :class="modelValue ? ' bg-green-500' : 'bg-gray-300'" @click="toggle" class="w-12 transition-all duration-300 h-6 flex items-center bg-gray-300 rounded-full p-1">
      <div :class="{'translate-x-6': modelValue}" class="w-4 h-4 transition-all duration-500 transform bg-white rounded-full shadow-md"></div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      modelValue: {
        type: Boolean,
        required: true
      }
    },
    methods: {
      toggle() {
        this.$emit('update:modelValue', !this.modelValue);
      }
    }
  }
  </script>
  