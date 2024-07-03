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

    <!-- Notifications with Submenu -->
    <div class="mb-4">
      <div @click="toggleSubMenu('notifications')" class="group flex items-center py-3 cursor-pointer">
        <PhBellSimple class="mr-2 w-4 h-4" :class="isUrl('notifications') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('notifications') || isUrl('system-data') || isUrl('transactions') ? 'text-white' : 'text-indigo-300 group-hover:text-white'" class="flex">
          Notifications
          <AkChevronDownSmall class="ml-1 w-4 h-3" :class="subMenus.notifications ? 'transform rotate-180' : ''" />
        </div>
      </div>
      <div v-if="subMenus.notifications" class="pl-6">
        <Link class="group flex items-center py-2" href="/notifications"> 
          <div :class="isUrl('notifications') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
            Dashboard
          </div>
        </Link>
        <Link class="group flex items-center py-2" href="/system-data">
          <div :class="isUrl('system-data') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
            Data Load
          </div>
        </Link>
        <Link class="group flex items-center py-2" href="/transactions/system">
          <div :class="isUrl('transactions/system') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">
            Transactions
          </div>
        </Link>
      </div>
    </div>
    
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

import { AkChevronDownSmall } from '@kalimahapps/vue-icons';
import { PhBellSimple } from '@kalimahapps/vue-icons';
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'

export default {
  components: {
    Icon,
    Link,
    PhBellSimple,
    AkChevronDownSmall
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
