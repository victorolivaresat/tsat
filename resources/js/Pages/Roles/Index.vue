<template>
  <PermissionCheck :permission="'roles.index'">
    <Head title="Roles" />
    <h1 class="mb-8 text-3xl font-bold">Roles</h1>
    <div class="flex items-center justify-between mb-6">
      <text-input v-model="form.search" @reset="reset" class="mr-4 w-full max-w-md" label="Search" />
      <Link class="btn-indigo" href="/roles/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Role</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Slug</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Created</th>
        </tr>
        <tr v-for="role in roles.data" :key="role.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/roles/${role.id}/edit`">
              {{ role.name }}
              <icon v-if="role.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/roles/${role.id}/edit`" tabindex="-1">
                {{ role.slug }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/roles/${role.id}/edit`" tabindex="-1">
              {{ role.created_at }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/roles/${role.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="roles.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No roles found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="roles.links" />
  </PermissionCheck>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Layout from '@/Layout/Layout.vue'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'
import TextInput from '@/Shared/TextInput.vue'
import PermissionCheck from '@/Shared/PermissionCheck.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
    TextInput,
    PermissionCheck,
  },
  layout: Layout,
  props: {
    filters: Object,
    roles: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/roles', pickBy(this.form), { preserveState: true })
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