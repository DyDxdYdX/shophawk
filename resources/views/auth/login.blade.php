<x-app-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg px-8 py-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mt-2">
                        <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Email address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6 dark:bg-gray-800 dark:text-white dark:ring-gray-700"
                                value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                            @if (Route::has('password.request'))
                                <div class="text-sm">
                                    <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                        Forgot password?
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required 
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </divcla>

                    <!-- Remember Me -->
                    <div class="block mt-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="mt-1">
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-4 text-center text-sm/6 text-gray-500 dark:text-gray-400">
                Not a member?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Register now</a>
            </p>
        </div>
    </div>
</x-app-layout>
