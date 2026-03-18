<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.features.index') }}" class="p-2 -ml-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                    Create Feature
                </h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 font-medium">
                    Define a new feature flag and its UI properties.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('admin.features.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="bg-white dark:bg-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 shadow-sm">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="size-2 rounded-full bg-primary-500"></span>
                    General Configuration
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <x-input-label for="key" value="Feature Key" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <x-text-input id="key" name="key" type="text" class="w-full" :value="old('key')" placeholder="e.g. newsletter" required />
                        <x-input-error :messages="$errors->get('key')" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="location" value="UI Location" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <x-text-input id="location" name="location" type="text" class="w-full" :value="old('location')" placeholder="e.g. header-left" />
                        <x-input-error :messages="$errors->get('location')" />
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <x-input-label for="description" value="Description" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <textarea id="description" name="description" rows="3" 
                            class="w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm"
                            placeholder="Briefly describe the purpose of this feature...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex items-center gap-8 md:col-span-2">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="enabled" value="1" class="sr-only peer" {{ old('enabled', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:width-5 after:transition-all dark:border-zinc-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-bold text-zinc-700 dark:text-zinc-300">Enabled</span>
                        </label>

                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="show" value="1" class="sr-only peer" {{ old('show') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:width-5 after:transition-all dark:border-zinc-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-bold text-zinc-700 dark:text-zinc-300">Show in Navigation</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 shadow-sm">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="size-2 rounded-full bg-pink-500"></span>
                    UI & Metadata
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <x-input-label for="ui_text" value="Display Text" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <x-text-input id="ui_text" name="ui[text]" type="text" class="w-full" :value="old('ui.text')" placeholder="e.g. Articles" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="ui_icon" value="Icon Component" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <x-text-input id="ui_icon" name="ui[icon]" type="text" class="w-full" :value="old('ui.icon')" placeholder="e.g. prezet.icon-article" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="ui_route" value="Route Name" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <select name="ui[route]" class="w-full rounded-2xl border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 text-zinc-900 dark:text-white focus:border-primary-500 focus:ring-primary-500 shadow-sm">
                            <option value="">Select Route</option>
                            @foreach ($routes as $route)
                                <option value="{{ $route }}" {{ old('ui.route') == $route ? 'selected' : '' }}>{{ $route }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="ui_route_active" value="Active Route Pattern" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <x-text-input id="ui_route_active" name="ui[route_active]" type="text" class="w-full" :value="old('ui.route_active')" placeholder="e.g. articles*" />
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <x-input-label for="ui_special_classes" value="Special CSS Classes" class="text-[10px] font-black uppercase tracking-widest text-zinc-400" />
                        <x-text-input id="ui_special_classes" name="ui[special_classes]" type="text" class="w-full" :value="old('ui.special_classes')" placeholder="e.g. text-pink-500" />
                    </div>

                    <div class="md:col-span-2 flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="ui[is_special]" value="1" class="sr-only peer" {{ old('ui.is_special') ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:width-5 after:transition-all dark:border-zinc-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-bold text-zinc-700 dark:text-zinc-300">Is Special (e.g. with animation)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900/50 rounded-3xl border border-zinc-200 dark:border-zinc-800 p-8 shadow-sm">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-6 flex items-center gap-2">
                    <span class="size-2 rounded-full bg-violet-500"></span>
                    Permissions
                </h3>

                <div class="space-y-4">
                    <p class="text-xs text-zinc-500 mb-4">Select roles that can access this feature. Leave empty for public access.</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($roles as $role)
                            <label class="flex items-center gap-3 p-4 rounded-2xl border border-zinc-100 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 cursor-pointer transition-all">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500" 
                                    {{ is_array(old('roles')) && in_array($role->name, old('roles')) ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-zinc-700 dark:text-zinc-300">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                    class="px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white text-base font-black rounded-2xl transition-all shadow-xl shadow-primary-600/20 active:scale-95">
                    Save Feature
                </button>
                <a href="{{ route('admin.features.index') }}"
                    class="px-8 py-4 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 text-base font-black rounded-2xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
