<template>
    <PermissionCheck :permission="'roles.edit'">
        <Head :title="'Edit Role ' + role.name" />
        <h1 class="mb-8 text-3xl font-bold">
            <Link class="text-indigo-400 hover:text-indigo-600" href="/roles">Roles</Link>
            <span class="text-indigo-400 font-medium">/</span>
            {{ role.name }}
        </h1>
        <form @submit.prevent="updateRole" class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-white rounded-md shadow md:col-span-1">
                <div class="flex flex-wrap -mb-8 -mr-6 px-8 py-10">
                    <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
                    <textarea-input v-model="form.slug" :error="form.errors.slug" rows="4" class="pb-8 pr-6 w-full lg:w-1/2" label="Slug" />
                    <div class="flex mr-6 p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 w-full" role="alert">
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Permissions Recommendations:</span>
                            <ul class="mt-1.5 list-disc list-inside">
                                <li>Assign permissions based on the principle of least privilege.</li>
                                <li>Regularly review and audit role permissions.</li>
                                <li>Group similar permissions to simplify role management.</li>
                                <li>Avoid assigning critical permissions to multiple roles.</li>
                                <li>Ensure role-based access controls are aligned with business needs.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-8 rounded-md shadow md:col-span-1">
                <h3 class="text-lg text-indigo-400 font-bold mb-2">Modules / Permissions</h3>
                <div class="border-b border-gray-200 mb-4">
                    <nav class="-mb-px flex space-x-8">
                        <button v-for="(module, index) in filteredModules" :key="module.id"
                            @click.prevent="currentTab = index"
                            :class="{ 'border-indigo-500 text-indigo-600': currentTab === index, 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== index }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ module.name }}
                        </button>
                    </nav>
                </div>
                <div v-for="(module, index) in filteredModules" :key="module.id" v-show="currentTab === index">
                    <div v-if="module.permissions.length > 0" class="bg-gray-50 mt-2 space-y-4 p-4 rounded-md shadow">
                        <div class="flex items-center">
                            <input type="checkbox" @change="toggleAllPermissions(module.id)"
                                :checked="areAllPermissionsSelected(module.permissions)" class="mr-2 w-4 h-4 accent-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                            <label class="flex items-center ms-2 text-sm font-medium text-gray-900">
                                Select all
                            </label>
                        </div>
                        <div v-for="permission in module.permissions" :key="permission.id" class="flex items-center mb-4">
                            <input type="checkbox" :value="permission.id" v-model="role.permissions"  class="mr-2 w-4 h-4 accent-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2" :class="{ 'border-red-500': form.errors.permissions }">
                            <label class="ms-2 text-sm font-medium text-gray-900" >{{ permission.name }}</label>
                        </div>
                        <p v-if="form.errors.permissions" class="text-red-500">{{ form.errors.permissions }}</p>
                    </div>
                    <div v-else class="pl-4 mt-2">
                        <p class="text-gray-500 italic">There are no permissions available for this module.</p>
                    </div>
                </div>

          

            </div>
            <div class="flex items-center justify-end border-t border-gray-100 md:col-span-2">
                <loading-button :loading="form.processing" class="btn-indigo" type="submit">Update Role</loading-button>
            </div>
        </form>
    </PermissionCheck>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Layout/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import TextareaInput from '@/Shared/TextareaInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import PermissionCheck from '@/Shared/PermissionCheck.vue'

export default {
    components: {
        Head,
        Link,
        TextInput,
        TextareaInput,
        LoadingButton,
        PermissionCheck
    },
    layout: Layout,
    props: {
        role: Object,
        modules: Object
    },
    data() {
        return {
            form: this.$inertia.form({
                _method: 'put',
                name: this.role.name,
                slug: this.role.slug,
                permissions: this.role.permissions
            }),
            currentTab: 0
        };
    },
    computed: {
        filteredModules() {
            return this.modules.filter(module => module.permissions.length > 0);
        }
    },
    methods: {
        updateRole() {
            console.log(this.form);
            this.form.post(`/roles/${this.role.id}`)
        },
        areAllPermissionsSelected(permissions) {
            this.form.permissions = this.role.permissions;
            console.log(this.form);
            return permissions.every(permission => this.role.permissions.includes(permission.id));
        },
        toggleAllPermissions(moduleId) {
            const module = this.modules.find(module => module.id === moduleId);
            const allSelected = this.areAllPermissionsSelected(module.permissions);

            if (allSelected) {
                this.role.permissions = this.role.permissions.filter(permissionId => !module.permissions.some(permission => permission.id === permissionId));
            } else {
                const modulePermissionIds = module.permissions.map(permission => permission.id);
                this.role.permissions = Array.from(new Set([...this.role.permissions, ...modulePermissionIds]));
            }
        }
    }
};
</script>

