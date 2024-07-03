<template>
  <PermissionCheck :permission="'users.index'">
    <Menu />
    <div class="flex items-center justify-between my-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block mt-4 text-gray-700">Status:</label>
        <select v-model="form.status" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="1">Validated</option>
          <option value="0">No Validated</option>
        </select>
        <label class="block mt-4 text-gray-700">Start Date:</label>
        <text-input v-model="form.start_date" type="date" class="block mt-1 w-full" />
        <label class="block mt-4 text-gray-700">End Date:</label>
        <text-input v-model="form.end_date" type="date" class="block mt-1 w-full" />
        <div class="flex flex-col md:flex-row md:space-x-4 mt-4">
          <div class="w-full md:w-2/3">
            <label class="block text-gray-700">Amount:</label>
            <text-input v-model="form.amount" type="number" class="block mt-1 w-full" />
          </div>
          <div class="w-full md:w-1/3 mt-4 md:mt-0">
            <label class="block text-gray-700">Operator:</label>
            <select v-model="form.amount_operator" class="form-select mt-1 w-full">
              <option :value="null" />
              <option value="equal">=</option>
              <option value="greater">&gt;</option>
              <option value="less">&lt;</option>
            </select>
          </div>
        </div>
      </search-filter>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6"></th>
          <th class="pb-4 pt-6 px-6">Beneficiary</th>
          <th class="pb-4 pt-6 px-6">Operation Number</th>
          <th class="pb-4 pt-6 px-6">Account</th>
          <th class="pb-4 pt-6 px-6 ">Amount</th>
          <th class="pb-4 pt-6 px-6">Date Time</th>
          <th class="pb-4 pt-6 px-6">Status</th>
          <th class="pb-4 pt-6 px-6">Created</th>
        </tr>
        <tr v-for="transaction in bcp.data" :key="transaction.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t px-6 py-3 text-indigo-600"><GlDotGrid/></td>
          <td class="border-t px-6 py-3 text-orange-500">{{ transaction.beneficiary }}</td>
          <td class="border-t px-6 py-3">{{ transaction.operation_number }}</td>
          <td class="border-t px-6 py-3">{{ transaction.account_destination }}</td>
          <td class="border-t px-6 py-3 text-blue-600">{{ transaction.amount }}</td>
          <td class="border-t px-6 py-3">{{ transaction.date_time }}</td>
          <td :class="['border-t px-6 py-3', transaction.status ? 'text-green-600' : 'text-red-600']">
            <span class="inline bg-slate-100 rounded-lg px-3 py-1">
              {{ transaction.status ? 'Validated' : 'Not validated' }}
            </span>
          </td>
          <td class="border-t px-6 py-3">{{ transaction.created_at }}</td>
        </tr>
        <tr v-if="bcp.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="8">No transactions found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="bcp.links" />
  </PermissionCheck>
</template>

<script>
import { ref } from 'vue'
import PermissionCheck from '@/Shared/PermissionCheck.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'
import { GlDotGrid } from '@kalimahapps/vue-icons'
import Pagination from '@/Shared/Pagination.vue'
import TextInput from '@/Shared/TextInput.vue'
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import mapValues from 'lodash/mapValues'
import throttle from 'lodash/throttle'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Menu from './Menu.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    Menu,
    TextInput,
    GlDotGrid,
    Pagination,
    SearchFilter,
    PermissionCheck,
  },
  layout: Layout,
  props: {
    filters: Object,
    bcp: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        status: this.filters.status,
        start_date: this.filters.start_date,
        end_date: this.filters.end_date,
        amount: this.filters.amount,
        amount_operator: this.filters.amount_operator,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/transactions/bcp', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
