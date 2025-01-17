<x-app-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900 dark:text-white">Create your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg px-8 py-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Name</label>
                        <div class="mt-2">
                            <input id="name" name="name" type="text" required autofocus autocomplete="name"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6 dark:bg-gray-800 dark:text-white dark:ring-gray-700"
                                value="{{ old('name') }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Email address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6 dark:bg-gray-800 dark:text-white dark:ring-gray-700"
                                value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6 dark:bg-gray-800 dark:text-white dark:ring-gray-700">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Confirm Password</label>
                        <div class="mt-2">
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6 dark:bg-gray-800 dark:text-white dark:ring-gray-700">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-10 text-center text-sm/6 text-gray-500 dark:text-gray-400">
                Already a member?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Sign in to your account</a>
            </p>
        </div>
    </div>
</x-app-layout>
