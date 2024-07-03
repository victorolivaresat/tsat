<template>
    <div class="border-b-2 border-indigo-300 ">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
            <li class="me-2">
                <Link href="/transactions/system"
                    :class="['inline-flex items-center justify-center p-4 rounded-t-lg group',
                        isUrl('transactions/system') ? 'text-blue-50 border-blue-700 bg-indigo-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300']">
                System
                </Link>
            </li>
            <li class=" me-2">
                <Link href="/transactions/bcp"
                    :class="['inline-flex items-center justify-center p-4 rounded-t-lg group',
                        isUrl('transactions/bcp') ? 'text-blue-50 border-orange-700 bg-orange-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300']">
                BCP
                </Link>
            </li>
            <li class=" me-2">
                <Link href="/transactions/ibk"
                    :class="['inline-flex items-center justify-center p-4 rounded-t-lg group',
                        isUrl('transactions/ibk') ? 'text-blue-50 border-green-700 bg-green-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300']">
                IBK
                </Link>
            </li>
        </ul>
    </div>
</template>

<script>

import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.slice(1);
            if (urls[0] === '') {
                return currentUrl === '';
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length;
        },
    }
}


</script>