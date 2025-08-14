
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- level -->
<div class="mt-4">
    <x-input-label for="level_id" :value="__('Level')" />
    <select id="level_id" name="level_id" class="block mt-1 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach($levels as $level)
            <option value="{{ $level->id }}">{{ $level->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('level_id')" class="mt-2" />
</div>
<!-- Password -->
<!-- resources/views/auth/register.blade.php -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />
    <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500" 
                  type="password"
                  name="password"
                  required autocomplete="new-password" />
    
    <!-- Password Requirements -->
    <div class="mt-2 text-sm">
        <p class="font-medium text-gray-400">Password harus mengandung:</p>
        <ul class="mt-1 space-y-1">
            <li id="req-length" class="text-gray-400">• Minimal 8 karakter</li>
            <li id="req-mixedCase" class="text-gray-400">• Huruf besar & kecil</li>
            <li id="req-number" class="text-gray-400">• Minimal 1 angka</li>
            <li id="req-symbol" class="text-gray-400">• Minimal 1 simbol (!@#$%)</li>
        </ul>
    </div>
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />
    
    <!-- Tambahkan elemen untuk pesan validasi real-time -->
    <div id="password-confirm-error" class="mt-1 text-sm text-red-600 hidden">
        Password belum sama
    </div>

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
