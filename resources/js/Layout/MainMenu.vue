<template>
  <div>
    <!-- Dashboard -->
    <div class="mb-1">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>

    <!-- Roles -->
    <div class="mb-1">
      <Link class="group flex items-center py-3" href="/roles">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('roles') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('roles') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Roles</div>
      </Link>
    </div>

    <!-- Organizations with Submenu -->
    <!-- <div class="mb-4">
      <div @click="toggleSubMenu('organizations')" class="group flex items-center py-3 cursor-pointer">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'" class="flex">
          Organizations
          <ChevronDownIcon class="ml-1 w-4 h-4" :class="subMenus.organizations ? 'transform rotate-180' : ''" />
        </div>
      </div>
      <div v-if="subMenus.organizations" class="pl-6">
        <Link class="group flex items-center py-2" href="/organizations">
          <icon name="sub1-icon" class="mr-2 w-4 h-4" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Submenu 1</div>
        </Link>
        <Link class="group flex items-center py-2" href="/organizations/sub2">
          <icon name="sub2-icon" class="mr-2 w-4 h-4" :class="isUrl('organizations/sub2') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('organizations/sub2') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Submenu 2</div>
        </Link>
      </div>
    </div> -->
    
    <!-- Contacts -->
    <!-- <div class="mb-4">
      <Link class="group flex items-center py-3" href="/contacts">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>
      </Link>
    </div> -->

    <!-- Reports -->
    <!-- <div class="mb-4">
      <Link class="group flex items-center py-3" href="/reports">
        <icon name="printer" class="mr-2 w-4 h-4" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>
      </Link>
    </div> -->
  </div>
</template>


<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import { ChevronDownIcon } from '@heroicons/vue/24/outline'

export default {
  components: {
    Icon,
    Link,
    ChevronDownIcon
  },
  data() {
    return {
      subMenus: {
        organizations: false,
      },
    };
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.slice(1);
      if (urls[0] === '') {
        return currentUrl === '';
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length;
    },
    toggleSubMenu(menu) {
      this.subMenus[menu] = !this.subMenus[menu];
    },
  },
}
</script>
