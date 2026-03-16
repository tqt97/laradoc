<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">
            {{ __('Roles & Permissions Management') }}
        </h1>
    </x-slot>

    <div class="prose dark:prose-invert max-w-none" x-data="{ 
        activeTab: 'roles', 
        showRoleModal: false, 
        editingRole: null, 
        roleName: '', 
        selectedPermissions: [],
        showPermissionModal: false,
        permissionName: '',
        showUserModal: false,
        editingUser: null,
        selectedRoles: [],
        openEditRole(role) {
            this.editingRole = role;
            this.roleName = role.name;
            this.selectedPermissions = role.permissions.map(p => p.name);
            this.showRoleModal = true;
        },
        resetRoleModal() {
            this.editingRole = null;
            this.roleName = '';
            this.selectedPermissions = [];
            this.showRoleModal = false;
        },
        openUserModal(user) {
            this.editingUser = user;
            this.selectedRoles = user.roles.map(r => r.name);
            this.showUserModal = true;
        },
        resetUserModal() {
            this.editingUser = null;
            this.selectedRoles = [];
            this.showUserModal = false;
        }
    }">
        <!-- Tabs -->
        <div class="flex border-b border-zinc-200 dark:border-zinc-700 mb-6">
            <button @click="activeTab = 'roles'" :class="{'border-emerald-500 text-emerald-600': activeTab === 'roles', 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300': activeTab !== 'roles'}" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition hover:cursor-pointer">
                Roles
            </button>
            <button @click="activeTab = 'permissions'" :class="{'border-emerald-500 text-emerald-600': activeTab === 'permissions', 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300': activeTab !== 'permissions'}" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition hover:cursor-pointer">
                Permissions
            </button>
            <button @click="activeTab = 'users'" :class="{'border-emerald-500 text-emerald-600': activeTab === 'users', 'border-transparent text-zinc-500 hover:text-zinc-700 hover:border-zinc-300': activeTab !== 'users'}" class="py-4 px-6 border-b-2 font-medium text-sm focus:outline-none transition hover:cursor-pointer">
                User Roles
            </button>
        </div>

        <!-- Roles Section -->
        <div x-show="activeTab === 'roles'" x-cloak>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">Roles</h3>
                <button @click="resetRoleModal(); showRoleModal = true" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition hover:cursor-pointer">
                    Add Role
                </button>
            </div>

            <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $role->name }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($role->permissions as $permission)
                                    <span class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 rounded text-xs">{{ $permission->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click="openEditRole(@js($role))" class="text-emerald-600 hover:text-emerald-900 mr-3 hover:cursor-pointer">Edit</button>
                                @if($role->name !== 'super-admin')
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 hover:cursor-pointer">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permissions Section -->
        <div x-show="activeTab === 'permissions'" x-cloak>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">Permissions</h3>
                <button @click="showPermissionModal = true" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition hover:cursor-pointer">
                    Add Permission
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($permissions as $permission)
                <div class="p-3 border border-zinc-200 dark:border-zinc-700 rounded-lg flex justify-between items-center">
                    <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $permission->name }}</span>
                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 hover:cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Users Section -->
        <div x-show="activeTab === 'users'" x-cloak>
            <h3 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200 mb-4">Assign Roles to Users</h3>
            <div class="overflow-x-auto border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Roles</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                    <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-300 rounded text-xs">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click="openUserModal(@js($user))" class="text-emerald-600 hover:text-emerald-900 hover:cursor-pointer">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Role Modal -->
        <template x-teleport="body">
            <div x-show="showUserModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="resetUserModal()">
                        <div class="absolute inset-0 bg-black/75"></div>
                    </div>
                    <div class="relative z-50 inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form x-show="editingUser" :action="'{{ url('roles/users') }}/' + editingUser.id" method="POST">
                            @csrf
                            <div class="bg-white dark:bg-zinc-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Edit Roles for <span x-text="editingUser ? editingUser.name : ''"></span></h3>
                                <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                                    @foreach($roles as $role)
                                    <label class="inline-flex items-center hover:cursor-pointer">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" x-model="selectedRoles" class="rounded border-zinc-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $role->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-zinc-50 dark:bg-zinc-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm hover:cursor-pointer">
                                    Save
                                </button>
                                <button type="button" @click="resetUserModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-zinc-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-zinc-700 hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm hover:cursor-pointer">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
        
        <!-- Role Modal -->
        <template x-teleport="body">
            <div x-show="showRoleModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="resetRoleModal()">
                        <div class="absolute inset-0 bg-black/75"></div>
                    </div>
                    <div class="relative z-50 inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form :action="editingRole ? '{{ url('roles') }}/' + editingRole.id : '{{ url('roles') }}'" method="POST">
                            @csrf
                            <template x-if="editingRole">
                                <input type="hidden" name="_method" value="PUT">
                            </template>
                            
                            <div class="bg-white dark:bg-zinc-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4" x-text="editingRole ? 'Edit Role' : 'Add Role'"></h3>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Role Name</label>
                                    <input type="text" name="name" x-model="roleName" class="mt-1 block w-full rounded-md border-zinc-300 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Permissions</label>
                                    <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                                        @foreach($permissions as $permission)
                                        <label class="inline-flex items-center hover:cursor-pointer">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" x-model="selectedPermissions" class="rounded border-zinc-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $permission->name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="bg-zinc-50 dark:bg-zinc-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm hover:cursor-pointer">
                                    Save
                                </button>
                                <button type="button" @click="resetRoleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-zinc-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-zinc-700 hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm hover:cursor-pointer">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        <!-- Permission Modal -->
        <template x-teleport="body">
            <div x-show="showPermissionModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showPermissionModal = false">
                        <div class="absolute inset-0 bg-black/75"></div>
                    </div>
                    <div class="relative z-50 inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf
                            <div class="bg-white dark:bg-zinc-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Add Permission</h3>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Permission Name</label>
                                    <input type="text" name="name" x-model="permissionName" class="mt-1 block w-full rounded-md border-zinc-300 dark:bg-zinc-800 dark:text-zinc-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required>
                                </div>
                            </div>
                            <div class="bg-zinc-50 dark:bg-zinc-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm hover:cursor-pointer">
                                    Save
                                </button>
                                <button type="button" @click="showPermissionModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-zinc-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-zinc-700 hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm hover:cursor-pointer">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
