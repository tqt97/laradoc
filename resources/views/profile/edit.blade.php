<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-zinc-900 dark:text-white tracking-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="space-y-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-8 bg-white dark:bg-zinc-900 shadow-xl rounded-3xl border border-zinc-200/50 dark:border-zinc-800/50">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-8 bg-white dark:bg-zinc-900 shadow-xl rounded-3xl border border-zinc-200/50 dark:border-zinc-800/50">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-8 bg-white dark:bg-zinc-900 shadow-xl rounded-3xl border border-zinc-200/50 dark:border-zinc-800/50">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
