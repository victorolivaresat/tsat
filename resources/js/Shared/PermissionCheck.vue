<template>
    <div v-if="hasPermission">
        <slot></slot>
    </div>
    <div v-else>
        <AccessDenied />
    </div>
</template>

<script>
import AccessDenied from '@/Shared/AccessDenied.vue'

export default {
    components: {
        AccessDenied
    },
    props: {
        permission: {
            type: String,
            required: true
        }
    },
    computed: {
        hasPermission() {
            return this.$page.props.auth.user.permissions.includes(this.permission);
        }
    }
}
</script>