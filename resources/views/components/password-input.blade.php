@props([
    'name',
    'label' => 'Password',
    'placeholder' => '',
    'autocomplete' => 'new-password',
    'strength' => true,
    'confirm' => false,
    'target' => 'password',
])

<div x-data="passwordField({
    strength: @js($strength),
    confirm: @js($confirm),
    target: '{{ $target }}'
})" class="mt-4">

    <!-- Label -->
    <div class="flex items-center justify-between">
        <x-input-label :for="$name" :value="$label" />

        <!-- Confirm icon -->
        <template x-if="isConfirm">
            <div class="text-[10px] mb-1.5">

                <!-- Loading -->
                <svg x-show="checking" x-cloak class="h-4 w-4 animate-spin text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                </svg>

                <!-- Match -->
                <span x-show="!checking && matchState.ok" x-cloak class="text-green-500">
                    Mật khẩu trùng khớp
                </span>

                <!-- Not match -->
                <span x-show="!checking && !matchState.ok && showState" x-cloak class="text-red-500">
                    Mật khẩu không trùng khớp
                </span>
            </div>
        </template>

        <!-- Strength -->
        <template x-if="!isConfirm">
            <span class="text-[10px] mb-1.5" :class="strengthState.color" x-text="strengthState.label">
            </span>
        </template>
    </div>

    <!-- Input -->
    <div class="relative mt-1">
        <x-text-input :id="$name" :name="$name" class="block w-full pr-11"
            x-bind:type="show ? 'text' : 'password'" x-model="value" @input="handleInput" :placeholder="$placeholder"
            :autocomplete="$autocomplete" />

        <!-- Toggle -->
        <button type="button" @click="toggle"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 transition hover:cursor-pointer">

            <!-- Eye -->
            <svg x-show="!show" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12
                    18 19.5 12 19.5 2.25 12 2.25 12z" />
                <circle cx="12" cy="12" r="3" />
            </svg>

            <!-- Eye Slash -->
            <svg x-show="show" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18M10.58 10.58A3 3 0 0012 15
                    a3 3 0 002.42-4.42M9.88 5.1A9.77 9.77 0 0112 4.5
                    c6 0 9.75 7.5 9.75 7.5
                    a16.89 16.89 0 01-4.02 5.14M6.1 6.1A16.88 16.88 0 002.25 12
                    S6 19.5 12 19.5c1.61 0 3.09-.38 4.4-1.05" />
            </svg>
        </button>
    </div>

    <!-- Error -->
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
