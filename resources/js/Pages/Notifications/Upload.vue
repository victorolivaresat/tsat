<template>
  <div>

    <Head title="Data Load" />
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- First Column -->
      <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8">
        <h5 class="mb-2 text-3xl font-bold text-gray-900">Data Upload</h5>
        <p class="mb-5 text-base text-gray-500 sm:text-lg">Please upload a file in .xlsx format.</p>
        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
          <div id="dropzone"
            class="w-full py-9 bg-gray-50 rounded-2xl border border-gray-300 gap-3 grid border-dashed relative"
            @dragover.prevent="handleDragOver" @dragleave.prevent="handleDragLeave" @drop.prevent="handleDrop">
            <div class="grid gap-1">
              <svg class="mx-auto w-10 h-10 text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                  d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm2-2a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm-6 4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-6Zm8 1v1h-2v-1h2Zm0 3h-2v1h2v-1Zm-4-3v1H9v-1h2Zm0 3H9v1h2v-1Z"
                  clip-rule="evenodd" />
              </svg>
              <h2 class="text-center text-gray-400 text-xs leading-4 mt-4">XLSX, smaller than 2MB</h2>
            </div>
            <div class="grid gap-2">
              <h4 class="text-center text-gray-900 text-sm font-medium leading-snug mb-5">Drag and Drop your file here
                or
              </h4>
              <div class="flex items-center justify-center">
                <label>
                  <input type="file" class="hidden" @change="handleFileChange">
                  <div
                    class="w-28 h-9 px-2 flex flex-col bg-indigo-600 rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                    Choose File
                  </div>
                </label>
              </div>
            </div>
            <div class="p-4">
              <div v-if="fileInfo" class=" bg-white p-6 rounded-lg shadow">
                <p class="text-sm text-green-500 truncate">File: {{ fileInfo.name }} ({{ formatBytes(fileInfo.size) }})
                </p>
                <button @click="uploadFile" :disabled="isUploading || !file"
                  class=" w-1/2 mt-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <span v-if="isUploading">Uploading...</span>
                  <span v-else>Upload File</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        <p v-if="message" class="mt-4" :class="messageClass">
          {{ message }}
        </p>
      </div>

      <!-- Second Column -->
      <div v-if="transactions" class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
        <div class="flex items-center justify-between mb-4">
          <h5 class="text-xl font-bold leading-none text-gray-700">Transactions per Day (Last five)</h5>
          <a href="#" class="text-sm font-medium text-blue-600 hover:underline">
            View all
          </a>
        </div>
        <div class="flow-root">
          <ul role="list" class="divide-y divide-gray-200">
            <li v-for="(details, date) in transactions" :key="date" class="py-3 sm:py-4">
              <div class="flex items-center">
                <div class="bolder font-medium text-gray-50 p-6 bg-indigo-600 rounded-lg">
                  {{ details.payment_date }}
                </div>
                <div class="flex-1 min-w-0 ms-4">
                  <p class="text-sm font-medium text-blue-800 truncate">
                    <span v-for="(count, bank) in details.banks" :key="bank">
                      {{ bank }}: {{ count }}
                      <br>
                    </span>
                  </p>
                  <p class="text-sm text-gray-500 truncate">
                    [ Validated: {{ details.validated }} ] - [Not Validated: {{ details.not_validated }}]
                  </p>
                </div>
                <div class="inline-flex items-center text-base font-semibold text-green-500">
                  Total: {{ details.total }}
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import axios from 'axios'
import { ref, onMounted } from 'vue'

export default {
  components: {
    Head
  },
  setup() {
    const file = ref(null)
    const isUploading = ref(false)
    const message = ref('')
    const messageClass = ref('')
    const transactions = ref(null)
    const fileInfo = ref(null)

    function handleFileChange(event) {
      const selectedFile = event.target.files[0];
      if (selectedFile) {
        if (selectedFile.size > 2 * 1024 * 1024) {
          message.value = 'File size exceeds 2MB limit. Please select a smaller file.';
          messageClass.value = 'text-red-500';
          file.value = null;
          fileInfo.value = null;
        } else {
          file.value = selectedFile;
          updateFileInfo(selectedFile);
        }
      }
    }

    function updateFileInfo(selectedFile) {
      if (selectedFile) {
        fileInfo.value = {
          name: selectedFile.name,
          size: selectedFile.size
        }
      } else {
        fileInfo.value = null
      }
    }

    function handleDragOver(event) {
      event.preventDefault()
      event.target.classList.add('border-blue-600')
    }

    function handleDragLeave(event) {
      event.preventDefault()
      event.target.classList.remove('border-blue-600')
    }

    function handleDrop(event) {
      event.preventDefault()
      event.target.classList.remove('border-blue-600')
      const droppedFiles = event.dataTransfer.files
      if (droppedFiles.length > 0) {
        file.value = droppedFiles[0]
        updateFileInfo(droppedFiles[0])
      }
    }

    async function uploadFile() {
      if (!file.value) {
        message.value = 'Please select a file to upload.'
        messageClass.value = 'text-red-500'
        return
      }

      isUploading.value = true
      message.value = ''
      const formData = new FormData()
      formData.append('file', file.value)

      try {
        const response = await axios.post('/system-data/upload', formData)
        message.value = 'File uploaded successfully'
        messageClass.value = 'text-green-500'
        console.log(response.data)
        await fetchTransactions()
      } catch (error) {
        message.value = 'Error uploading file: ' + (error.response?.data?.message || error.message)
        messageClass.value = 'text-red-500'
      } finally {
        isUploading.value = false
        file.value = null
        fileInfo.value = null
      }
    }

    async function fetchTransactions() {
      try {
        const response = await axios.get('/system-data/transactions-per-day')
        transactions.value = response.data
      } catch (error) {
        console.error('Error fetching transactions:', error)
      }
    }

    onMounted(() => {
      fetchTransactions()
    })

    function formatBytes(bytes, decimals = 2) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    return {
      handleFileChange,
      handleDragOver,
      handleDragLeave,
      messageClass,
      transactions,
      isUploading,
      handleDrop,
      uploadFile,
      formatBytes,
      message,
      fileInfo,
      file,
    }
  },
  layout: Layout
}
</script>
