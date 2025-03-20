<x-guest-layout>
    <div class="flex flex-col items-center">
        <!-- Logo Abakura -->
        <img src="{{ asset('img/logo abakura.png') }}" alt="Logo Abakura" class="w-60 h-50 mt-0 mb-4">

        <!-- Home Button -->
        <a href="/" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9m0 0l9 9m-9-9v18" />
            </svg>
            <span class="text-sm font-medium">Home</span>
        </a>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NIK KTP -->
        <div>
            <x-input-label for="nik_ktp" :value="__('NIK KTP')" />
            <x-text-input id="nik_ktp" class="block mt-1 w-full" type="text" name="nik_ktp" :value="old('nik_ktp')" required autofocus autocomplete="nik_ktp" />
            <x-input-error :messages="$errors->get('nik_ktp')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div class="mt-4">
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" required autocomplete="alamat" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- HP -->
        <div class="mt-4">
            <x-input-label for="hp" :value="__('Nomor HP')" />
            <x-text-input id="hp" class="block mt-1 w-full" type="text" name="hp" :value="old('hp')" required autocomplete="hp" />
            <x-input-error :messages="$errors->get('hp')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
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
